<?php

namespace frontend\controllers;

use backend\models\business\Recharge;
use backend\models\UtilsConstants;
use common\models\User;
use Yii;
use backend\models\business\RechargeEtecsa;
use backend\models\business\RechargeEtecsaSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\GlobalFunctions;
use yii\helpers\Url;
use yii\db\Exception;

/**
 * RechargeEtecsaController implements the CRUD actions for RechargeEtecsa model.
 */
class RechargeEtecsaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'multiple_delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all RechargeEtecsa models.
     * @return mixed
     */
    public function actionRechargesProgram()
    {
        $searchModel = new RechargeEtecsaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(!User::isSuperAdmin()) {
            $dataProvider->query->andWhere(['user_id' => Yii::$app->user->id]);
        }

        $dataProvider->query->andWhere(['status' => UtilsConstants::RECHARGE_ETECSA_STATUS_PENDING])->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all RechargeEtecsa models.
     * @return mixed
     */
    public function actionRechargesHistory()
    {
        $searchModel = new RechargeEtecsaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(!User::isSuperAdmin()) {
            $dataProvider->query->andWhere(['user_id' => Yii::$app->user->id]);
        }

        $dataProvider->query->andWhere(['status' => UtilsConstants::RECHARGE_ETECSA_STATUS_COMPLETE])->all();

        return $this->render('index_history', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new RechargeEtecsa model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionNewRecharge($customer_id = null)
    {
        if(Recharge::getAvailableBalance() === 0) {
            GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Balance insuficiente, por favor recargue'));
            return $this->redirect(['recharge/create']);
        }

        $model = new RechargeEtecsa(['operator' => 1,'quantity' => 1,'user_id' => Yii::$app->user->id]);
        $model->loadDefaultValues();
        if($customer_id !== null)
        {
            $model->customer_id = $customer_id;
            $model->type = UtilsConstants::RECHARGE_TYPE_NAUTA;
        }

        if ($model->load(Yii::$app->request->post()))
        {
            $transaction = \Yii::$app->db->beginTransaction();

            try
            {
                $current_balance = Recharge::getAvailableBalance();
                if($model->total_cost > $current_balance) {
                    GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Balance insuficiente, por favor recargue'));
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }

                $error = 0;
                $type = (int) $model->type;

                if($type === UtilsConstants::RECHARGE_TYPE_MOBILE && empty($model->phone)) {
                    $model->addError('phone', Yii::t('backend', 'Teléfono a recargar no puede estar vacío.'));
                    $error++;
                }

                if($type === UtilsConstants::RECHARGE_TYPE_NAUTA && empty($model->email)) {
                    $model->addError('email', Yii::t('backend', 'Cuenta nauta a recargar no puede estar vacío.'));
                    $error++;
                }

                if($error > 0) {
                    GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Error creando el elemento'));

                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }

                if(empty($model->total_cost)) {
                    $model->total_cost = $model->quantity * $model->rechargeEtecsaType->cost;
                }

                if($model->save())
                {
                    //descontar del balance del usuario
                    User::updateBalance($model->user_id,UtilsConstants::UPDATE_NUMBER_MINUS,$model->total_cost);

                    $new_status = (int) $model->status;
                    if($new_status === UtilsConstants::RECHARGE_ETECSA_STATUS_PENDING) {
                        RechargeEtecsa::sendEmailAdmin($model->id, true);
                    }

                    $transaction->commit();

                    GlobalFunctions::addFlashMessage('success',Yii::t('backend','Elemento creado correctamente'));

                    return $this->redirect(['recharges-program']);
                }
                else
                {
                    GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Error creando el elemento'));
                }
            }
            catch (Exception $e)
            {
                GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Error, ha ocurrido una excepción creando el elemento'));
                $transaction->rollBack();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);

    }

    /**
     * Deletes an existing RechargeEtecsa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $status = (int) $model->status;
        if(!User::isSuperAdmin() && $status === UtilsConstants::RECHARGE_ETECSA_STATUS_COMPLETE) {
            throw new ForbiddenHttpException(Yii::t('backend','No está autorizado para realizar esta operación'));
        }

        $transaction = \Yii::$app->db->beginTransaction();

        try
        {
            if($model->delete())
            {
                User::updateBalance($model->user_id,UtilsConstants::UPDATE_NUMBER_PLUS,$model->total_cost);

                $transaction->commit();

                GlobalFunctions::addFlashMessage('success',Yii::t('backend','Elemento eliminado correctamente'));
            }
            else
            {
                GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Error eliminando el elemento'));
            }
        }
        catch (Exception $e)
        {
            GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Error, ha ocurrido una excepción eliminando el elemento'));
            $transaction->rollBack();
        }

        return $this->redirect(['recharges-program']);
    }

    /**
     * Finds the RechargeEtecsa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RechargeEtecsa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RechargeEtecsa::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('backend','La página solicitada no existe'));
        }
    }

}

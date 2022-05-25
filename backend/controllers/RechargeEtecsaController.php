<?php

namespace backend\controllers;

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
    public function actionIndex()
    {
        $searchModel = new RechargeEtecsaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(!User::isSuperAdmin()) {
            $dataProvider->query->andWhere(['user_id' => Yii::$app->user->id])->all();
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RechargeEtecsa model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new RechargeEtecsa model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Recharge::getAvailableBalance() === 0) {
            GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Balance insuficiente, por favor recargue'));
            return $this->redirect(['recharge/create']);
        }

        $model = new RechargeEtecsa(['operator' => 1,'quantity' => 1,'user_id' => Yii::$app->user->id]);
        $model->loadDefaultValues();

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
                        RechargeEtecsa::sendEmailAdmin($model->id);
                    }

                    $transaction->commit();

                    GlobalFunctions::addFlashMessage('success',Yii::t('backend','Elemento creado correctamente'));

                    return $this->redirect(['index']);
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
     * Updates an existing RechargeEtecsa model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if(isset($model) && !empty($model))
        {
            $old_status = (int) $model->status;

            if ($model->load(Yii::$app->request->post()))
            {
                $transaction = \Yii::$app->db->beginTransaction();

                try
                {
                    if($model->save())
                    {
                        $new_status = (int) $model->status;
                        if($old_status === UtilsConstants::RECHARGE_ETECSA_STATUS_PENDING && $new_status === UtilsConstants::RECHARGE_ETECSA_STATUS_COMPLETE) {
                            RechargeEtecsa::sendEmailApprov($model);
                        }

                        $transaction->commit();

                        GlobalFunctions::addFlashMessage('success',Yii::t('backend','Elemento actualizado correctamente'));

                        return $this->redirect(['index']);
                    }
                    else
                    {
                        GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Error actualizando el elemento'));
                    }
                }
                catch (Exception $e)
                {
                    GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Error, ha ocurrido una excepción actualizando el elemento'));
                    $transaction->rollBack();
                }
            }
        }
        else
        {
            GlobalFunctions::addFlashMessage('warning',Yii::t('backend','El elemento buscado no existe'));
        }

        return $this->render('update', [
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

        return $this->redirect(['index']);
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

    /**
    * Bulk Deletes for existing RechargeEtecsa models.
    * If deletion is successful, the browser will be redirected to the 'index' page.
    * @return mixed
    */
    public function actionMultiple_delete()
    {
        if(Yii::$app->request->post('row_id'))
        {
            $transaction = \Yii::$app->db->beginTransaction();

            try
            {
                $pk = Yii::$app->request->post('row_id');
                $count_elements = count($pk);

                $deleteOK = true;
                $nameErrorDelete = '';
                $contNameErrorDelete = 0;

                foreach ($pk as $key => $value)
                {
                    $model= $this->findModel($value);
                    $status = (int) $model->status;
                    if(!User::isSuperAdmin()) {
                        if($status === UtilsConstants::RECHARGE_ETECSA_STATUS_COMPLETE) {
                            $deleteOK=false;
                            $nameErrorDelete= $nameErrorDelete.'['.$model->name.'] ';
                            $contNameErrorDelete++;
                        } else {
                            if(!$model->delete())
                            {
                                $deleteOK=false;
                                $nameErrorDelete= $nameErrorDelete.'['.$model->name.'] ';
                                $contNameErrorDelete++;
                            }
                        }
                    } else {
                        if(!$model->delete())
                        {
                            $deleteOK=false;
                            $nameErrorDelete= $nameErrorDelete.'['.$model->name.'] ';
                            $contNameErrorDelete++;
                        }
                    }
                }

                if($deleteOK)
                {
                    if($count_elements === 1)
                    {
                        GlobalFunctions::addFlashMessage('success',Yii::t('backend','Elemento eliminado correctamente'));
                    }
                    else
                    {
                        GlobalFunctions::addFlashMessage('success',Yii::t('backend','Elementos eliminados correctamente'));
                    }

                    $transaction->commit();
                }
                else
                {
                    if($count_elements === 1)
                    {
                        if($contNameErrorDelete===1)
                        {
                            GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Error eliminando el elemento').': <b>'.$nameErrorDelete.'</b>');
                        }
                    }
                    else
                    {
                        if($contNameErrorDelete===1)
                        {
                            GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Error eliminando el elemento').': <b>'.$nameErrorDelete.'</b>');
                        }
                        elseif($contNameErrorDelete>1)
                        {
                            GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Error eliminando los elementos').': <b>'.$nameErrorDelete.'</b>');
                        }
                    }
                }
            }
            catch (Exception $e)
            {
                GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Error, ha ocurrido una excepción eliminando el elemento'));
                $transaction->rollBack();
            }

            return $this->redirect(['index']);
        }
    }

}

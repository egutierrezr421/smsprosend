<?php

namespace backend\controllers;

use backend\models\business\Recharge;
use backend\models\UtilsConstants;
use common\models\User;
use Yii;
use backend\models\business\Sms;
use backend\models\business\SmsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\GlobalFunctions;
use yii\helpers\Url;
use yii\db\Exception;

/**
 * SmsController implements the CRUD actions for Sms model.
 */
class SmsController extends Controller
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
     * Lists all Sms models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SmsSearch();
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
     * Displays a single Sms model.
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
     * Creates a new Sms model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Recharge::getAvailableBalance() === 0) {
            GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Balance insuficiente, por favor recargue'));
            return $this->redirect(['index']);
        }

        $model = new Sms();
        $model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post()))
        {
            $transaction = \Yii::$app->db->beginTransaction();

            try
            {
                $model->cost = $model->country->sms_price;
                $current_balance = Recharge::getAvailableBalance();
                if($model->cost > $current_balance) {
                    GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Balance insuficiente, por favor recargue'));
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }

                if($model->sendSms() && $model->save())
                {
                    $transaction->commit();

                    GlobalFunctions::addFlashMessage('success',Yii::t('backend','Sms enviado correctamente'));

                    return $this->redirect(['index']);
                }
                else
                {
                    GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Error enviando el sms'));
                }
            }
            catch (Exception $e)
            {
                GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Error, ha ocurrido una excepción enviando el sms'));
                $transaction->rollBack();
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);

    }

    /**
     * Updates an existing Sms model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if(isset($model) && !empty($model))
        {
            if ($model->load(Yii::$app->request->post()))
            {
                $transaction = \Yii::$app->db->beginTransaction();

                try
                {
                    if($model->save())
                    {
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
     * Deletes an existing Sms model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $transaction = \Yii::$app->db->beginTransaction();

        try
        {
            if($model->delete())
            {
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
     * Finds the Sms model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sms the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sms::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('backend','La página solicitada no existe'));
        }
    }

    /**
    * Bulk Deletes for existing Sms models.
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

                    if(!$model->delete())
                    {
                        $deleteOK=false;
                        $nameErrorDelete= $nameErrorDelete.'['.$model->name.'] ';
                        $contNameErrorDelete++;
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

    public function actionCheckStatus() {

        $query = Sms::find()->where(['status' => [UtilsConstants::SMS_STATUS_SENDED, UtilsConstants::SMS_STATUS_PENDING]]);

        if(!User::isSuperAdmin()) {
            $query->andWhere(['user_id' => Yii::$app->user->id]);
        }

        $models = $query->all();

        $count_items = count($models);

        $updateOK = true;
        $nameErrorUpdate = '';
        $contNameErrorUpdate  = 0;

        foreach ($models as $key => $model) {
            if(!$model->checkStatus()) {
                $updateOK=false;
                $nameErrorUpdate= $nameErrorUpdate.'['.$model->id.'] ';
                $contNameErrorUpdate ++;
            }
        }

        if($updateOK) {
            if($count_items === 1) {
                GlobalFunctions::addFlashMessage('success',Yii::t('backend','Estado chequeado correctamente'));
            } else {
                GlobalFunctions::addFlashMessage('success',Yii::t('backend','Estados chequeados correctamente'));
            }
        } else {
            if($count_items === 1) {
                if($contNameErrorUpdate ===1) {
                    GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Error chequeando estado del elemento').': <b>'.$nameErrorUpdate.'</b>');
                }
            } else {
                if($contNameErrorUpdate ===1) {
                    GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Error chequeando estado del elemento').': <b>'.$nameErrorUpdate.'</b>');
                } elseif($contNameErrorUpdate >1) {
                    GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Error chequeando estados de los elementos').': <b>'.$nameErrorUpdate.'</b>');
                }
            }
        }

        return $this->redirect(['index']);
    }

}

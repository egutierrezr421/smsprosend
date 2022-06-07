<?php

namespace frontend\controllers;

use backend\models\business\Customer;
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
use yii\db\Exception;

/**
 * SmsController implements the CRUD actions for Sms model.
 */
class SmsController extends Controller
{

    /**
     * Lists all Sms models.
     * @return mixed
     */
    public function actionHistorySms()
    {
        $searchModel = new SmsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(!User::isSuperAdmin()) {
            $dataProvider->query->andWhere(['user_id' => Yii::$app->user->id]);
        }

        $dataProvider->query->andWhere(['<>','status', UtilsConstants::SMS_STATUS_PROGRAMED])->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Sms models.
     * @return mixed
     */
    public function actionHistorySmsProgramed()
    {
        $searchModel = new SmsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if(!User::isSuperAdmin()) {
            $dataProvider->query->andWhere(['user_id' => Yii::$app->user->id]);
        }

        $dataProvider->query->andWhere(['status' => UtilsConstants::SMS_STATUS_PROGRAMED])->all();


        return $this->render('index_programed', [
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
    public function actionSendSms($customer_id = null)
    {
        if(Recharge::getAvailableBalance() === 0) {
            GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Balance insuficiente, por favor recargue'));
            return $this->redirect(['recharge/create']);
        }

        $model = new Sms();
        $model->loadDefaultValues();
        if($customer_id !== null) {
            $customer = Customer::findOne($customer_id);
            $model->customer_id = $customer_id;
            $model->receptor_country_id = $customer->country->id;
            $model->receptor_phone_number = $customer->phone_number;
        }

        if ($model->load(Yii::$app->request->post()))
        {
            $transaction = \Yii::$app->db->beginTransaction();

            try
            {
                $total_characters = strlen($model->message);
                $total_sms = ceil($total_characters/150);
                $model->count_consumed = $total_sms;
                $model->cost = $total_sms * $model->country->sms_price;
                $current_balance = Recharge::getAvailableBalance();
                $type = (int) $model->type;

                if($model->cost > $current_balance) {
                    GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Balance insuficiente, por favor recargue'));
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }

                $errors = 0;
                if($type === UtilsConstants::SMS_TYPE_PROGRAMED) {
                    $model->status = UtilsConstants::SMS_STATUS_PROGRAMED;

                    if(empty($model->programmer_date)) {
                        $model->addError('programmer_date','Fecha programado no puede estar vacío.');
                        $errors++;
                    } else {
                        $time_programed = strtotime($model->programmer_date);
                        $current_time = time();
                        if($time_programed <= $current_time) {
                            $model->addError('programmer_date','Fecha programado debe ser mayor a horario actual.');
                            $errors++;
                        }
                    }
                } else {
                    $model->programmer_date = null;
                }

                if($errors > 0) {
                    GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Error creando el sms'));
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }

                if($model->save())
                {
                    if($type === UtilsConstants::SMS_TYPE_NORMAL) {
                        if($model->sendSms()) {
                            $model->save(false);
                            //descontar del balance del usuario
                            User::updateBalance($model->user_id,UtilsConstants::UPDATE_NUMBER_MINUS,$model->cost);
                        }
                    }

                    $transaction->commit();

                    GlobalFunctions::addFlashMessage('success',Yii::t('backend','Sms creado correctamente'));

                    return $this->redirect(['send-sms']);
                }
                else
                {
                    GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Error creando el sms'));
                }
            }
            catch (Exception $e)
            {
                GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Error, ha ocurrido una excepción creando el sms'));
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

        return $this->redirect(['history-sms-programed']);
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

        return $this->redirect(['history-sms']);
    }

}

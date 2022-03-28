<?php

namespace backend\controllers;

use backend\models\business\GroupCustomer;
use backend\models\business\GroupCustomerHasSmsGroup;
use backend\models\business\Recharge;
use backend\models\business\Sms;
use backend\models\UtilsConstants;
use common\models\User;
use Yii;
use backend\models\business\SmsGroup;
use backend\models\business\SmsGroupSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\GlobalFunctions;
use yii\helpers\Url;
use yii\db\Exception;

/**
 * SmsGroupController implements the CRUD actions for SmsGroup model.
 */
class SmsGroupController extends Controller
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
     * Lists all SmsGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SmsGroupSearch();
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
     * Displays a single SmsGroup model.
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
     * Creates a new SmsGroup model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Recharge::getAvailableBalance() === 0) {
            GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Balance insuficiente, por favor recargue'));
            return $this->redirect(['index']);
        }

        $model = new SmsGroup();
        $model->loadDefaultValues();

        if ($model->load(Yii::$app->request->post()))
        {

            $transaction = \Yii::$app->db->beginTransaction();

            try
            {
                if($model->save())
                {
                    GroupCustomerHasSmsGroup::updateRelation($model,[],'group_customer_list','group_customer_id');
                    $sms_sended = 0;

                    foreach ($model->group_customer_list AS $value) {
                        $group = GroupCustomer::findOne($value);
                        if($group !== null) {
                            $all_customers = $group->customers;
                            foreach ($all_customers AS $idx => $customer)
                            {
                                $new_sms = new Sms([
                                    'user_id' => Yii::$app->user->id,
                                    'customer_id' => $model->customer_id,
                                    'message' => $model->message,
                                    'receptor_country_id' => $customer->country_id,
                                    'receptor_phone_number' => $customer->phone_number,
                                    'status' => UtilsConstants::SMS_STATUS_SENDED,
                                    'cost' => $customer->country->sms_price

                                ]);

                                $current_balance = Recharge::getAvailableBalance();
                                if($new_sms->cost > $current_balance) {
                                    if($sms_sended > 0) {
                                        GlobalFunctions::addFlashMessage('warning',Yii::t('backend','Solo {quantity} mensajes fueron enviados',['quantity' => $sms_sended]));
                                    }
                                    GlobalFunctions::addFlashMessage('danger',Yii::t('backend','Balance insuficiente, por favor recargue'));
                                    return $this->redirect(['index']);
                                }
                                else {
                                    $new_sms->sendSms();
                                    $new_sms->save();
                                    $sms_sended++;
                                }
                            }
                        }

                    }

                    $transaction->commit();

                    GlobalFunctions::addFlashMessage('success',Yii::t('backend','Mensajes enviados correctamente'));

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
     * Updates an existing SmsGroup model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if(isset($model) && !empty($model))
        {
            //BEGIN
            $customers_assigned = GroupCustomerHasSmsGroup::getGroupCustomersBySmsGroupId($id);

            $customers_assigned_ids= [];
            foreach ($customers_assigned as $value)
            {
                $customers_assigned_ids[]= $value['group_customer_id'];
            }

            $model->group_customer_list = $customers_assigned_ids;
            //END

            if ($model->load(Yii::$app->request->post()))
            {
                $transaction = \Yii::$app->db->beginTransaction();

                try
                {
                    GroupCustomerHasSmsGroup::updateRelation($model,$customers_assigned,'group_customer_list','group_customer_id');

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
     * Deletes an existing SmsGroup model.
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
     * Finds the SmsGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SmsGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SmsGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('backend','La página solicitada no existe'));
        }
    }

    /**
    * Bulk Deletes for existing SmsGroup models.
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

}

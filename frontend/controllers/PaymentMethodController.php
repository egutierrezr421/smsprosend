<?php

namespace frontend\controllers;

use Yii;
use backend\models\nomenclators\PaymentMethod;
use backend\models\nomenclators\PaymentMethodSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\GlobalFunctions;
use yii\helpers\Url;
use yii\db\Exception;
use yii\web\Response;

/**
 * PaymentMethodController implements the CRUD actions for PaymentMethod model.
 */
class PaymentMethodController extends Controller
{
    /**
     * Finds the PaymentMethod model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PaymentMethod the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PaymentMethod::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('backend','La página solicitada no existe'));
        }
    }

    public function actionGetPayment($id) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = $this->findModel($id);

        return ['success' => true, 'model' => $model];
    }

}

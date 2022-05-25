<?php

namespace frontend\controllers;

use backend\models\nomenclators\RechargeEtecsaType;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;
use yii\web\Controller;

/**
 * RechargeEtecsaTypeController implements the CRUD actions for RechargeEtecsaType model.
 */
class RechargeEtecsaTypeController extends Controller
{

    /**
     * Finds the RechargeEtecsaType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RechargeEtecsaType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RechargeEtecsaType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('backend','La página solicitada no existe'));
        }
    }

    public function actionGetData($id) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = $this->findModel($id);

        return ['success' => true, 'model' => $model];
    }

}

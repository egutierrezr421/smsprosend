<?php

namespace frontend\controllers;

use backend\models\UtilsConstants;
use Yii;
use backend\models\nomenclators\News;
use backend\models\nomenclators\NewsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\GlobalFunctions;
use yii\helpers\Url;
use yii\db\Exception;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
{

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionOffers()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['status' => 1, 'type' => UtilsConstants::NEWS_TYPE_OFFERS])->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}

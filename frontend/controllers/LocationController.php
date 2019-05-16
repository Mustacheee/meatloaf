<?php


namespace frontend\controllers;

use common\models\Location;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class LocationController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['get-locations'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ]
        ];
    }

    public function actionGetLocations()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $query                      = Yii::$app->request->get('q');
        if (empty($query)) {
            return [];
        }

        $locations = Location::find()->andWhere(['like', 'name', $query])->all();

        if (empty($locations)) {
            return [];
        }

        $out = ['results' => []];

        foreach ($locations as $location) {
            $out['results'][] = ['id' => $location->id, 'text' => $location->name];
        }

        return $out;
    }
}

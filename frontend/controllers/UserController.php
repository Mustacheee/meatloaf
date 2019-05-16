<?php

namespace frontend\controllers;

use app\models\Order;
use common\models\Role;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['get-managers'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ]
        ];
    }

    public function actionGetManagers()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $query = Yii::$app->request->get('q');
        if (empty($query)) {
            return [];
        }

        $users = User::find()->andWhere([
            'OR',
            ['like', 'first_name', $query],
            ['like', 'last_name', $query],
            ['like', 'email', $query]
        ])->andWhere(['<=', 'role_id', Role::ROLE_MANAGER])
        ->all();

        if (empty($users)) {
            return [];
        }

        $out = ['results' => []];

        foreach ($users as $user) {
            $out['results'][] = ['id' => $user->id, 'text' => $user->fullName];
        }

        return $out;
    }
}

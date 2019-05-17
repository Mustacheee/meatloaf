<?php

namespace frontend\controllers;

use app\models\Order;
use common\models\Location;
use common\models\Role;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\HttpException;

class OrderController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'approve', 'reject', 'delete', 'update'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ]
        ];
    }

    public function actionIndex()
    {
        $query = Order::find()
            ->with('createdBy')
            ->with('manager')
            ->with('location')
            ->where([
                'OR',
                ['created_by' => Yii::$app->user->id],
                ['manager_id' => Yii::$app->user->id]
            ])
            ->orderBy(['status' => SORT_ASC, 'date' => SORT_DESC]);



        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate()
    {
        $order = new Order();

        if ($order->load(Yii::$app->request->post()) && $order->save()) {
            Yii::$app->session->addFlash('success', 'The order has been created.');
            return $this->redirect('/order/');
        }

        $locations = ArrayHelper::map(Location::find()->orderBy('name')->all(), 'id', 'name');
        $managers = ArrayHelper::map(User::find()->where(['<=', 'role_id', Role::ROLE_MANAGER])->orderBy(['first_name' => SORT_ASC, 'last_name' => SORT_ASC])->all(), 'id', 'fullName');
        return $this->render('create', ['model' => $order, 'locations' => $locations, 'managers' => $managers]);
    }

    public function actionUpdate($id)
    {
        $order = Order::findOne($id);

        if ($order->load(Yii::$app->request->post()) && $order->save()) {
            Yii::$app->session->addFlash('success', 'The order has been updated.');
            return $this->redirect('/order/');
        }

        $locations = ArrayHelper::map(Location::find()->orderBy('name')->all(), 'id', 'name');
        $managers = ArrayHelper::map(User::find()->where(['<=', 'role_id', Role::ROLE_MANAGER])->orderBy(['first_name' => SORT_ASC, 'last_name' => SORT_ASC])->all(), 'id', 'fullName');
        return $this->render('create', ['model' => $order, 'locations' => $locations, 'managers' => $managers]);
    }

    public function actionDelete($id)
    {
        $order = Order::findOne($id);
        if ($order->delete()) {
            Yii::$app->session->addFlash('success', 'The order has been deleted.');
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionApprove($id)
    {
        $order = Order::findOne($id);

        if ($order->status !== Order::STATUS_PENDING) {
            throw new HttpException(403, "This order has already been decided upon");
        }

        $order->status = Order::STATUS_APPROVED;
        if ($order->save()) {
            Yii::$app->session->addFlash('success', 'The order has been approved.');
        }
        return $this->redirect('/order/');
    }

    public function actionReject($id)
    {
        $order = Order::findOne($id);

        if ($order->status !== Order::STATUS_PENDING) {
            throw new HttpException(403, "This order has already been decided upon");
        }

        $order->status = Order::STATUS_REJECTED;
        if ($order->save()) {
            Yii::$app->session->addFlash('error', 'The order has been rejected.');
        }
        return $this->redirect('/order/');
    }
}

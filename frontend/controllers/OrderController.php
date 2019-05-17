<?php

namespace frontend\controllers;

use app\models\Order;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
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
                        'actions' => ['index', 'create', 'approve', 'reject', 'delete'],
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
            return $this->render('confirmation');
        }

        return $this->render('create', ['model' => $order]);
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
        $order->save();
        Yii::$app->session->addFlash('success', 'The order has been approved.');
        return $this->redirect('/order');
    }

    public function actionReject($id)
    {
        $order = Order::findOne($id);

        if ($order->status !== Order::STATUS_PENDING) {
            throw new HttpException(403, "This order has already been decided upon");
        }

        $order->status = Order::STATUS_REJECTED;
        $order->save();
        Yii::$app->session->addFlash('error', 'The order has been rejected.');
        return $this->redirect('/order/');
    }
}

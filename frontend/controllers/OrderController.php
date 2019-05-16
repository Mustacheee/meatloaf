<?php

namespace frontend\controllers;

use app\models\Order;
use Yii;
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
                        'actions' => ['index', 'create', 'approve'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCreate()
    {
        $order = new Order();

        if ($order->load(Yii::$app->request->post()) && $order->save()) {
            return $this->render('confirmation');
        }

        return $this->render('create', ['model' => $order]);
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
        return $this->redirect('/order/');
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

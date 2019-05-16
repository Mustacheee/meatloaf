<?php

namespace frontend\controllers;

use app\models\Order;
use Yii;

class OrderController extends \yii\web\Controller
{
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

}

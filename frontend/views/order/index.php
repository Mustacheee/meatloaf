<?php
use app\models\Order;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
/**
 * @var Order[] $pending
 * @var Order[] $completed
 * @var ActiveDataProvider $dataProvider
 */
?>
<?=  GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'date',
        'count',
        'restaurant_name',
        'restaurant_link',
        [
            'label' => 'Requested Approver',
            'value' => function (Order $data) {
                return $data->manager->fullName;
            }
        ],
        [
            'label' => 'Submitted By',
            'value' => function (Order $data) {
                return $data->createdBy->fullName;
            }
        ],
        'restrictions',
        'notes',
        [
            "label" => 'Status',
            'value' => function (Order $data) {
                return $data->getStatusString();
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete} {accept} {reject}',
            'buttons' => [
                'accept' => function($url, Order $model, $key) {
                    return $model->isPending() ?  Html::a('Approve', "/order/approve/{$model->id}") : '';
                },
                'reject' => function($url, Order $model, $key) {
                    return $model->isPending() ?  Html::a('Reject', "/order/reject/{$model->id}") : '';
                },
            ]
        ],
    ],
]);

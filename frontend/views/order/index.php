<?php
use app\models\Order;
use common\models\Role;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var Order[] $pending
 * @var Order[] $completed
 * @var ActiveDataProvider $dataProvider
 */

$isAdmin = Yii::$app->user->identity->role->isAtLeast(Role::ROLE_SYS_ADMIN);
$userId = Yii::$app->user->id;
?>
<?=  GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'date',
        'count',
        [
            'label' => 'Meeting Location',
            'value' => function (Order $order) {
                return $order->location->name;
            }
        ],
        'restaurant_name',
        [
            'label' => 'Restaurant Menu Link',
            'format' => 'html',
            'value' => function (Order $data) {
                return empty($data->restaurant_link) ? '' :
                    Html::a($data->restaurant_name, Url::to($data->restaurant_link, 'https'));
            }
        ],
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
        [
            'label' => 'Dietary Restrictions',
            'format' => 'html',
            'value' => function (Order $data) {
                if (empty($data->restrictions)) {
                    return '';
                }

                $value = '<ul>';
                foreach ($data->restrictions as $restriction) {
                    $value .= "<li>{$restriction}</li>";
                }
                return $value . '</ul>';
            }
        ],
        'notes',
        [
            "label" => 'Status',
            'value' => function (Order $data) {
                return $data->getStatusString();
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{myUpdate} {delete} {accept} {reject}',
            'buttons' => [
                'myUpdate' => function($url, Order $model, $key) use ($isAdmin, $userId) {
                    if ($isAdmin || $model->created_by === $userId || $model->manager_id === $userId) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', "/order/update/{$model->id}");
                    }
                },
                'delete' => function($url, Order $model, $key) use ($isAdmin, $userId) {
                    if ($isAdmin || $model->created_by === $userId || $model->manager_id === $userId) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', "/order/delete/{$model->id}");
                    }
                },
                'accept' => function($url, Order $model, $key) use ($isAdmin, $userId) {
                    return ($model->isPending() && ($isAdmin || $model->manager_id === $userId))  ?  Html::a('<span class="glyphicon glyphicon-ok"></span>', "/order/approve/{$model->id}") : '';
                },
                'reject' => function($url, Order $model, $key) use ($isAdmin, $userId) {
                    return ($model->isPending() && ($isAdmin || $model->manager_id === $userId))?  Html::a('<span class="glyphicon glyphicon-remove"></span>', "/order/reject/{$model->id}") : '';
                },
            ]
        ],
    ],
]);

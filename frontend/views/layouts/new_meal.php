<?php
use app\models\Order;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var Order $model
 */
?>
<div>
    <h1>Hey you've got a new meal to approve:</h1>
    <table>
        <?php foreach ($model->attributes as $attribute => $value) : ?>
            <tr><td><?= $attribute?></td> : <td><?= $value ?></td></tr>
        <?php endforeach; ?>
    </table>
    <?= Html::a('Approve', Url::toRoute("/order/approve/{$model->id}", 'http'))?>
    <?= Html::a('Reject', Url::toRoute("/order/reject/{$model->id}", 'http'))?>
</div>

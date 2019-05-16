<?php
use app\models\Order;
use yii\helpers\Html;
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
    <?= Html::a('Approve', "/order/{$model->id}/approve")?>
    <?= Html::a('Reject', "/order/{$model->id}/reject")?>
</div>

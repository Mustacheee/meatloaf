<?php
use app\models\Order;
use yii\helpers\Html;
/**
 * @var Order[] $pending
 * @var Order[] $completed
 */
?>
<div>
    <div id="pending-orders">
        <h2>Pending: <?= count($pending) ?></h2>
        <table>
            <?php foreach ($pending as $order) : ?>
                <tr>
                    <td><?= $order->id ?></td>
                    <td><?= $order->date ?></td>
                    <td><?= $order->created_by ?></td>
                    <td><?= $order->restaurant_name ?></td>
                    <td><?= $order->count ?></td>
                </tr>
                <tr>
                    <td><?= Html::a('Approve', "/order/approve/{$order->id}")?></td>
                    <td><?= Html::a('Reject', "/order/reject/{$order->id}")?></td>
                </tr>
            <?php endforeach; ?>
        </table>

    </div>

    <div id="completed-orders">
        <h2>Completed: <?= count($completed) ?></h2>
        <table>
            <?php foreach ($completed as $order) : ?>
                <tr>
                    <td><?= $order->id ?></td>
                    <td><?= $order->date ?></td>
                    <td><?= $order->created_by ?></td>
                    <td><?= $order->restaurant_name ?></td>
                    <td><?= $order->count ?></td>
                    <td><?= $order->getStatusString() ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

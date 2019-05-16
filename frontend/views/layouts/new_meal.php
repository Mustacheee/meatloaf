<?php

use yii\helpers\Html;
?>
<div>
    <h1>Hey you've got a new meal to approve:</h1>
    <table>
        <?php foreach ($model->attributes as $attribute => $value) : ?>
            <tr><td><?= $attribute?></td> : <td><?= $value ?></td></tr>
        <?php endforeach; ?>
    </table>
</div>

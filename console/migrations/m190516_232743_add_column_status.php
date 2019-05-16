<?php

use yii\db\Migration;

/**
 * Class m190516_232743_add_column_status
 */
class m190516_232743_add_column_status extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('order', 'status', $this->integer(2)->defaultValue(0)->after('notes'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('order', 'status');
    }
}

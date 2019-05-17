<?php

use yii\db\Migration;

/**
 * Class m190516_203459_create_table_order
 */
class m190516_203459_create_table_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'date' => $this->dateTime(),
            'count' => $this->integer()->defaultValue(1),
            'restaurant_name' => $this->string()->notNull(),
            'restaurant_link' => $this->string()->defaultValue(null),
            'manager_id' => $this->integer()->notNull(),
            'location_id' => $this->integer(),
            'restrictions' => $this->text(),
            'notes' => $this->text(),
            'created_by' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
            'updated_by' => $this->integer()->notNull()
        ], $tableOptions);

        $this->addForeignKey('fk_orders_manager', '{{%order}}', 'manager_id', \common\models\User::tableName(), 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order}}');
    }
}

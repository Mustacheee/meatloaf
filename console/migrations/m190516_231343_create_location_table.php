<?php
use yii\db\Migration;

/**
 * Handles the creation of table `{{%location}}`.
 */
class m190516_231343_create_location_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            '{{%location}}',
            [
                'id' => $this->primaryKey(),
                'name' => $this->string(32)->notNull(),
            ]
        );

        $this->addForeignKey(
            'fk_orders_location',
            'order',
            'location_id',
            '{{%location}}',
            'id'
        );

        $this->insert('{{%location}}', [
            'name' => 'Balboa Park'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_orders_location', 'order');
        $this->dropTable('{{%location}}');
    }
}

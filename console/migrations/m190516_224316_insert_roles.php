<?php

use common\models\Role;
use yii\db\Migration;

/**
 * Class m190516_224316_insert_roles
 */
class m190516_224316_insert_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert(Role::tableName(), [
            'name' => 'DEV',
            'id' => Role::ROLE_DEV,
        ]);

        $this->insert(Role::tableName(), [
            'name' => 'Sys Admin',
            'id' => Role::ROLE_SYS_ADMIN,
        ]);

        $this->insert(Role::tableName(), [
            'name' => 'Manager',
            'id' => Role::ROLE_MANAGER,
        ]);

        $this->insert(Role::tableName(), [
            'name' => 'User',
            'id' => Role::ROLE_USER,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}

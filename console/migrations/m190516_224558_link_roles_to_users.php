<?php

use common\models\Role;
use common\models\User;
use yii\db\Migration;

/**
 * Class m190516_224558_link_roles_to_users
 */
class m190516_224558_link_roles_to_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk_users_role', User::tableName(), 'role_id', Role::tableName(), 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_users_role', User::tableName());
    }
}

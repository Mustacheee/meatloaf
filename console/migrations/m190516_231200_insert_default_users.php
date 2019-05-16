<?php

use yii\db\Migration;

/**
 * Class m190516_231200_insert_default_users
 */
class m190516_231200_insert_default_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("
        INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `role_id`, `auth_key`, `password_hash`, `password_reset_token`, `status`, `created_at`, `updated_at`, `verification_token`)
        VALUES
	    (1, 'Benjamin', 'De La Torre', 'bdelatorre@paylease.com', 1, 'WJOWCQx9GWcPhBcS6gw8WLYYsg3GI_R9', '$2y$13\$eyTTMmuzrHsE/dG6q4w6e.2MdX/eQsVqGlDB9vb/2Vn1JpCIfnTf6', NULL, 10, 1558047627, 1558047627, NULL);
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}

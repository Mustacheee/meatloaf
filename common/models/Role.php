<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "role".
 *
 * @property int $id
 * @property string $name
 */
class Role extends \yii\db\ActiveRecord
{
    const ROLE_DEV       = 1;
    const ROLE_SYS_ADMIN = 2;
    const ROLE_MANAGER   = 3;
    const ROLE_USER      = 4;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'   => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @param int $roleId
     * @return bool
     */
    public function isAtLeast(int $roleId)
    {
        return $this->id <= $roleId;
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $date
 * @property string $time
 * @property int $count
 * @property string $restaurant_name
 * @property string $restaurant_link
 * @property string $location
 * @property string $manager_email
 * @property string $restrictions
 * @property string $notes
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 * @property int $updated_by
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    public function beforeValidate()
    {
        $this->date = empty($this->date) ? null : date('Y-m-d', strtotime($this->date));
        return parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
        $this->restrictions = empty($this->restrictions) ? null : json_encode($this->restrictions);
        $this->updated_by = 1;
        $this->created_by = 1;
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'time', 'created_at', 'updated_at'], 'safe'],
            [['count', 'created_by', 'updated_by'], 'integer'],
            [['restaurant_name', 'location', 'manager_email'/*, 'created_by', 'updated_by'*/], 'required'],
            [['notes'], 'string'],
            [['restaurant_name', 'restaurant_link', 'location', 'manager_email'], 'string', 'max' => 255],
            [['date'], 'date', 'format' => 'php:Y-m-d']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'time' => 'Time',
            'count' => 'Count',
            'restaurant_name' => 'Restaurant Name',
            'restaurant_link' => 'Restaurant Link',
            'location' => 'Location',
            'manager_email' => 'Manager Email',
            'restrictions' => 'Restrictions',
            'notes' => 'Notes',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}

<?php

namespace app\models;

use SendGrid\Mail\Mail;
use Yii;
use yii\db\ActiveRecord;
use yii\log\Logger;
use YiiMailer;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $date
 * @property int $count
 * @property string $restaurant_name
 * @property string $restaurant_link
 * @property int $location_id
 * @property string $manager_id
 * @property string $restrictions
 * @property string $notes
 * @property int $status
 * @property int $created_by
 * @property string $created_at
 * @property string $updated_at
 * @property int $updated_by
 */
class Order extends ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    public function beforeValidate()
    {
        $this->created_by = Yii::$app->user->identity->id;
        $this->updated_by = Yii::$app->user->identity->id;
        return parent::beforeValidate();
    }

    public function validate($attributeNames = null, $clearErrors = true)
    {
        return parent::validate($attributeNames, $clearErrors);
    }

    public function beforeSave($insert)
    {
        $this->date = empty($this->date) ? null : (new \DateTime($this->date))->format('Y-m-d H:i:s');
        $this->restrictions = empty($this->restrictions) ? null : json_encode($this->restrictions);
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            $this->sendEmail();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['count', 'created_by', 'updated_by'], 'integer'],
            [['restaurant_name', 'manager_id', 'location_id', 'created_by', 'updated_by', 'count'], 'required'],
            [['notes'], 'string'],
            [['restaurant_name', 'restaurant_link'], 'string', 'max' => 255],
            [['date'], 'datetime', 'format' => 'php:m/d/Y h:i'],
            ['status', 'in', 'range' => [self::STATUS_APPROVED, self::STATUS_PENDING, self::STATUS_REJECTED]],
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
            'count' => 'Count',
            'restaurant_name' => 'Restaurant Name',
            'restaurant_link' => 'Restaurant Menu Link',
            'location_id' => 'Location',
            'manager_id' => 'Manager',
            'restrictions' => 'Restrictions',
            'notes' => 'Notes',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public function getStatusString()
    {
        switch($this->status) {
            case self::STATUS_PENDING:
                return "Pending";
            case self::STATUS_APPROVED:
                return "Approved";
            case self::STATUS_REJECTED:
                return "Rejected";
            default:
                Yii::getLogger()->log("Unknown status", Logger::LEVEL_ERROR);
        }
    }

    private function sendEmail()
    {
        $to = YII_ENV_DEV ? Yii::$app->params['testEmail'] : $this->manager_email;

        $email = new Mail();
        $email->setFrom(Yii::$app->params['senderEmail'], "Meatloaf Request");
        $email->setSubject("New Meal Request for" . date('m/d/Y', strtotime($this->date)));
        $email->addTo($to, "Manager Name");
        $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
        $email->addContent(
            "text/html", Yii::$app->view->render('@frontend/views/layouts/new_meal', ['model' => $this]));
        $sendgrid = new \SendGrid(Yii::$app->params['sendgrid.apikey']);
        $response = $sendgrid->send($email);
    }
}

<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property int $id
 * @property int $user_id
 * @property string $message
 * @property string $date
 * @property string $status
 *
 * @property User $user
 */
class Message extends \yii\db\ActiveRecord
{
    const MESSAGE_REJECTED = 'rejected';
    const MESSAGE_APPROVED = 'approved';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'message' => 'Message',
            'date' => 'Date',
            'status' => 'Status',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function isRejected()
    {
        return $this->status === self::MESSAGE_REJECTED;
    }

    public function isApproved()
    {
        return $this->status === self::MESSAGE_APPROVED;
    }
}

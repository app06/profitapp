<?php

namespace app\models;

use yii\base\Model;

/**
 * MessageAddForm form
 */
class MessageAddForm extends Model
{
    public $message;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['message', 'trim'],
            ['message', 'required'],
            ['message', 'string'],
        ];
    }
}

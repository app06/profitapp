<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * UserUpdateForm form
 */
class UserUpdateForm extends Model
{
    public $id;
    public $role;

    public function __construct(User $user, $config = [])
    {
        $this->id = $user->id;
        $this->role = $user->role;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['role', 'validateOwnerRole'],
            ['role', 'trim'],
            ['role', 'required'],
            ['role', 'in', 'range' => User::getUserRoles()],
        ];
    }

    public function validateOwnerRole($attribute, $params)
    {
        if ($this->id === Yii::$app->user->id) {
            $this->addError($attribute, 'You cannot change your role.');
        }
    }
}

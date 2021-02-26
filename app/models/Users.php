<?php

namespace app\models;

use tachyon\db\activeRecord\ActiveRecord;

/**
 * Модель пользователей
 *
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class Users extends ActiveRecord
{
    const STATUS_NOTCONFIRMED = 0;
    const STATUS_CONFIRMED = 1;

    protected static $tableName = 'users';
    protected $pkName = 'id';
    protected $fields = ['username', 'email', 'password', 'confirmed', 'confirm_code'];
    protected $attributeNames = [
        'username'     => 'Логин',
        'email'        => 'Email',
        'password'     => 'Пароль',
        'confirmed'    => 'Подтвержден',
        'confirm_code' => 'Код подтверждения',
    ];

    /**
     * Извлекает пользователя
     *
     * @param array $attributes
     *
     * @return Users | null
     */
    public function findByPassword($attributes)
    {
        if (
            $user = $this->findOne(['username' => $attributes['username']])
            and password_verify($attributes['password'], $user->password)
        ) {
            return $user;
        }
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'unique'],
            'password' => ['required'],
            'email'    => ['unique'],
        ];
    }

    /**
     * Добавляет нового пользователя
     *
     * @param array $attributes
     *
     * @return Users
     */
    public function add($attributes)
    {
        $this->validate($attributes);
        if ($attributes['password'] !== $attributes['password_confirm']) {
            $this->addError('password', 'Пароли должны совпадать.');
        }
        if ($this->hasErrors()) {
            return $this;
        }
        $attributes['password'] = password_hash($attributes['password'], PASSWORD_DEFAULT);
        $attributes['confirm_code'] = md5(microtime());
        $this->setAttributes($attributes);
        $this->insert();
        return $this;
    }
}

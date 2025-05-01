<?php

namespace app\models;

use tachyon\db\activeRecord\ActiveRecord;
use tachyon\exceptions\DBALException;
use tachyon\exceptions\ValidationException;

/**
 * Модель пользователей
 *
 * @author imndsu@gmail.com
 */
class Users extends ActiveRecord
{
    public const STATUS_UNCONFIRMED = 0;
    public const STATUS_CONFIRMED = 1;

    protected static string $tableName = 'users';
    protected string $pkName = 'id';
    protected array $fields = ['username', 'email', 'password', 'confirmed', 'confirm_code'];
    protected array $attributeNames = [
        'username'     => 'Логин',
        'email'        => 'Email',
        'password'     => 'Пароль',
        'confirmed'    => 'Подтвержден',
        'confirm_code' => 'Код подтверждения',
    ];

    /**
     * Извлекает пользователя
     */
    public function findByPassword(array $attributes): ?Users
    {
        [ $username, $password ] = array_values($attributes);

        if (
                $user = $this->findOne(compact('username'))
            and password_verify($password, $user->password)
        ) {
            return $user;
        }
        return null;
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
     */
    public function add(array $attributes): Users
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

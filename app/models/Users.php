<?php

namespace app\models;

use tachyon\db\activeRecord\ActiveRecord;
use tachyon\exceptions\DBALException;
use tachyon\exceptions\ValidationException;

/**
 * Модель пользователей
 *
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
class Users extends ActiveRecord
{
    public const STATUS_NOTCONFIRMED = 0;
    public const STATUS_CONFIRMED = 1;

    protected static string $tableName = 'users';
    /**
     * @var string
     */
    protected string $pkName = 'id';
    /**
     * @var string[]
     */
    protected array $fields = ['username', 'email', 'password', 'confirmed', 'confirm_code'];
    /**
     * @var array|string[]
     */
    protected array $attributeNames = [
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
     * @throws DBALException
     */
    public function findByPassword(array $attributes): ?Users
    {
        if (
                $user = $this->findOne(['username' => $attributes['username']])
            and password_verify($attributes['password'], $user->password)
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
     *
     * @param array $attributes
     *
     * @return Users
     * @throws ValidationException | DBALException
     */
    public function add($attributes): Users
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

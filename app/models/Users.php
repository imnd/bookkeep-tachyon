<?php
namespace app\models;

/**
 * Модель пользователей
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2018 IMND
 */ 
class Users extends \tachyon\db\activeRecord\ActiveRecord
{
    const STATUS_NOTCONFIRMED = 0;
    const STATUS_CONFIRMED = 1;

    protected static $tableName = 'users';
    protected $pkName = 'id';
    protected $fields = array('username', 'email', 'password_hash', 'confirmed', 'confirm_code');
    protected $attributeNames = array(
        'username' => 'Логин',
        'email' => 'Email',
        'password' => 'Пароль',
        'confirmed' => 'Подтвержден',
        'confirm_code' => 'Код подтверждения',
    );
    /**
     * соль для шифровки пароля
     * @var string $salt
     */
    protected static $salt = 'cjwgu-k6837hfka--eifjo3ji34bceb76ta2vdu';

    /**
     * Извлекает пользователя
     * 
     * @param array $attributes
     * @return Users
     */
    public function find($attributes)
    {
        $attributes['password_hash'] = $this->hashPassword($attributes['password']);
        unset($attributes['password']);
        return $this->findOne($attributes);
    }

    /**
     * Добавляет нового пользователя
     * 
     * @param array $attributes
     * @return Users
     */
    public function add($attributes)
    {
        if ($this->findOne(array(
            'username' => $attributes['username'],
        ))) {
            $this->addError('username', "Пользователь {$attributes['username']} уже существует");
        }
        if ($this->findOne(array(
            'email' => $attributes['email'],
        ))) {
            $this->addError('email', "Пользователь с email {$attributes['email']} уже существует");
        }
        if (empty($attributes['password'])) {
            $this->addError('password', "Пароль обязателен.");
        }
        if ($attributes['password']!==$attributes['password_confirm']) {
            $this->addError('password', "Пароли должны совпадать.");
        }
        if ($this->hasErrors()) {
            return $this;
        }
        $attributes['password_hash'] = $this->hashPassword($attributes['password']);
        unset($attributes['password']);
        $attributes['confirm_code'] = $this->hashPassword(time());
        $this->setAttributes($attributes);

        $this->insert();
        return $this;
    }

    public function hashPassword($text)
    {
        return hash('md5', $text . self::$salt);
    }
}

<?php
namespace app\entities;

use tachyon\db\dataMapper\Entity;

/**
 * Класс сущности "Клиент"
 * 
 * @author Андрей Сердюк
 * @copyright (c) 2019 IMND
 */
class Client extends Entity
{
    protected $attributeCaptions = [
        'region_id' => 'район',
        'name' => 'название',
        'address' => 'адрес',
        'telephone' => 'телефон',
        'fax' => 'факс',
        'contactFullName' => 'контакт. лицо',
        'contactPost' => 'должность конт. лица',
        'account' => 'расчетный счет',
        'bank' => 'в банке',
        'INN' => 'ИНН',
        'KPP' => 'КПП',
        'BIK' => 'БИК',
        'sort' => 'порядок сортировки',
        'active' => 'активный',
    ];

    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $address;
    /**
     * @var string
     */
    protected $phone;
    /**
     * @var string
     */
    protected $fax;
    /**
     * @var string
     */
    protected $contactFullName;
    /**
     * @var string
     */
    protected $contactPost;
    /**
     * @var string
     */
    protected $account;
    /**
     * @var string
     */
    protected $bank;
    /**
     * @var int
     */
    protected $INN;
    /**
     * @var int
     */
    protected $KPP;
    /**
     * @var int
     */
    protected $BIK;
    /**
     * @var int
     */
    protected $sort;
    /**
     * @var int
     */
    protected $active;
    /**
     * @var int
     */
    protected $regionId;

    # GETTERS

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getFax()
    {
        return $this->fax;
    }

    public function getContactFullName()
    {
        return $this->contactFullName;
    }

    public function getContactPost()
    {
        return $this->contactPost;
    }

    public function getBank()
    {
        return $this->bank;
    }

    public function getAccount()
    {
        return $this->account;
    }

    public function getINN()
    {
        return $this->INN;
    }

    public function getKPP()
    {
        return $this->KPP;
    }

    public function getBIK()
    {
        return $this->BIK;
    }

    public function getSort()
    {
        return $this->sort;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function getRegionId()
    {
        return $this->regionId;
    }

    public function getAttributes(): array
    {
        return [
            'name' => $this->name,
            'address' => $this->address,
            'telephone' => $this->phone,
            'fax' => $this->fax,
            'contact_fio' => $this->contactFullName,
            'contact_post' => $this->contactPost,
            'account' => $this->bank,
            'bank' => $this->account,
            'INN' => $this->INN,
            'KPP' => $this->KPP,
            'BIK' => $this->BIK,
            'sort' => $this->sort,
            'active' => $this->active,
            'region_id' => $this->regionId,
        ];
    }

    public function fromState(array $state): Entity
    {
        $entity = clone($this);

        $entity->id = $state['id'];
        $entity->name = $state['name'] ?? null;
        $entity->address = $state['address'] ?? null;
        $entity->phone = $state['telephone'] ?? null;
        $entity->fax = $state['fax'] ?? null;
        $entity->contactFullName = $state['contact_fio'] ?? null;
        $entity->contactPost = $state['contact_post'] ?? null;
        $entity->account = $state['account'] ?? null;
        $entity->bank = $state['bank'] ?? null;
        $entity->INN = $state['INN'] ?? null;
        $entity->KPP = $state['KPP'] ?? null;
        $entity->BIK = $state['BIK'] ?? null;
        $entity->sort = $state['sort'] ?? null;
        $entity->active = $state['active'] ?? null;
        $entity->regionId = $state['region_id'] ?? null;

        //$entity->markClean();
        return $entity;
    }

    public function rules(): array
    {
        return [
            'name' => ['alphaExt', 'required'],
            'address, bank' => 'alphaExt',
            'INN, KPP, BIK, sort, active, region_id' => 'integer',
        ];
    }

    # Setters

    public function setName(string $value = null): Client
    {
        if (!is_null($value)) {
            $this->name = $value;
            $this->markDirty();
        }
        return $this;
    }

    public function setAddress(string $value = null): Client
    {
        if (!is_null($value)) {
            $this->address = $value;
            $this->markDirty();
        }
        return $this;
    }

    public function setPhone(string $value = null): Client
    {
        if (!is_null($value)) {
            $this->phone = $value;
            $this->markDirty();
        }
        return $this;
    }

    public function setFax(string $value = null): Client
    {
        if (!is_null($value)) {
            $this->fax = $value;
            $this->markDirty();
        }
        return $this;
    }

    public function setContactFullName(string $value = null): Client
    {
        if (!is_null($value)) {
            $this->contactFullName = $value;
            $this->markDirty();
        }
        return $this;
    }

    public function setContactPost(string $value = null): Client
    {
        if (!is_null($value)) {
            $this->contactPost = $value;
            $this->markDirty();
        }
        return $this;
    }

    public function setAccount(string $value = null): Client
    {
        if (!is_null($value)) {
            $this->account = $value;
            $this->markDirty();
        }
        return $this;
    }

    public function setBank(string $value = null): Client
    {
        if (!is_null($value)) {
            $this->bank = $value;
            $this->markDirty();
        }
        return $this;
    }

    public function setINN(int $value = null): Client
    {
        if (!is_null($value)) {
            $this->INN = $value;
            $this->markDirty();
        }
        return $this;
    }

    public function setKPP(int $value = null): Client
    {
        if (!is_null($value)) {
            $this->KPP = $value;
            $this->markDirty();
        }
        return $this;
    }

    public function setBIK(int $value = null): Client
    {
        if (!is_null($value)) {
            $this->BIK = $value;
            $this->markDirty();
        }
        return $this;
    }

    public function setSort(int $value = null): Client
    {
        if (!is_null($value)) {
            $this->sort = $value;
            $this->markDirty();
        }
        return $this;
    }

    public function setActive(int $value = null): Client
    {
        if (!is_null($value)) {
            $this->active = $value;
            $this->markDirty();
        }
        return $this;
    }

    public function setRegionId(int $value = null): Client
    {
        if (!is_null($value)) {
            $this->regionId = $value;
            $this->markDirty();
        }
        return $this;
    }

    public function setAttributes(array $state)
    {
        $this
            ->setName($state['name'] ?? null)
            ->setAddress($state['address'] ?? null)
            ->setPhone($state['telephone'] ?? null)
            ->setFax($state['fax'] ?? null)
            ->setContactFullName($state['contact_fio'] ?? null)
            ->setContactPost($state['contact_post'] ?? null)
            ->setAccount($state['account'] ?? null)
            ->setBank($state['bank'] ?? null)
            ->setINN($state['INN'] ?? null)
            ->setKPP($state['KPP'] ?? null)
            ->setBIK($state['BIK'] ?? null)
            ->setSort($state['sort'] ?? null)
            ->setActive($state['active'] ?? null)
            ->setRegionId($state['region_id'] ?: null)
        ;
    }
}

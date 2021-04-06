<?php
namespace app\traits;

/**
 * @author Андрей Сердюк
 * @copyright (c) 2020 IMND
 */
trait HasClient
{
    /**
     * @var int
     */
    protected ?int $clientId = null;
    /**
     * @var string
     */
    protected ?string $clientName = null;
    /**
     * @var string
     */
    protected string $clientAddress;
    /**
     * @var string
     */
    protected string $clientAccount;
    /**
     * @var string
     */
    protected string $clientBank;
    /**
     * @var string
     */
    protected string $clientINN;
    /**
     * @var string
     */
    protected string $clientKPP;
    /**
     * @var string
     */
    protected string $clientContactPost;
    /**
     * @var string
     */
    protected string $clientContactFio;

    /**
     * @return int
     */
    public function getClientId(): ?int
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    /**
     * @return string
     */
    public function getClientAddress(): string
    {
        return $this->clientAddress;
    }

    /**
     * @return string
     */
    public function getClientNameAndAddress(): ?string
    {
        $str = $this->clientName;
        if (!empty($this->clientAddress)) {
            $str .= " ({$this->clientAddress})";
        }
        return $str;
    }

    /**
     * @return string
     */
    public function getClientAccount(): string
    {
        return $this->clientAccount;
    }

    /**
     * @return string
     */
    public function getClientBank(): string
    {
        return $this->clientBank;
    }

    /**
     * @return string
     */
    public function getClientINN(): ?string
    {
        return $this->clientINN ?? null;
    }

    /**
     * @return string
     */
    public function getClientKPP(): ?string
    {
        return $this->clientKPP ?? null;
    }

    /**
     * @return string
     */
    public function getClientContactPost(): ?string
    {
        return $this->clientContactPost ?? null;
    }

    /**
     * @return string
     */
    public function getClientContactFio(): ?string
    {
        return $this->clientContactFio ?? null;
    }

    /**
     * @param int|null $value
     * @return self
     */
    public function setClientId(int $value = null): self
    {
        return $this->_setAttribute('clientId', $value);
    }

    /**
     * @param string|null $value
     * @return self
     */
    public function setClientAddress(string $value = null): self
    {
        return $this->_setAttribute('clientAddress', $value);
    }

    /**
     * @param string|null $value
     * @return self
     */
    public function setClientAccount(string $value = null): self
    {
        return $this->_setAttribute('clientAccount', $value);
    }

    /**
     * @param string|null $value
     * @return self
     */
    public function setClientBank(string $value = null): self
    {
        return $this->_setAttribute('clientBank', $value);
    }

    /**
     * @param string|null $value
     * @return self
     */
    public function setClientName(string $value = null): self
    {
        return $this->_setAttribute('clientName', $value);
    }

    /**
     * @param string|null $value
     * @return self
     */
    public function setClientINN(string $value = null): self
    {
        return $this->_setAttribute('clientINN', $value);
    }

    /**
     * @param string|null $value
     * @return self
     */
    public function setClientKPP(string $value = null): self
    {
        return $this->_setAttribute('clientKPP', $value);
    }

    /**
     * @param string|null $value
     * @return self
     */
    public function setClientContactPost(string $value = null): self
    {
        return $this->_setAttribute('clientContactPost', $value);
    }

    /**
     * @param string|null $value
     * @return self
     */
    public function setClientContactFio(string $value = null): self
    {
        return $this->_setAttribute('clientContactFio', $value);
    }
}

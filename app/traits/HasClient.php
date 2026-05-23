<?php
namespace app\traits;

/**
 * @author imndsu@gmail.com
 */
trait HasClient
{
    protected ?int $clientId = null;
    protected ?string $clientName = null;
    protected string $clientAddress;
    protected string $clientAccount;
    protected string $clientBank;
    protected string $clientINN;
    protected string $clientKPP;
    protected string $clientContactPost;
    protected string $clientContactFio;

    public function getClientId(): ?int
    {
        return $this->clientId;
    }

    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    public function getClientAddress(): string
    {
        return $this->clientAddress;
    }

    public function getClientNameAndAddress(): ?string
    {
        $str = $this->clientName;
        if (!empty($this->clientAddress)) {
            $str .= " ({$this->clientAddress})";
        }
        return $str;
    }

    public function getClientAccount(): string
    {
        return $this->clientAccount;
    }

    public function getClientBank(): string
    {
        return $this->clientBank;
    }

    public function getClientINN(): ?string
    {
        return $this->clientINN ?? null;
    }

    public function getClientKPP(): ?string
    {
        return $this->clientKPP ?? null;
    }

    public function getClientContactPost(): ?string
    {
        return $this->clientContactPost ?? null;
    }

    public function getClientContactFio(): ?string
    {
        return $this->clientContactFio ?? null;
    }

    public function setClientId(int $value = null): self
    {
        return $this->_setAttribute('clientId', $value);
    }

    public function setClientAddress(string $value = null): self
    {
        return $this->_setAttribute('clientAddress', $value);
    }

    public function setClientAccount(string $value = null): self
    {
        return $this->_setAttribute('clientAccount', $value);
    }

    public function setClientBank(string $value = null): self
    {
        return $this->_setAttribute('clientBank', $value);
    }

    public function setClientName(string $value = null): self
    {
        return $this->_setAttribute('clientName', $value);
    }

    public function setClientINN(string $value = null): self
    {
        return $this->_setAttribute('clientINN', $value);
    }

    public function setClientKPP(string $value = null): self
    {
        return $this->_setAttribute('clientKPP', $value);
    }

    public function setClientContactPost(string $value = null): self
    {
        return $this->_setAttribute('clientContactPost', $value);
    }

    public function setClientContactFio(string $value = null): self
    {
        return $this->_setAttribute('clientContactFio', $value);
    }
}

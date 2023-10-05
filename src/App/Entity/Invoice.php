<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM;
use Doctrine\ORM\Mapping\Column;

#[ORM\Mapping\Entity]
#[ORM\Mapping\Table(name: 'invoices')]
class Invoice
{
    #[ORM\Mapping\Id]
    #[Column]
    #[ORM\Mapping\GeneratedValue]
    private int $id;

    #[Column(type: Types::DECIMAL, precision: 10, scale: 4)]
    private float $amount;

    #[Column(name:'user_id')]
    private int $userId;

    #[Column(name: 'status')]
    private int $invoiceStatus;

    #[ORM\Mapping\ManyToOne(targetEntity: User::class, inversedBy: 'invoices')]
    private User $user;

    public function getId(): int
    {
        return $this->id;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;
        return $this;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(): self
    {
        $this->userId = $this->user->getId();
        return $this;
    }

    public function getInvoiceStatus(): int
    {
        return $this->invoiceStatus;
    }

    public function setInvoiceStatus(int $invoiceStatus): self
    {
        $this->invoiceStatus = $invoiceStatus;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): Invoice
    {
        $this->user = $user;
        return $this;
    }
}


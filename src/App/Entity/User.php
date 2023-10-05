<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'users')]
class User
{
    #[Id, Column(name:'id', type: Types::INTEGER, precision: 10), GeneratedValue]
    private int $id;

    #[Column(unique: true) ]
    private string $email;

    #[Column(name:'full_name')]
    private string $fullName;

    #[Column(name: 'is_active', type: Types::SMALLINT, precision: 6)]
    private bool $isActive;

    #[Column(name:'created_at', type: TYPES::DATETIME_MUTABLE)]
    private \DateTime $createdAt;

    #[OneToMany(mappedBy: 'user', targetEntity: Invoice::class, cascade: ['persist', 'remove'])]
    private Collection $invoices;

    public function __construct()
    {
        $this->invoices = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): User
    {
        $this->fullName = $fullName;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): User
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): User
    {
        $this->createdAt = $createdAt;
        return $this;
    }
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }
    public function addInvoice(Invoice $invoice)
    {
        $invoice->setUser($this);
        $this->invoices->add($invoice);
        return $this;
    }
}

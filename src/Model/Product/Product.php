<?php

namespace Shop\Model\Product;

use DateTimeImmutable;
use Shop\Model\Entity;

class Product implements Entity
{
    private int $id;

    private string $name;

    private array $badges;

    private bool $isActive;

    private DateTimeImmutable $createdAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBadges(): array
    {
        return $this->badges;
    }

    public function addBadge(string $badge): self
    {
        $this->badges[] = $badge;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}

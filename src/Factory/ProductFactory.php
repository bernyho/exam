<?php

namespace Shop\Factory;

use DateTimeImmutable;
use Shop\Model\Product\Product;

/**
 * dummy product factory
 */
readonly class ProductFactory
{
    public function create(int $id): Product
    {
        return (new Product())
            ->setId($id)
            ->setName($this->getRandomProductName())
            ->addBadge($this->getRandomBadge())
            ->setCreatedAt(new DateTimeImmutable)
            ->setIsActive($this->getRandomActive())
        ;
    }

    private function getRandomActive(): bool
    {
        return (rand(1,2) === 1);
    }

    private function getRandomProductName(): string
    {
        $names = array(
            'Mug',
            'Desk',
            'Chair',
            'Ball',
            'Screen wipes',
            'Tissues',
            'T-shirt',
            'Rope',
            'Apple',
            'Pineapple',
            'Lemon',
        );

        return $names[rand(0, count($names) -1)];
    }

    private function getRandomBadge(): string
    {
        $badges = array(
            'sale',
            'new',
            'blackFriday',
            'lastChance',
        );

        return $badges[rand(0, count($badges) -1)];
    }

}
<?php

namespace Shop\Service;

use Shop\Factory\ProductFactory;
use Shop\Model\Product\Product;
use Shop\Service\Driver\IElasticSearchDriver;

readonly class ProductFinder implements IElasticSearchDriver
{
    public function findById(int $id): Product
    {
        // fake product
        $productFactory = new ProductFactory();

        return $productFactory->create($id);
    }
}
<?php

namespace Shop\Repository;

use Shop\Factory\ProductFactory;
use Shop\Model\Product\Product;
use Shop\Service\Driver\IMysqlDriver;

readonly class ProductRepository implements IMysqlDriver
{
    public function findProduct(int $id): Product
    {
        // fake product
        $productFactory = new ProductFactory();

        return $productFactory->create($id);
    }
}
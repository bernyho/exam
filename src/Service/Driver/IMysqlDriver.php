<?php

namespace Shop\Service\Driver;

use Shop\Model\Product\Product;

interface IMysqlDriver
{
    public function findProduct(int $id): Product;
}
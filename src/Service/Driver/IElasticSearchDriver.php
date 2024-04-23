<?php

namespace Shop\Service\Driver;

use Shop\Model\Product\Product;

interface IElasticSearchDriver
{
    public function findById(int $id): Product;
}
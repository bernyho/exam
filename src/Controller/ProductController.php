<?php

namespace Shop\Controller;

use Exception;
use Shop\Service\ProductProvider;

readonly class ProductController
{
    public function __construct(
        private ProductProvider $productProvider = new ProductProvider
    )
    {
    }

    /**
     * @throws Exception
     */
    public function detail(int $id): string
    {
        return json_encode($this->productProvider->getProduct($id));
    }
}
<?php

namespace Shop\Service;

use Exception;
use Shop\Model\Product\Product;
use Shop\Repository\ProductRepository;

readonly class ProductProvider
{
    public function __construct(
        private FileCacheService $cacheService = new FileCacheService,
        private CounterService $counterService = new CounterService
    ) {
    }

    /**
     * @throws Exception
     */
    public function getProduct(int $id): array
    {
        $productData = $this->cacheService->get("product_" . $id, function () use ($id)
        {
            $product = $this->resolveProduct($id);

            return [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'created' => $product->getCreatedAt(),
                'badges' => $product->getBadges(),
                'active' => $product->isActive(),
            ];
        });

        $productData['seen'] = $this->counterService->getProductCounter($id);

        return $productData;
    }

    private function resolveProduct(int $id): Product
    {
        if ($this->useElasticsearch())
        {
            $elasticsearchProductFinder = new ProductFinder();
            return $elasticsearchProductFinder->findById($id);
        }

        $productRepository = new ProductRepository();
        return $productRepository->findProduct($id);
    }

    private function useElasticsearch(): bool
    {
        return isset($_ENV['APP_USE_ELASTICSEARCH']) && $_ENV['APP_USE_ELASTICSEARCH'] === '1';
    }
}
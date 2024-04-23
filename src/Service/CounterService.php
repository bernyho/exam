<?php

namespace Shop\Service;

use Exception;

/**
 * Simple in-file counter
 */
class CounterService
{
    private const COUNTER_DEFAULT_FILENAME = 'product_counter.cache';

    public function __construct(
        private readonly string $name = self::COUNTER_DEFAULT_FILENAME,
        private readonly string $dir = FileCacheService::CACHE_DEFAULT_DIR,
        private readonly FileService $fileService = new FileService
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDir(): string
    {
        return $this->dir;
    }

    /**
     * @throws Exception
     */
    public function getProductCounter(int $productId): int
    {
        $filePath = $this->getDir() . $this->getName();

        if (is_readable($filePath))
        {
            $productData = $this->fileService->readFile($filePath, $this->getName());
        }

        $counter = $productData[$productId]['count'] ?? 0;
        $counter++;

        $productData[$productId] = ['count' => $counter];

        $this->fileService->saveFile($filePath, $this->getDir(), $productData);

        return $counter;
    }
}
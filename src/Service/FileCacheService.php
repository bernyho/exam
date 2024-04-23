<?php

declare(strict_types=1);

namespace Shop\Service;

use Closure;
use Exception;

/**
 * Simple in-file caching
 */
class FileCacheService
{
    private const CACHE_DEFAULT_FILENAME = 'product_data.cache';

    public const CACHE_DEFAULT_DIR = '../var/cache/'; // slash on the end

    private string $filename;

    private string $dir;

    private array $data;

    /**
     * @throws Exception
     */
    public function __construct(
        string $fileName = self::CACHE_DEFAULT_FILENAME,
        string $dirPath = self::CACHE_DEFAULT_DIR,
        private readonly FileService $fileService = new FileService
    )
    {
        $this
            ->setFilename($fileName)
            ->setDir($dirPath)
            ->setData()
        ;
    }

    /**
     * @throws Exception
     */
    private function loadDataFromFile(): array
    {
        return $this->fileService->readFile(
            $this->getFilePath(),
            $this->getFilename()
        );
    }

    /**
     * @throws Exception
     */
    public function store(string $key, array $data): self
    {
        $this->data[$key] = [
            "time" => time(),
            "data" => $data,
        ];

        $this->fileService->saveFile(
            $this->getFilePath(),
            $this->getDir(),
            $this->getData()
        );

        return $this;
    }

    /**
     * @throws Exception
     */
    public function retrieve(string $key)
    {
        if (!isset($this->data[$key]))
        {
            return null;
        }

        $data = $this->data[$key];
        return @$data["data"];
    }

    /**
     * @throws Exception
     */
    public function get(string $key, Closure $refreshCallback)
    {
        if (!$this->isCached($key))
        {
            $this->store($key, $refreshCallback());
        }

        return $this->retrieve($key);
    }

    public function isCached(string $key): bool
    {
        return isset($this->data[$key]);
    }

    public function getDir(): string
    {
        return $this->dir;
    }

    public function setDir(string $dir): self
    {
        $this->dir = $dir;

        return $this;
    }

    /**
     * @throws Exception
     */
    public function setData(): self
    {
        $this->data = is_readable($this->getFilePath()) ? $this->loadDataFromFile() : [];

        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }


    public function getFilePath(): string
    {
        return $this->getDir() . $this->getFilename();
    }
}
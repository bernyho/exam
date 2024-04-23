<?php

namespace Shop\Service;

use Exception;

/**
 * Simple in-file caching
 */
readonly class FileService
{
    /**
     * @throws Exception
     */
    public function saveFile(string $filePath, string $dir, array $data): void
    {
        if (!file_exists($dir))
        {
            @mkdir($dir);
        }

        $serializedDataString = serialize($data);
        if(file_put_contents($filePath, $serializedDataString, LOCK_EX) === false)
        {
            throw new Exception("file save error");
        }
    }

    /**
     * @throws Exception
     */
    public function readFile(string $filepath, string $filename, string $mode = 'r+'): array
    {
        if(($f = fopen($filepath, $mode)) === false)
        {
            throw new Exception("file could not be open $filepath");
        }

        if (!flock($f, LOCK_SH))
        {
            throw new Exception("locking error for $filepath");
        }

        $file = fread($f, filesize($filepath));
        flock($f, LOCK_UN);
        fclose($f);

        if (!$file)
        {
            unlink($filepath);
            throw new Exception("file cannot be read $filename");
        }

        $data = unserialize($file);

        if ($data === false)
        {
            throw new Exception("file cache un-serialization error, file deleted $filename");
        }

        return $data;
    }
}
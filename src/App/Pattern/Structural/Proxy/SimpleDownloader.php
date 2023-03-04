<?php

namespace App\Pattern\Structural\Proxy;
/**
 * Реальный Субъект делает реальную работу, хотя и не самым эффективным
 * способом. Когда клиент пытается загрузить тот же самый файл во второй раз,
 * наш загрузчик именно это и делает, вместо того, чтобы извлечь результат из
 * кэша.
 */
class SimpleDownloader implements Downloader
{
    public function download(string $url): string
    {
        echo "Downloading a file from the Internet.\n";
        $result = file_get_contents($url);
        echo "Downloaded bytes: " . strlen($result) . "\n";

        return $result;
    }
}
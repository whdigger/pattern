<?php

namespace Framework;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;

class YamlLoader
{
    private $loader;

    public function __construct()
    {
        $rootDir = __DIR__ . '/../../';
        $fileLocator = new FileLocator(array($rootDir));
        $this->loader = new YamlFileLoader($fileLocator);
    }

    public function getRoutes()
    {
        return $this->loader->load('config/routes.yaml');
    }
}
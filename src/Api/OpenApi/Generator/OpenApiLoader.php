<?php

declare(strict_types=1);

namespace App\Api\OpenApi\Generator;

use Generator;
use OpenApi\Annotations\OpenApi;
use OpenApi\Context;
use OpenApi\Generator as OpenApiGenerator;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\Routing\RouterInterface;

class OpenApiLoader
{
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @throws ReflectionException
     */
    public function load(): OpenApi
    {
        $pathsToScan = array_unique(iterator_to_array($this->getApiRoutes(), false));
        return OpenApiGenerator::scan(
            $pathsToScan,
            ['analysis' => new DeactivateValidationAnalysis(context: new Context())]
        );
    }

    /**
     * @throws ReflectionException
     */
    private function getApiRoutes(): Generator
    {
        foreach ($this->router->getRouteCollection() as $item) {
            $path = $item->getPath();
            if (!str_starts_with($path, '/api/')) {
                continue;
            }

            $controllerClass = strtok($item->getDefault('_controller'), ':');
            $refClass = new ReflectionClass($controllerClass);
            yield $refClass->getFileName();
        }
    }
}
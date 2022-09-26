<?php

/*
 * This file is part of the ApiPlatformSkipNullBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ApiPlatformSkipNullBundle\Tests\DependencyInjection;

use ApiPlatformSkipNullBundle\DependencyInjection\ApiPlatformSkipNullExtension;
use Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Resource\FileResource;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Florent TEDESCO
 */
class ApiPlatformSkipNullExtensionTest extends TestCase
{
    /**
     * @return void
     */
    public function testClassExist(): void
    {
        $this->assertTrue(class_exists(ApiPlatformSkipNullExtension::class));
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    public function testLoader(): void
    {
        $container = new ContainerBuilder();
        $loader = new ApiPlatformSkipNullExtension();
        $loader->load([], $container);

        $resources = array_map(function(FileResource $fileResource) {
            return $fileResource->getResource();
        }, $container->getResources());

        $this->assertTrue(in_array(dirname(__DIR__, 2).'/config/services.yaml', $resources));
    }
}
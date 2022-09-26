<?php

/*
 * This file is part of the ApiPlatformSkipNullBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ApiPlatformSkipNullBundle\Tests\ResourceMetadataCollectionFactory;

use ApiPlatform\Exception\ResourceClassNotFoundException;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Operation;
use ApiPlatformSkipNullBundle\ResourceMetadataCollectionFactory\SkipNullResourceMetadataCollectionFactory;
use ApiPlatformSkipNullBundle\Tests\Application\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * @author Florent TEDESCO
 */
class SkipNullResourceMetadataCollectionFactoryTest extends WebTestCase
{
    /**
     * @return void
     */
    public function testClassExist(): void
    {
        $this->assertTrue(class_exists(SkipNullResourceMetadataCollectionFactory::class));
    }

    /**
     * @return void
     * @throws ResourceClassNotFoundException
     */
    public function testServiceWhenEnabled(): void
    {
        $kernel = self::createKernel();
        $kernel->boot();
        $container = $kernel->getContainer();

        // Check if the service is declared

        $this->assertTrue($container->has('api_platform.skip_null.resource.metadata_collection_factory'));

        $factory = $container->get('api_platform.skip_null.resource.metadata_collection_factory');
        $this->assertInstanceOf(SkipNullResourceMetadataCollectionFactory::class, $factory);

        // Check if configuration is implemented correctly

        $this->assertTrue($container->getParameter('api_platform_skip_null.enabled'));

        $resourceMetadataCollection = $factory->create(Book::class);

        /** @var ApiResource $resourceMetadata */
        foreach ($resourceMetadataCollection as $resourceMetadata) {
            $operations = $resourceMetadata->getOperations();

            if ($operations) {
                /** @var Operation $operation */
                foreach ($operations as $operation) {
                    $normalizationContext = $operation->getNormalizationContext();
                    $this->assertTrue($normalizationContext['skip_null_values']);

                    $denormalizationContext = $operation->getDenormalizationContext();
                    $this->assertTrue($denormalizationContext['skip_null_values']);
                }
            }
        }

        $this->tearDown();
    }

    /**
     * @return void
     * @throws ResourceClassNotFoundException
     */
    public function testServiceWhenDisabled(): void
    {
        $kernel = self::createKernel();
        $kernel->boot(function (ContainerBuilder $container) {
            $container->prependExtensionConfig('api_platform_skip_null', [
                'enabled' => false
            ]);
        });
        $container = $kernel->getContainer();

        // Check if the service is declared

        $this->assertTrue($container->has('api_platform.skip_null.resource.metadata_collection_factory'));

        $factory = $container->get('api_platform.skip_null.resource.metadata_collection_factory');
        $this->assertInstanceOf(SkipNullResourceMetadataCollectionFactory::class, $factory);

        // Check if configuration is implemented correctly

        $this->assertFalse($container->getParameter('api_platform_skip_null.enabled'));

        $resourceMetadataCollection = $factory->create(Book::class);

        /** @var ApiResource $resourceMetadata */
        foreach ($resourceMetadataCollection as $resourceMetadata) {
            $operations = $resourceMetadata->getOperations();

            if ($operations) {
                /** @var Operation $operation */
                foreach ($operations as $operation) {
                    $normalizationContext = $operation->getNormalizationContext();
                    $this->assertFalse($normalizationContext['skip_null_values']);

                    $denormalizationContext = $operation->getDenormalizationContext();
                    $this->assertFalse($denormalizationContext['skip_null_values']);
                }
            }
        }

        $this->tearDown();
    }
}
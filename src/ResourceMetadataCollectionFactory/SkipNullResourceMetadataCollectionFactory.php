<?php

/*
 * This file is part of the ApiPlatformSkipNullBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ApiPlatformSkipNullBundle\ResourceMetadataCollectionFactory;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Resource\Factory\ResourceMetadataCollectionFactoryInterface;
use ApiPlatform\Metadata\Resource\ResourceMetadataCollection;

/**
 * Assigns the value configured to the skip_null_values to all operations.
 *
 * @author Florent TEDESCO
 */
class SkipNullResourceMetadataCollectionFactory implements ResourceMetadataCollectionFactoryInterface
{
    /**
     * @var ResourceMetadataCollectionFactoryInterface
     */
    private ResourceMetadataCollectionFactoryInterface $decorated;

    /**
     * @var bool
     */
    private bool $enabled;

    /**
     * @param ResourceMetadataCollectionFactoryInterface $decorated
     * @param bool $enabled
     */
    public function __construct(ResourceMetadataCollectionFactoryInterface $decorated, bool $enabled)
    {
        $this->decorated = $decorated;
        $this->enabled = $enabled;
    }

    /**
     * {@inheritDoc}
     */
    public function create(string $resourceClass): ResourceMetadataCollection
    {
        $resourceMetadataCollection = $this->decorated->create($resourceClass);

        /** @var ApiResource $resourceMetadata */
        foreach ($resourceMetadataCollection as $resourceMetadata) {
            $operations = $resourceMetadata->getOperations();

            if ($operations) {
                /**
                 * @var string    $operationName
                 * @var Operation $operation
                 */
                foreach ($operations as $operationName => $operation) {
                    $operations->add($operationName, $this->updateContextOnOperation($operation));
                }
            }
        }

        return $resourceMetadataCollection;
    }

    /**
     * Modifies the context to set skip_null_values.
     *
     * @param Operation $operation
     *
     * @return Operation
     */
    private function updateContextOnOperation(Operation $operation): Operation
    {
        $normalizationContext = $operation->getNormalizationContext() ?? [];
        $normalizationContext['skip_null_values'] = $this->enabled;

        $denormalizationContext = $operation->getDenormalizationContext() ?? [];
        $denormalizationContext['skip_null_values'] = $this->enabled;

        return $operation
            ->withNormalizationContext($normalizationContext)
            ->withDenormalizationContext($denormalizationContext)
        ;
    }
}
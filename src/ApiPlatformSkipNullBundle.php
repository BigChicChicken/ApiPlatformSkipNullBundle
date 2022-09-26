<?php

/*
 * This file is part of the ApiPlatformSkipNullBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ApiPlatformSkipNullBundle;

use ApiPlatformSkipNullBundle\DependencyInjection\ApiPlatformSkipNullExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Florent TEDESCO
 *
 * @final
 */
class ApiPlatformSkipNullBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function getContainerExtension(): ExtensionInterface
    {
        return new ApiPlatformSkipNullExtension();
    }
}
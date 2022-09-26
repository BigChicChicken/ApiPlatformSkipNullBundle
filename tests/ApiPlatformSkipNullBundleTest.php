<?php

/*
* This file is part of the ApiPlatformSkipNullBundle package.
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

declare(strict_types=1);

namespace ApiPlatformSkipNullBundle\Tests;

use ApiPlatformSkipNullBundle\ApiPlatformSkipNullBundle;
use PHPUnit\Framework\TestCase;

/**
 * @author Florent TEDESCO
 */
class ApiPlatformSkipNullBundleTest extends TestCase
{
    /**
     * @return void
     */
    public function testClassExist(): void
    {
        $this->assertTrue(class_exists(ApiPlatformSkipNullBundle::class));
    }

    /**
     * @return void
     */
    public function testExtensionIsLoaded(): void
    {
        $bundle = new ApiPlatformSkipNullBundle();
        $this->assertNotNull($bundle->getContainerExtension());
    }
}
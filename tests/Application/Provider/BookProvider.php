<?php

/*
 * This file is part of the ApiPlatformSkipNullBundle package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ApiPlatformSkipNullBundle\Tests\Application\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Metadata\CollectionOperationInterface;
use ApiPlatformSkipNullBundle\Tests\Application\Entity\Book;

/**
 * @author Florent TEDESCO
 */
final class BookProvider implements ProviderInterface
{
    /**
     * @return Book
     */
    static function getBook(): Book
    {
        $book = new Book();
        $book
            ->setAuthor('Author')
            ->setTitle('Title')
            ->setDescription('Description')
        ;

        return $book;
    }

    /**
     * {@inheritDoc}
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|iterable|null
    {
        if ($operation instanceof CollectionOperationInterface) {
            return [self::getBook(), self::getBook()];
        }

        return self::getBook();
    }
}
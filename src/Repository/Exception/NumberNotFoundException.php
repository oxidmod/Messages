<?php

declare (strict_types=1);

namespace Oxidmod\Messages\Repository\Exception;

/**
 * @see NumberRepository
 */
class NumberNotFoundException extends \RuntimeException
{
    /**
     * @param int $numberId
     */
    public function __construct(int $numberId)
    {
        parent::__construct(
            \sprintf('Number #%d was not found.', $numberId)
        );
    }
}

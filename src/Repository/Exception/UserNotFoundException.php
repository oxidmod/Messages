<?php

declare (strict_types=1);

namespace Oxidmod\Messages\Repository\Exception;

/**
 * @see UserRepository
 */
class UserNotFoundException extends \RuntimeException
{
    /**
     * @param int $userId
     */
    public function __construct(int $userId)
    {
        parent::__construct(
            \sprintf('User #%d was not found.', $userId)
        );
    }
}

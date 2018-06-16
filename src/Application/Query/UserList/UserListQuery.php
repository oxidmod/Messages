<?php

declare (strict_types=1);

namespace Oxidmod\Messages\Application\Query\UserList;

/**
 * Contains query params
 */
class UserListQuery
{
    private $onlyActive = true;

    /**
     * @return bool
     */
    public function onlyActive(): bool
    {
        return $this->onlyActive;
    }
}
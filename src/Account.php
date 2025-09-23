<?php

/*
 * This file is part of the xAPI package.
 *
 * (c) Christian Flothmann <christian.flothmann@xabbuh.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xabbuh\XApi\Model;

/**
 * A user account on an existing system.
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
final readonly class Account
{
    public function __construct(private string $name, private IRL $homePage)
    {
    }

    /**
     * Returns the unique id or name used to log in to this account.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the home page for the system the account is on.
     */
    public function getHomePage(): IRL
    {
        return $this->homePage;
    }

    /**
     * Checks if another account is equal.
     *
     * Two accounts are equal if and only if all of their properties are equal.
     */
    public function equals(Account $account): bool
    {
        if ($this->name !== $account->name) {
            return false;
        }

        return $this->homePage->equals($account->homePage);
    }
}

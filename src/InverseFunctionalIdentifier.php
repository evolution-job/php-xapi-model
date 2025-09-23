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

use Stringable;

/**
 * The inverse functional identifier of an {@link Actor}.
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
final class InverseFunctionalIdentifier implements Stringable
{
    private ?IRI $mbox = null;

    private ?string $mboxSha1Sum = null;

    private ?string $openId = null;

    private ?Account $account = null;

    /**
     * Use one of the with*() factory methods to obtain an InverseFunctionalIdentifier
     * instance.
     */
    private function __construct()
    {
    }

    public static function withMbox(IRI $mbox): self
    {
        $inverseFunctionalIdentifier = new InverseFunctionalIdentifier();
        $inverseFunctionalIdentifier->mbox = $mbox;

        return $inverseFunctionalIdentifier;
    }

    public static function withMboxSha1Sum(string $mboxSha1Sum): self
    {
        $inverseFunctionalIdentifier = new InverseFunctionalIdentifier();
        $inverseFunctionalIdentifier->mboxSha1Sum = $mboxSha1Sum;

        return $inverseFunctionalIdentifier;
    }

    public static function withOpenId(string $openId): self
    {
        $inverseFunctionalIdentifier = new InverseFunctionalIdentifier();
        $inverseFunctionalIdentifier->openId = $openId;

        return $inverseFunctionalIdentifier;
    }

    public static function withAccount(Account $account): self
    {
        $inverseFunctionalIdentifier = new InverseFunctionalIdentifier();
        $inverseFunctionalIdentifier->account = $account;

        return $inverseFunctionalIdentifier;
    }

    /**
     * Returns the mailto IRI.
     */
    public function getMbox(): ?IRI
    {
        return $this->mbox;
    }

    /**
     * Returns the SHA1 hash of a mailto IRI.
     */
    public function getMboxSha1Sum(): ?string
    {
        return $this->mboxSha1Sum;
    }

    /**
     * Returns the openID.
     */
    public function getOpenId(): ?string
    {
        return $this->openId;
    }

    /**
     * Returns the user account of an existing system.
     */
    public function getAccount(): ?Account
    {
        return $this->account;
    }

    /**
     * Checks if another IRI is equal.
     *
     * Two inverse functional identifiers are equal if and only if all of their
     * properties are equal.
     */
    public function equals(InverseFunctionalIdentifier $iri): bool
    {
        if ($this->mbox instanceof IRI && $iri->mbox instanceof IRI && !$this->mbox->equals($iri->mbox)) {
            return false;
        }

        if ($this->mboxSha1Sum !== $iri->mboxSha1Sum) {
            return false;
        }

        if ($this->openId !== $iri->openId) {
            return false;
        }

        if (!$this->account instanceof Account && $iri->account instanceof Account) {
            return false;
        }

        if ($this->account instanceof Account && !$iri->account instanceof Account) {
            return false;
        }

        return !($this->account instanceof Account && !$this->account->equals($iri->account));
    }

    public function __toString(): string
    {
        if ($this->mbox instanceof IRI) {
            return $this->mbox->getValue();
        }

        return ($this->mboxSha1Sum ?? $this->openId) ?? sprintf('%s (%s)', $this->account->getName(), $this->account->getHomePage()->getValue());
    }
}

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

use Override;

/**
 * The Actor of a {@link Statement}.
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
abstract class Actor extends StatementObject
{
    public function __construct(private readonly ?InverseFunctionalIdentifier $iri = null, private readonly ?string $name = null)
    {
    }

    /**
     * Returns the Actor's {@link InverseFunctionalIdentifier inverse functional identifier}.
     */
    public function getInverseFunctionalIdentifier(): ?InverseFunctionalIdentifier
    {
        return $this->iri;
    }

    /**
     * Returns the name of the {@link Agent} or {@link Group}.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Checks if another actor is equal.
     *
     * Two actors are equal if and only if all of their properties are equal.
     */
    #[Override]
    public function equals(StatementObject $statementObject): bool
    {
        if (!parent::equals($statementObject)) {
            return false;
        }

        if (!$statementObject instanceof self) {
            return false;
        }

        if ($this->name !== $statementObject->name) {
            return false;
        }

        if ($this->iri instanceof InverseFunctionalIdentifier xor $statementObject->iri instanceof InverseFunctionalIdentifier) {
            return false;
        }

        return !($this->iri instanceof InverseFunctionalIdentifier && $statementObject->iri instanceof InverseFunctionalIdentifier && !$this->iri->equals($statementObject->iri));
    }
}

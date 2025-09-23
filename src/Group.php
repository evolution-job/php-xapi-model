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
 * A group of {@link Agent Agents} of a {@link Statement}.
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
final class Group extends Actor
{
    /**
     * @param Agent[] $members
     */
    public function __construct(?InverseFunctionalIdentifier $iri = null, ?string $name = null, private readonly array $members = [])
    {
        parent::__construct($iri, $name);
    }

    /**
     * Returns the members of this group.
     *
     * @return Agent[]
     */
    public function getMembers(): array
    {
        return $this->members;
    }

    /**
     * {@inheritdoc}
     */
    #[Override]
    public function equals(StatementObject $statementObject): bool
    {
        if (!parent::equals($statementObject)) {
            return false;
        }

        /** @var Group $statementObject */

        if (count($this->members) !== count($statementObject->members)) {
            return false;
        }

        return array_all($this->members, static fn($member): bool => in_array($member, $statementObject->members));
    }
}

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
 * An Activity in a {@link Statement}.
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
final class Activity extends StatementObject
{
    public function __construct(private readonly IRI $id, private readonly ?Definition $definition = null)
    {
    }

    /**
     * Returns the Activity's unique identifier.
     */
    public function getId(): IRI
    {
        return $this->id;
    }

    /**
     * Returns the Activity's {@link Definition}.
     */
    public function getDefinition(): ?Definition
    {
        return $this->definition;
    }

    /**
     * {@inheritdoc}
     */
    #[Override]
    public function equals(StatementObject $statementObject): bool
    {
        if (!$statementObject instanceof self) {
            return false;
        }

        if (!$this->id->equals($statementObject->id)) {
            return false;
        }

        if (!$this->definition instanceof Definition && $statementObject->definition instanceof Definition) {
            return false;
        }

        if ($this->definition instanceof Definition && !$statementObject->definition instanceof Definition) {
            return false;
        }

        return !($this->definition instanceof Definition && !$this->definition->equals($statementObject->definition));
    }
}

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
 * A reference to an existing {@link Statement}.
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
final class StatementReference extends StatementObject
{
    public function __construct(private readonly StatementId $statementId)
    {
    }

    /**
     * Returns the id of the referenced Statement.
     */
    public function getStatementId(): StatementId
    {
        return $this->statementId;
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

        return $this->statementId->equals($statementObject->statementId);
    }
}

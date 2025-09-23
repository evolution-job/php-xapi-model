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

use DateTime;
use Xabbuh\XApi\Model\Exception\InvalidStateException;

/*
 * Statement factory eases the creation of complex xAPI statements.
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */

final class StatementFactory
{
    private ?StatementId $id = null;

    private ?Actor $actor = null;

    private ?Verb $verb = null;

    private ?StatementObject $object = null;

    private ?Result $result = null;

    private ?Context $context = null;

    private ?DateTime $created = null;

    private ?DateTime $stored = null;

    private ?Actor $authority = null;

    public function withId(StatementId $id): void
    {
        $this->id = $id;
    }

    public function withActor(Actor $actor): void
    {
        $this->actor = $actor;
    }

    public function withVerb(Verb $verb): void
    {
        $this->verb = $verb;
    }

    public function withObject(StatementObject $object): void
    {
        $this->object = $object;
    }

    public function withResult(?Result $result = null): void
    {
        $this->result = $result;
    }

    public function withContext(?Context $context = null): void
    {
        $this->context = $context;
    }

    public function withCreated(?DateTime $created = null): void
    {
        $this->created = $created;
    }

    public function withStored(?DateTime $stored = null): void
    {
        $this->stored = $stored;
    }

    public function withAuthority(?Actor $authority = null): void
    {
        $this->authority = $authority;
    }

    /**
     * Returns a statement based on the current configuration.
     *
     * Multiple calls to this method will return different instances.
     *
     * @throws InvalidStateException
     */
    public function createStatement(): Statement
    {
        if (!$this->actor instanceof Actor) {
            throw new InvalidStateException('A statement actor is missing.');
        }

        if (!$this->verb instanceof Verb) {
            throw new InvalidStateException('A statement verb is missing.');
        }

        if (!$this->object instanceof StatementObject) {
            throw new InvalidStateException('A statement object is missing.');
        }

        return new Statement($this->id, $this->actor, $this->verb, $this->object, $this->result, $this->authority, $this->created, $this->stored, $this->context);
    }
}

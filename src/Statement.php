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

/**
 * An Experience API {@link https://github.com/adlnet/xAPI-Spec/blob/master/xAPI.md#statement Statement}.
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
final class Statement
{
    private ?array $attachments;

    /**
     * @param Attachment[]|null $attachments
     */
    public function __construct(
        private ?StatementId $id = null,
        private ?Actor $actor = null,
        private ?Verb $verb = null,
        private ?StatementObject $object = null,
        private ?Result $result = null,
        private ?Actor $authority = null,
        private ?DateTime $created = null,
        private ?DateTime $stored = null,
        private ?Context $context = null,
        ?array $attachments = null,
        private ?string $version = null
    ) {
        $this->attachments = null !== $attachments ? array_values($attachments) : null;
    }

    public function withId(?StatementId $id = null): self
    {
        $statement = clone $this;
        $statement->id = $id;

        return $statement;
    }

    public function withActor(Actor $actor): self
    {
        $statement = clone $this;
        $statement->actor = $actor;

        return $statement;
    }

    public function withVerb(Verb $verb): self
    {
        $statement = clone $this;
        $statement->verb = $verb;

        return $statement;
    }

    public function withObject(StatementObject $statementObject): self
    {
        $statement = clone $this;
        $statement->object = $statementObject;

        return $statement;
    }

    public function withResult(?Result $result = null): self
    {
        $statement = clone $this;
        $statement->result = $result;

        return $statement;
    }

    /**
     * Creates a new Statement based on the current one containing an Authority
     * that asserts the Statement true.
     */
    public function withAuthority(?Actor $authority = null): self
    {
        $statement = clone $this;
        $statement->authority = $authority;

        return $statement;
    }

    public function withCreated(?DateTime $created = null): self
    {
        $statement = clone $this;
        $statement->created = $created;

        return $statement;
    }

    public function withStored(?DateTime $stored = null): self
    {
        $statement = clone $this;
        $statement->stored = $stored;

        return $statement;
    }

    public function withContext(?Context $context = null): self
    {
        $statement = clone $this;
        $statement->context = $context;

        return $statement;
    }

    /**
     * @param Attachment[]|null $attachments
     */
    public function withAttachments(?array $attachments = null): self
    {
        $statement = clone $this;
        $statement->attachments = null !== $attachments ? array_values($attachments) : null;

        return $statement;
    }

    public function withVersion(?string $version = null): self
    {
        $statement = clone $this;
        $statement->version = $version;

        return $statement;
    }

    /**
     * Returns the Statement's unique identifier.
     */
    public function getId(): ?StatementId
    {
        return $this->id;
    }

    /**
     * Returns the Statement's {@link Verb}.
     */
    public function getVerb(): Verb
    {
        return $this->verb;
    }

    /**
     * Returns the Statement's {@link Actor}.
     */
    public function getActor(): Actor
    {
        return $this->actor;
    }

    /**
     * Returns the Statement's {@link StatementObject}.
     */
    public function getObject(): StatementObject
    {
        return $this->object;
    }

    /**
     * Returns the {@link Activity} {@link Result}.
     */
    public function getResult(): ?Result
    {
        return $this->result;
    }

    /**
     * Returns the Authority that asserted the Statement true.
     */
    public function getAuthority(): ?Actor
    {
        return $this->authority;
    }

    /**
     * Returns the DateTime of when the events described in this statement
     * occurred.
     */
    public function getCreated(): ?DateTime
    {
        return $this->created;
    }

    /**
     * Returns the DateTime of when this statement was recorded by the LRS.
     */
    public function getStored(): ?DateTime
    {
        return $this->stored;
    }

    /**
     * Returns the context that gives the statement more meaning.
     */
    public function getContext(): ?Context
    {
        return $this->context;
    }

    /**
     * @return Attachment[]|null
     */
    public function getAttachments(): ?array
    {
        return $this->attachments;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    /**
     * Tests whether or not this Statement is a void Statement (i.e. it voids
     * another Statement).
     */
    public function isVoidStatement(): bool
    {
        return $this->verb->isVoidVerb();
    }

    /**
     * Returns a {@link StatementReference} for the Statement.
     */
    public function getStatementReference(): StatementReference
    {
        return new StatementReference($this->id);
    }

    /**
     * Returns a Statement that voids the current Statement.
     */
    public function getVoidStatement(Actor $actor): self
    {
        return new Statement(
            null,
            $actor,
            Verb::createVoidVerb(),
            $this->getStatementReference()
        );
    }

    /**
     * Checks if another statement is equal.
     *
     * Two statements are equal if and only if all of their properties are equal.
     */
    public function equals(Statement $statement): bool
    {
        if ($this->id instanceof StatementId xor $statement->id instanceof StatementId) {
            return false;
        }

        if ($this->id instanceof StatementId && $statement->id instanceof StatementId && !$this->id->equals($statement->id)) {
            return false;
        }

        if (!$this->actor->equals($statement->actor)) {
            return false;
        }

        if (!$this->verb->equals($statement->verb)) {
            return false;
        }

        if (!$this->object->equals($statement->object)) {
            return false;
        }

        if (!$this->result instanceof Result && $statement->result instanceof Result) {
            return false;
        }

        if ($this->result instanceof Result && !$statement->result instanceof Result) {
            return false;
        }

        if ($this->result instanceof Result && !$this->result->equals($statement->result)) {
            return false;
        }

        if (!$this->authority instanceof Actor && $statement->authority instanceof Actor) {
            return false;
        }

        if ($this->authority instanceof Actor && !$statement->authority instanceof Actor) {
            return false;
        }

        if ($this->authority instanceof Actor && !$this->authority->equals($statement->authority)) {
            return false;
        }

        if ($this->created != $statement->created) {
            return false;
        }

        if ($this->context instanceof Context xor $statement->context instanceof Context) {
            return false;
        }

        if ($this->context instanceof Context && $statement->context instanceof Context && !$this->context->equals($statement->context)) {
            return false;
        }

        if (null !== $this->attachments xor null !== $statement->attachments) {
            return false;
        }

        if (null !== $this->attachments && null !== $statement->attachments) {
            if (count($this->attachments) !== count($statement->attachments)) {
                return false;
            }

            if (array_any($this->attachments, static fn($attachment, $key): bool => !$attachment->equals($statement->attachments[$key]))) {
                return false;
            }
        }

        return true;
    }
}

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
 * Contextual information for an xAPI statement.
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
final class Context
{
    private ?string $registration = null;

    private ?Actor $instructor = null;

    private ?Group $team = null;

    private ?ContextActivities $contextActivities = null;

    private ?string $revision = null;

    private ?string $platform = null;

    private ?string $language = null;

    private ?StatementReference $statement = null;

    private ?Extensions $extensions = null;

    public function withRegistration(string $registration): self
    {
        $context = clone $this;
        $context->registration = $registration;

        return $context;
    }

    public function withInstructor(Actor $instructor): self
    {
        $context = clone $this;
        $context->instructor = $instructor;

        return $context;
    }

    public function withTeam(Group $team): self
    {
        $context = clone $this;
        $context->team = $team;

        return $context;
    }

    public function withContextActivities(ContextActivities $contextActivities): self
    {
        $context = clone $this;
        $context->contextActivities = $contextActivities;

        return $context;
    }

    public function withRevision(string $revision): self
    {
        $context = clone $this;
        $context->revision = $revision;

        return $context;
    }

    public function withPlatform(string $platform): self
    {
        $context = clone $this;
        $context->platform = $platform;

        return $context;
    }

    public function withLanguage(string $language): self
    {
        $context = clone $this;
        $context->language = $language;

        return $context;
    }

    public function withStatement(StatementReference $statement): self
    {
        $context = clone $this;
        $context->statement = $statement;

        return $context;
    }

    public function withExtensions(Extensions $extensions): self
    {
        $context = clone $this;
        $context->extensions = $extensions;

        return $context;
    }

    public function getRegistration(): ?string
    {
        return $this->registration;
    }

    public function getInstructor(): ?Actor
    {
        return $this->instructor;
    }

    public function getTeam(): ?Group
    {
        return $this->team;
    }

    public function getContextActivities(): ?ContextActivities
    {
        return $this->contextActivities;
    }

    public function getRevision(): ?string
    {
        return $this->revision;
    }

    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function getStatement(): ?StatementReference
    {
        return $this->statement;
    }

    public function getExtensions(): ?Extensions
    {
        return $this->extensions;
    }

    public function equals(Context $context): bool
    {
        if ($this->registration !== $context->registration) {
            return false;
        }

        if ($this->instructor instanceof Actor xor $context->instructor instanceof Actor) {
            return false;
        }

        if ($this->instructor instanceof Actor && $context->instructor instanceof Actor && !$this->instructor->equals($context->instructor)) {
            return false;
        }

        if ($this->team instanceof Group xor $context->team instanceof Group) {
            return false;
        }

        if ($this->team instanceof Group && $context->team instanceof Group && !$this->team->equals($context->team)) {
            return false;
        }

        if ($this->contextActivities != $context->contextActivities) {
            return false;
        }

        if ($this->revision !== $context->revision) {
            return false;
        }

        if ($this->platform !== $context->platform) {
            return false;
        }

        if ($this->language !== $context->language) {
            return false;
        }

        if ($this->statement instanceof StatementReference xor $context->statement instanceof StatementReference) {
            return false;
        }

        if ($this->statement instanceof StatementReference && $context->statement instanceof StatementReference && !$this->statement->equals($context->statement)) {
            return false;
        }

        if ($this->extensions instanceof Extensions xor $context->extensions instanceof Extensions) {
            return false;
        }

        return !($this->extensions instanceof Extensions && $context->extensions instanceof Extensions && !$this->extensions->equals($context->extensions));
    }
}

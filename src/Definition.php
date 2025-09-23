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
 * Definition of an {@link Activity}.
 *
 * A number of derived classes exists each of them covering a specialized
 * type of user interaction:
 *
 * <ul>
 *   <li>ChoiceInteractionDefinition</li>
 *   <li>FillInteractionDefinition</li>
 *   <li>LikertInteractionDefinition</li>
 *   <li>LongFillInInteractionDefinition</li>
 *   <li>MatchingInteractionDefinition</li>
 *   <li>NumericInteractionDefinition</li>
 *   <li>PerformanceInteractionDefinition</li>
 *   <li>OtherInteractionDefinition</li>
 *   <li>SequencingInteractionDefinition</li>
 *   <li>TrueFalseInteractionDefinition</li>
 * </ul>
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
class Definition
{
    public function __construct(private ?LanguageMap $name = null, private ?LanguageMap $description = null, private ?IRI $type = null, private ?IRL $moreInfo = null, private ?Extensions $extensions = null)
    {
    }

    public function withName(?LanguageMap $name = null): self
    {
        $definition = clone $this;
        $definition->name = $name;

        return $definition;
    }

    public function withDescription(?LanguageMap $description = null): self
    {
        $definition = clone $this;
        $definition->description = $description;

        return $definition;
    }

    public function withType(?IRI $type = null): self
    {
        $definition = clone $this;
        $definition->type = $type;

        return $definition;
    }

    public function withMoreInfo(?IRL $moreInfo = null): self
    {
        $definition = clone $this;
        $definition->moreInfo = $moreInfo;

        return $definition;
    }

    public function withExtensions(Extensions $extensions): self
    {
        $definition = clone $this;
        $definition->extensions = $extensions;

        return $definition;
    }

    /**
     * Returns the human readable names.
     */
    public function getName(): ?LanguageMap
    {
        return $this->name;
    }

    /**
     * Returns the human readable descriptions.
     */
    public function getDescription(): ?LanguageMap
    {
        return $this->description;
    }

    /**
     * Returns the {@link Activity} type.
     */
    public function getType(): ?IRI
    {
        return $this->type;
    }

    /**
     * Returns an IRL where human-readable information about the activity can be found.
     */
    public function getMoreInfo(): ?IRL
    {
        return $this->moreInfo;
    }

    public function getExtensions(): ?Extensions
    {
        return $this->extensions;
    }

    /**
     * Checks if another definition is equal.
     *
     * Two definitions are equal if and only if all of their properties are equal.
     */
    public function equals(Definition $definition): bool
    {
        if (static::class !== $definition::class) {
            return false;
        }

        if ($this->type instanceof IRI xor $definition->type instanceof IRI) {
            return false;
        }

        if ($this->type instanceof IRI && $definition->type instanceof IRI && !$this->type->equals($definition->type)) {
            return false;
        }

        if ($this->moreInfo instanceof IRL xor $definition->moreInfo instanceof IRL) {
            return false;
        }

        if ($this->moreInfo instanceof IRL && $definition->moreInfo instanceof IRL && !$this->moreInfo->equals($definition->moreInfo)) {
            return false;
        }

        if ($this->extensions instanceof Extensions xor $definition->extensions instanceof Extensions) {
            return false;
        }

        if ($this->name instanceof LanguageMap xor $definition->name instanceof LanguageMap) {
            return false;
        }

        if ($this->description instanceof LanguageMap xor $definition->description instanceof LanguageMap) {
            return false;
        }

        if ($this->name instanceof LanguageMap) {
            if (count($this->name) !== count($definition->name)) {
                return false;
            }

            foreach ($this->name as $language => $value) {
                if (!isset($definition->name[$language])) {
                    return false;
                }

                if ($value !== $definition->name[$language]) {
                    return false;
                }
            }
        }

        if ($this->description instanceof LanguageMap) {
            if (count($this->description) !== count($definition->description)) {
                return false;
            }

            foreach ($this->description as $language => $value) {
                if (!isset($definition->description[$language])) {
                    return false;
                }

                if ($value !== $definition->description[$language]) {
                    return false;
                }
            }
        }

        return !($this->extensions instanceof Extensions && $definition->extensions instanceof Extensions && !$this->extensions->equals($definition->extensions));
    }
}

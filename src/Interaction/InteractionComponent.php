<?php

/*
 * This file is part of the xAPI package.
 *
 * (c) Christian Flothmann <christian.flothmann@xabbuh.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xabbuh\XApi\Model\Interaction;

use Xabbuh\XApi\Model\LanguageMap;

/**
 * An XAPI activity interaction component.
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
final readonly class InteractionComponent
{
    public function __construct(private string $id, private ?LanguageMap $description = null)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getDescription(): ?LanguageMap
    {
        return $this->description;
    }

    public function equals(InteractionComponent $interactionComponent): bool
    {
        if ($this->id !== $interactionComponent->id) {
            return false;
        }

        if ($this->description instanceof LanguageMap xor $interactionComponent->description instanceof LanguageMap) {
            return false;
        }

        return !($this->description instanceof LanguageMap && $interactionComponent->description instanceof LanguageMap && !$this->description->equals($interactionComponent->description));
    }
}

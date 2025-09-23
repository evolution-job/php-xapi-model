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
 * The outcome of an {@link Activity} achieved by an {@link Agent}.
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
final class Score
{
    public function __construct(
        private int|null|float $scaled = null,
        private int|null|float $raw = null,
        private int|null|float $min = null,
        private int|null|float $max = null,
    ) {}

    public function withScaled(float|int|null $scaled): self
    {
        $score = clone $this;
        $score->scaled = $scaled;

        return $score;
    }

    public function withRaw(float|int|null $raw): self
    {
        $score = clone $this;
        $score->raw = $raw;

        return $score;
    }

    public function withMin(float|int|null $min): self
    {
        $score = clone $this;
        $score->min = $min;

        return $score;
    }

    public function withMax(float|int|null $max): self
    {
        $score = clone $this;
        $score->max = $max;

        return $score;
    }

    /**
     * Returns the Agent's scaled score (a number between -1 and 1).
     */
    public function getScaled(): float|int|null
    {
        return $this->scaled;
    }

    /**
     * Returns the Agent's score (a number between min and max).
     */
    public function getRaw(): float|int|null
    {
        return $this->raw;
    }

    /**
     * Returns the lowest possible score.
     */
    public function getMin(): float|int|null
    {
        return $this->min;
    }

    /**
     * Returns the highest possible score.
     */
    public function getMax(): float|int|null
    {
        return $this->max;
    }

    /**
     * Checks if another score is equal.
     *
     * Two scores are equal if and only if all of their properties are equal.
     */
    public function equals(Score $score): bool
    {
        if (null !== $this->scaled xor null !== $score->scaled) {
            return false;
        }

        if ((float)$this->scaled !== (float)$score->scaled) {
            return false;
        }

        if (null !== $this->raw xor null !== $score->raw) {
            return false;
        }

        if ((float)$this->raw !== (float)$score->raw) {
            return false;
        }

        if (null !== $this->min xor null !== $score->min) {
            return false;
        }

        if ((float)$this->min !== (float)$score->min) {
            return false;
        }

        if (null !== $this->max xor null !== $score->max) {
            return false;
        }

        return (float)$this->max === (float)$score->max;
    }
}

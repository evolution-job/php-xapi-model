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
 * An activity provider's state stored on a remote LRS.
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
final class State
{
    public function __construct(
        private Activity $activity,
        private ?Agent $agent,
        private ?string $stateId,
        private readonly ?string $registrationId = null,
        private readonly mixed $data = null
    ) {}

    /**
     * Returns the activity.
     */
    public function getActivity(): Activity
    {
        return $this->activity;
    }

    /**
     * Returns the agent.
     */
    public function getAgent(): ?Agent
    {
        return $this->agent;
    }

    /**
     * Returns the registration id.
     */
    public function getRegistrationId(): ?string
    {
        return $this->registrationId;
    }

    /**
     * Returns the state's id.
     */
    public function getStateId(): ?string
    {
        return $this->stateId;
    }

    /**
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * Checks if another state is equal.
     *
     * Two states are equal if and only if all of their properties are equal.
     */
    public function equals(State $state): bool
    {
        if ($this->stateId !== $state->getStateId()) {
            return false;
        }

        if ($this->registrationId !== $state->getRegistrationId()) {
            return false;
        }

        if ($this->data !== $state->getData()) {
            return false;
        }

        if (false === $this->activity->equals($state->getActivity())) {
            return false;
        }

        if (false === $this->agent->equals($state->getAgent())) {
            return false;
        }

        return true;
    }

    public function withActivity(Activity $activity): self
    {
        $state = clone $this;
        $state->activity = $activity;

        return $state;
    }

    public function withAgent(Agent $agent): self
    {
        $state = clone $this;
        $state->agent = $agent;

        return $state;
    }

    public function withStateId(string $stateId): self
    {
        $state = clone $this;
        $state->stateId = $stateId;

        return $state;
    }
}

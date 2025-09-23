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

use Xabbuh\XApi\Model\Exception\InvalidStateException;

/*
 * State factory eases the creation of complex xAPI states.
 *
 * @author Mathieu Boldo <mathieu.boldo@entrili.com>
 */
final class StateFactory
{
    private ?Activity $activity = null;
    private ?Agent $agent = null;
    private mixed $data = null;
    private ?string $registrationId = null;
    private ?string $stateId = null;

    public function withActivity(Activity $activity): void
    {
        $this->activity = $activity;
    }

    public function withAgent(Agent $agent): void
    {
        $this->agent = $agent;
    }

    public function withData(mixed $data): void
    {
        $this->data = $data;
    }

    public function withRegistrationId(?string $registrationId): void
    {
        $this->registrationId = $registrationId;
    }

    public function withStateId(?string $id): void
    {
        $this->stateId = $id;
    }

    /**
     * Returns a state based on the current configuration.
     *
     * Multiple calls to this method will return different instances.
     *
     * @throws InvalidStateException
     */
    public function createState(): State
    {
        if (!$this->activity instanceof Activity) {
            throw new InvalidStateException('A state activity is missing.');
        }

        if (!$this->agent instanceof Agent) {
            throw new InvalidStateException('A state actor is missing.');
        }

        return new State(
            $this->activity,
            $this->agent,
            $this->stateId,
            $this->registrationId,
            $this->data
        );
    }
}

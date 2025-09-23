<?php

/*
 * This file is part of the xAPI package.
 *
 * (c) Christian Flothmann <christian.flothmann@xabbuh.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Xabbuh\XApi\Model;

use PhpSpec\ObjectBehavior;
use Xabbuh\XApi\Model\Activity;
use Xabbuh\XApi\Model\Agent;
use Xabbuh\XApi\Model\Exception\InvalidStateException;
use Xabbuh\XApi\Model\InverseFunctionalIdentifier;
use Xabbuh\XApi\Model\IRI;
use Xabbuh\XApi\Model\State;

class StateFactorySpec extends ObjectBehavior
{
    public function it_creates_a_state(): void
    {
        $activity = new Activity(IRI::fromString('http://tincanapi.com/conformancetest/activityid'));
        $agent = new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com')));
        $stateId = 'resume';

        $this->withActivity($activity);
        $this->withAgent($agent);
        $this->withStateId($stateId);

        $state = $this->createState();
        $state->shouldBeAnInstanceOf(State::class);

        $state->getActivity()->shouldReturn($activity);
        $state->getAgent()->shouldReturn($agent);
        $state->getStateId()->shouldReturn($stateId);
    }

    public function it_returns_a_new_instance_with_new_activity(): void
    {
        $this->withActivity(new Activity(IRI::fromString('http://tincanapi.com/conformancetest/activityid')));
        $this->withAgent(new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com'))));
        $this->withStateId('resume');

        $state = $this->createState();
        $state->shouldBeAnInstanceOf(State::class);

        $this->withActivity(new Activity(IRI::fromString('http://tincanapi.com/conformancetest/otherActivityid')));

        $newState = $this->createState();
        $newState->shouldBeAnInstanceOf(State::class);

        $state->equals($newState)->shouldReturn(false);
    }

    public function it_returns_a_new_instance_with_new_agent(): void
    {
        $this->withActivity(new Activity(IRI::fromString('http://tincanapi.com/conformancetest/activityid')));
        $this->withAgent(new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com'))));
        $this->withStateId('resume');

        $state = $this->createState();
        $state->shouldBeAnInstanceOf(State::class);

        $this->withAgent(new Agent(InverseFunctionalIdentifier::withOpenId('http://openid.tincanapi.com')));

        $newState = $this->createState();
        $newState->shouldBeAnInstanceOf(State::class);

        $state->equals($newState)->shouldReturn(false);
    }

    public function it_returns_a_new_instance_with_new_stateid(): void
    {
        $this->withActivity(new Activity(IRI::fromString('http://tincanapi.com/conformancetest/activityid')));
        $this->withAgent(new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com'))));
        $this->withStateId('resume');

        $state = $this->createState();
        $state->shouldBeAnInstanceOf(State::class);

        $this->withStateId('bookmark');

        $newState = $this->createState();
        $newState->shouldBeAnInstanceOf(State::class);

        $state->equals($newState)->shouldReturn(false);
    }

    public function it_throws_an_exception_when_a_statement_is_created_without_an_activity(): void
    {
        $this->withAgent(new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com'))));
        $this->withStateId('resume');

        $this->shouldThrow(InvalidStateException::class)->during('createState');
    }

    public function it_throws_an_exception_when_a_statement_is_created_without_an_agent(): void
    {
        $this->withActivity(new Activity(IRI::fromString('http://tincanapi.com/conformancetest/activityid')));
        $this->withStateId('resume');

        $this->shouldThrow(InvalidStateException::class)->during('createState');
    }
}

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
use Xabbuh\XApi\Model\InverseFunctionalIdentifier;
use Xabbuh\XApi\Model\IRI;
use Xabbuh\XApi\Model\State;

class StateSpec extends ObjectBehavior
{
    public function let(): void
    {
        $activity = new Activity(IRI::fromString('http://tincanapi.com/conformancetest/activityid'));
        $agent = new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com')));
        $stateId = 'resume';

        $this->beConstructedWith($activity, $agent, $stateId);
    }

    public function it_returns_a_new_instance_with_activity(): void
    {
        $activity = new Activity(IRI::fromString('http://tincanapi.com/conformancetest/otheractivityid'));
        $state = $this->withActivity($activity);

        $state->shouldNotBe($this);
        $state->shouldBeAnInstanceOf(State::class);
        $state->getActivity()->shouldReturn($activity);
    }

    public function it_returns_a_new_instance_with_agent(): void
    {
        $agent = new Agent(InverseFunctionalIdentifier::withOpenId('http://openid.tincanapi.com'));
        $state = $this->withAgent($agent);

        $state->shouldNotBe($this);
        $state->shouldBeAnInstanceOf(State::class);
        $state->getAgent()->shouldReturn($agent);
    }

    public function it_returns_a_new_instance_with_stateid(): void
    {
        $state = $this->withStateId('bookmark');

        $state->shouldNotBe($this);
        $state->shouldBeAnInstanceOf(State::class);
        $state->getStateId()->shouldReturn('bookmark');
    }

    public function it_is_not_equal_with_other_state_if_activity_differ(): void
    {
        $state = $this->withActivity(new Activity(IRI::fromString('http://tincanapi.com/conformancetest/otheractivityid')));

        $this->equals($state)->shouldReturn(false);
    }


    public function it_is_not_equal_with_other_state_if_agent_differ(): void
    {
        $state = $this->withAgent(new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:otherconformancetest@tincanapi.com'))));

        $this->equals($state)->shouldReturn(false);
    }

    public function it_is_not_equal_with_other_state_if_stateid_differ(): void
    {
        $state = $this->withStateId('bookmark');

        $this->equals($state)->shouldReturn(false);
    }
}

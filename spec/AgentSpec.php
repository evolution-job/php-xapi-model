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
use Xabbuh\XApi\Model\Actor;
use Xabbuh\XApi\Model\Group;
use Xabbuh\XApi\Model\InverseFunctionalIdentifier;
use Xabbuh\XApi\Model\IRI;

class AgentSpec extends ObjectBehavior
{
    public function it_is_an_actor(): void
    {
        $inverseFunctionalIdentifier = InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com'));
        $this->beConstructedWith($inverseFunctionalIdentifier);
        $this->shouldHaveType(Actor::class);
    }

    public function its_properties_can_be_read(): void
    {
        $inverseFunctionalIdentifier = InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com'));
        $this->beConstructedWith($inverseFunctionalIdentifier, 'test');

        $this->getInverseFunctionalIdentifier()->shouldReturn($inverseFunctionalIdentifier);
        $this->getName()->shouldReturn('test');
    }

    public function it_is_not_equal_to_a_group(): void
    {
        $this->beConstructedWith(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com')));

        $this->equals(new Group(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com'))))->shouldReturn(false);
    }

    public function it_is_not_equal_to_an_activity(): void
    {
        $this->beConstructedWith(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com')));

        $this->equals(new Activity(IRI::fromString('http://tincanapi.com/conformancetest/activityid')))->shouldReturn(false);
    }
}

<?php

namespace spec\Xabbuh\XApi\Model;

use DateTime;
use PhpSpec\ObjectBehavior;
use Xabbuh\XApi\Model\Activity;
use Xabbuh\XApi\Model\Agent;
use Xabbuh\XApi\Model\Context;
use Xabbuh\XApi\Model\Exception\InvalidStateException;
use Xabbuh\XApi\Model\InverseFunctionalIdentifier;
use Xabbuh\XApi\Model\IRI;
use Xabbuh\XApi\Model\Result;
use Xabbuh\XApi\Model\Statement;
use Xabbuh\XApi\Model\StatementId;
use Xabbuh\XApi\Model\Verb;

class StatementFactorySpec extends ObjectBehavior
{
    public function it_creates_a_statement(): void
    {
        $this->withActor(new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com'))));
        $this->withVerb(new Verb(IRI::fromString('http://tincanapi.com/conformancetest/verbid')));
        $this->withObject(new Activity(IRI::fromString('http://tincanapi.com/conformancetest/activityid')));

        $this->createStatement()->shouldBeAnInstanceOf(Statement::class);
    }

    public function it_configures_all_statement_properties(): void
    {
        $id = StatementId::fromString('39e24cc4-69af-4b01-a824-1fdc6ea8a3af');
        $actor = new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com')));
        $verb = new Verb(IRI::fromString('http://tincanapi.com/conformancetest/verbid'));
        $object = new Activity(IRI::fromString('http://tincanapi.com/conformancetest/activityid'));
        $result = new Result();
        $context = new Context();
        $created = new DateTime('2014-07-23T12:34:02-05:00');
        $stored = new DateTime('2014-07-24T12:34:02-05:00');
        $authority = new Agent(InverseFunctionalIdentifier::withOpenId('http://openid.tincanapi.com'));

        $this->withId($id);
        $this->withActor($actor);
        $this->withVerb($verb);
        $this->withObject($object);
        $this->withResult($result);
        $this->withContext($context);
        $this->withCreated($created);
        $this->withStored($stored);
        $this->withAuthority($authority);

        $statement = $this->createStatement();

        $statement->getId()->shouldBe($id);
        $statement->getActor()->shouldBe($actor);
        $statement->getVerb()->shouldBe($verb);
        $statement->getObject()->shouldBe($object);
        $statement->getResult()->shouldBe($result);
        $statement->getContext()->shouldBe($context);
        $statement->getCreated()->shouldBe($created);
        $statement->getStored()->shouldBe($stored);
        $statement->getAuthority()->shouldBe($authority);
    }

    public function it_throws_an_exception_when_a_statement_is_created_without_an_actor(): void
    {
        $this->withVerb(new Verb(IRI::fromString('http://tincanapi.com/conformancetest/verbid')));
        $this->withObject(new Activity(IRI::fromString('http://tincanapi.com/conformancetest/activityid')));

        $this->shouldThrow(InvalidStateException::class)->during('createStatement');
    }

    public function it_throws_an_exception_when_a_statement_is_created_without_a_verb(): void
    {
        $this->withActor(new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com'))));
        $this->withObject(new Activity(IRI::fromString('http://tincanapi.com/conformancetest/activityid')));

        $this->shouldThrow(InvalidStateException::class)->during('createStatement');
    }

    public function it_throws_an_exception_when_a_statement_is_created_without_an_object(): void
    {
        $this->withActor(new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com'))));
        $this->withVerb(new Verb(IRI::fromString('http://tincanapi.com/conformancetest/verbid')));

        $this->shouldThrow(InvalidStateException::class)->during('createStatement');
    }

    public function it_can_reset_the_result(): void
    {
        $this->configureAllProperties();
        $this->withResult(null);
        $statement = $this->createStatement();

        $statement->getResult()->shouldReturn(null);
    }

    public function it_can_reset_the_context(): void
    {
        $this->configureAllProperties();
        $this->withContext(null);
        $statement = $this->createStatement();

        $statement->getContext()->shouldReturn(null);
    }

    public function it_can_reset_the_created(): void
    {
        $this->configureAllProperties();
        $this->withCreated(null);
        $statement = $this->createStatement();

        $statement->getCreated()->shouldReturn(null);
    }

    public function it_can_reset_the_stored(): void
    {
        $this->configureAllProperties();
        $this->withStored(null);
        $statement = $this->createStatement();

        $statement->getStored()->shouldReturn(null);
    }

    public function it_can_reset_the_authority(): void
    {
        $this->configureAllProperties();
        $this->withAuthority(null);
        $statement = $this->createStatement();

        $statement->getAuthority()->shouldReturn(null);
    }

    private function configureAllProperties(): void
    {
        $id = StatementId::fromString('39e24cc4-69af-4b01-a824-1fdc6ea8a3af');
        $actor = new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com')));
        $verb = new Verb(IRI::fromString('http://tincanapi.com/conformancetest/verbid'));
        $object = new Activity(IRI::fromString('http://tincanapi.com/conformancetest/activityid'));
        $result = new Result();
        $context = new Context();
        $created = new DateTime('2014-07-23T12:34:02-05:00');
        $stored = new DateTime('2014-07-24T12:34:02-05:00');
        $authority = new Agent(InverseFunctionalIdentifier::withOpenId('http://openid.tincanapi.com'));

        $this->withId($id);
        $this->withActor($actor);
        $this->withVerb($verb);
        $this->withObject($object);
        $this->withResult($result);
        $this->withContext($context);
        $this->withCreated($created);
        $this->withStored($stored);
        $this->withAuthority($authority);
    }
}

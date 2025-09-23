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

use DateTime;
use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Xabbuh\XApi\Model\Activity;
use Xabbuh\XApi\Model\Agent;
use Xabbuh\XApi\Model\Attachment;
use Xabbuh\XApi\Model\Context;
use Xabbuh\XApi\Model\ContextActivities;
use Xabbuh\XApi\Model\Extensions;
use Xabbuh\XApi\Model\Group;
use Xabbuh\XApi\Model\InverseFunctionalIdentifier;
use Xabbuh\XApi\Model\IRI;
use Xabbuh\XApi\Model\IRL;
use Xabbuh\XApi\Model\LanguageMap;
use Xabbuh\XApi\Model\Result;
use Xabbuh\XApi\Model\StatementId;
use Xabbuh\XApi\Model\StatementObject;
use Xabbuh\XApi\Model\StatementReference;
use Xabbuh\XApi\Model\SubStatement;
use Xabbuh\XApi\Model\Verb;

class SubStatementSpec extends ObjectBehavior
{
    public function let(): void
    {
        $actor = new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com')));
        $verb = new Verb(IRI::fromString('http://tincanapi.com/conformancetest/verbid'), LanguageMap::create(['en-US' => 'test']));
        $object = new Activity(IRI::fromString('http://tincanapi.com/conformancetest/activityid'));
        $this->beConstructedWith($actor, $verb, $object);
    }

    public function it_is_an_xapi_object(): void
    {
        $actor = new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com')));
        $verb = new Verb(IRI::fromString('http://tincanapi.com/conformancetest/verbid'), LanguageMap::create(['en-US' => 'test']));
        $object = new Activity(IRI::fromString('http://tincanapi.com/conformancetest/activityid'));
        $this->beConstructedWith($actor, $verb, $object);

        $this->shouldHaveType(StatementObject::class);
    }

    public function its_object_can_be_an_agent(): void
    {
        $actor = new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com')));
        $verb = new Verb(IRI::fromString('http://tincanapi.com/conformancetest/verbid'), LanguageMap::create(['en-US' => 'test']));
        $object = new Agent(InverseFunctionalIdentifier::withOpenId('http://openid.tincanapi.com'));
        $this->beConstructedWith($actor, $verb, $object);

        $this->getObject()->shouldBeAnInstanceOf(StatementObject::class);
        $this->getObject()->shouldBe($object);
    }

    public function it_does_not_equal_another_statement_with_different_timestamp(): void
    {
        $actor = new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com')));
        $verb = new Verb(IRI::fromString('http://tincanapi.com/conformancetest/verbid'), LanguageMap::create(['en-US' => 'test']));
        $object = new Agent(InverseFunctionalIdentifier::withOpenId('http://openid.tincanapi.com'));
        $this->beConstructedWith($actor, $verb, $object, null, null, new DateTime('2014-07-23T12:34:02-05:00'));

        $otherStatement = new SubStatement($actor, $verb, $object, null, null, new DateTime('2015-07-23T12:34:02-05:00'));

        $this->equals($otherStatement)->shouldBe(false);
    }

    public function it_equals_another_statement_with_same_timestamp(): void
    {
        $actor = new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com')));
        $verb = new Verb(IRI::fromString('http://tincanapi.com/conformancetest/verbid'), LanguageMap::create(['en-US' => 'test']));
        $object = new Agent(InverseFunctionalIdentifier::withOpenId('http://openid.tincanapi.com'));
        $this->beConstructedWith($actor, $verb, $object, null, null, new DateTime('2014-07-23T12:34:02-05:00'));

        $otherStatement = new SubStatement($actor, $verb, $object, null, null, new DateTime('2014-07-23T12:34:02-05:00'));

        $this->equals($otherStatement)->shouldBe(true);
    }

    public function it_is_different_from_another_sub_statement_if_contexts_differ(): void
    {
        $actor = new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com')));
        $verb = new Verb(IRI::fromString('http://tincanapi.com/conformancetest/verbid'), LanguageMap::create(['en-US' => 'test']));
        $object = new Activity(IRI::fromString('http://tincanapi.com/conformancetest/activityid'));
        $this->beConstructedWith($actor, $verb, $object, null, new Context());

        $subStatement = new SubStatement($actor, $verb, $object);

        $this->equals($subStatement)->shouldReturn(false);

        $context = new Context();
        $context = $context->withRegistration('16fd2706-8baf-433b-82eb-8c7fada847da')
            ->withInstructor(new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com'))))
            ->withTeam(new Group(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest-group@tincanapi.com'))))
            ->withContextActivities(new ContextActivities(
                [new Activity(IRI::fromString('http://tincanapi.com/conformancetest/activityid'))],
                [new Activity(IRI::fromString('http://tincanapi.com/conformancetest/activityid'))],
                [new Activity(IRI::fromString('http://tincanapi.com/conformancetest/activityid'))],
                [new Activity(IRI::fromString('http://tincanapi.com/conformancetest/activityid'))]
            ))
            ->withRevision('test')
            ->withPlatform('test')
            ->withLanguage('en-US')
            ->withStatement(new StatementReference(StatementId::fromString('16fd2706-8baf-433b-82eb-8c7fada847da')))
            ->withExtensions(new Extensions());
        $subStatement = new SubStatement($actor, $verb, $object, null, $context);

        $this->equals($subStatement)->shouldReturn(false);
    }

    public function it_rejects_to_hold_another_sub_statement_as_object(): void
    {
        $actor = new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com')));
        $verb = new Verb(IRI::fromString('http://tincanapi.com/conformancetest/verbid'), LanguageMap::create(['en-US' => 'test']));
        $object = new Activity(IRI::fromString('http://tincanapi.com/conformancetest/activityid'));
        $subStatement = new SubStatement($actor, $verb, $object);

        $this->shouldThrow(InvalidArgumentException::class)->during('__construct', [$actor, $verb, $subStatement]);
    }

    public function it_returns_a_new_instance_with_actor(): void
    {
        $actor = new Agent(InverseFunctionalIdentifier::withOpenId('http://openid.tincanapi.com'));
        $subStatement = $this->withActor($actor);

        $subStatement->shouldNotBe($this);
        $subStatement->shouldBeAnInstanceOf(SubStatement::class);
        $subStatement->getActor()->shouldReturn($actor);
    }

    public function it_returns_a_new_instance_with_verb(): void
    {
        $verb = new Verb(IRI::fromString('http://adlnet.gov/expapi/verbs/voided'));
        $subStatement = $this->withVerb($verb);

        $subStatement->shouldNotBe($this);
        $subStatement->shouldBeAnInstanceOf(SubStatement::class);
        $subStatement->getVerb()->shouldReturn($verb);
    }

    public function it_returns_a_new_instance_with_object(): void
    {
        $statementReference = new StatementReference(StatementId::fromString('12345678-1234-5678-8234-567812345678'));
        $subStatement = $this->withObject($statementReference);

        $subStatement->shouldNotBe($this);
        $subStatement->shouldBeAnInstanceOf(SubStatement::class);
        $subStatement->getObject()->shouldReturn($statementReference);
    }

    public function it_returns_a_new_instance_with_result(): void
    {
        $result = new Result();
        $subStatement = $this->withResult($result);

        $subStatement->shouldNotBe($this);
        $subStatement->shouldBeAnInstanceOf(SubStatement::class);
        $subStatement->getResult()->shouldReturn($result);
    }

    public function it_returns_a_new_instance_with_context(): void
    {
        $context = new Context();
        $subStatement = $this->withContext($context);

        $subStatement->shouldNotBe($this);
        $subStatement->shouldBeAnInstanceOf(SubStatement::class);
        $subStatement->getContext()->shouldReturn($context);
    }

    public function it_returns_a_new_instance_with_attachments(): void
    {
        $attachments = [new Attachment(
                            IRI::fromString('http://id.tincanapi.com/attachment/supporting_media'),
                            'text/plain',
                            18,
                            'bd1a58265d96a3d1981710dab8b1e1ed04a8d7557ea53ab0cf7b44c04fd01545',
                            LanguageMap::create(['en-US' => 'Text attachment']),
                            LanguageMap::create(['en-US' => 'Text attachment description']),
                            IRL::fromString('http://tincanapi.com/conformancetest/attachment/fileUrlOnly')
                        )];
        $statement = $this->withAttachments($attachments);

        $statement->shouldNotBe($this);
        $statement->shouldBeAnInstanceOf(SubStatement::class);
        $statement->getAttachments()->shouldReturn($attachments);
    }

    public function it_ignores_array_keys_in_attachment_lists(): void
    {
        $textAttachment = new Attachment(
            IRI::fromString('http://id.tincanapi.com/attachment/supporting_media'),
            'text/plain',
            18,
            'bd1a58265d96a3d1981710dab8b1e1ed04a8d7557ea53ab0cf7b44c04fd01545',
            LanguageMap::create(['en-US' => 'Text attachment']),
            LanguageMap::create(['en-US' => 'Text attachment description']),
            IRL::fromString('http://tincanapi.com/conformancetest/attachment/fileUrlOnly')
        );
        $attachments = [1 => $textAttachment];

        $actor = new Agent(InverseFunctionalIdentifier::withMbox(IRI::fromString('mailto:conformancetest@tincanapi.com')));
        $verb = new Verb(IRI::fromString('http://tincanapi.com/conformancetest/verbid'), LanguageMap::create(['en-US' => 'test']));
        $object = new Activity(IRI::fromString('http://tincanapi.com/conformancetest/activityid'));
        $this->beConstructedWith($actor, $verb, $object, null, null, null, $attachments);

        $this->getAttachments()->shouldBeArray();
        $this->getAttachments()->shouldHaveKeyWithValue(0, $textAttachment);

        $statement = $this->withAttachments($attachments);

        $statement->getAttachments()->shouldBeArray();
        $statement->getAttachments()->shouldHaveKeyWithValue(0, $textAttachment);
    }
}

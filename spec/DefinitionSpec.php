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
use SplObjectStorage;
use Xabbuh\XApi\Model\Definition;
use Xabbuh\XApi\Model\Extensions;
use Xabbuh\XApi\Model\IRI;
use Xabbuh\XApi\Model\IRL;
use Xabbuh\XApi\Model\LanguageMap;

class DefinitionSpec extends ObjectBehavior
{
    public function its_properties_can_be_read(): void
    {
        $name = LanguageMap::create(['en-US' => 'test']);
        $description = LanguageMap::create(['en-US' => 'test']);
        $this->beConstructedWith(
            $name,
            $description,
            IRI::fromString('http://id.tincanapi.com/activitytype/unit-test'),
            IRL::fromString('https://github.com/adlnet/xAPI_LRS_Test')
        );

        $this->getName()->shouldReturn($name);
        $this->getDescription()->shouldReturn($description);
        $this->getType()->equals(IRI::fromString('http://id.tincanapi.com/activitytype/unit-test'))->shouldReturn(true);
        $this->getMoreInfo()->equals(IRL::fromString('https://github.com/adlnet/xAPI_LRS_Test'))->shouldReturn(true);
    }

    public function it_can_be_empty(): void
    {
        $this->getName()->shouldReturn(null);
        $this->getDescription()->shouldReturn(null);
        $this->getType()->shouldReturn(null);
        $this->getMoreInfo()->shouldReturn(null);

        $this->equals($this->createEmptyDefinition())->shouldReturn(true);
    }

    public function it_returns_a_new_instance_with_name(): void
    {
        $name = new LanguageMap();
        $definition = $this->withName($name);

        $this->getName()->shouldBeNull();

        $definition->shouldNotBe($this);
        if (($wrappedObject = $this->getWrappedObject()) !== null) {
            $definition->shouldBeAnInstanceOf($wrappedObject::class);
        }

        $definition->getName()->shouldReturn($name);
    }

    public function it_returns_a_new_instance_with_description(): void
    {
        $description = new LanguageMap();
        $definition = $this->withDescription($description);

        $this->getDescription()->shouldBeNull();

        $definition->shouldNotBe($this);
        if (($wrappedObject = $this->getWrappedObject()) !== null) {
            $definition->shouldBeAnInstanceOf($wrappedObject::class);
        }

        $definition->getDescription()->shouldReturn($description);
    }

    public function it_returns_a_new_instance_with_type(): void
    {
        $definition = $this->withType(IRI::fromString('http://id.tincanapi.com/activitytype/unit-test'));

        $this->getType()->shouldBeNull();

        $definition->shouldNotBe($this);
        if (($wrappedObject = $this->getWrappedObject()) !== null) {
            $definition->shouldBeAnInstanceOf($wrappedObject::class);
        }

        $definition->getType()->equals(IRI::fromString('http://id.tincanapi.com/activitytype/unit-test'))->shouldReturn(true);
    }

    public function it_returns_a_new_instance_with_more_info(): void
    {
        $definition = $this->withMoreInfo(IRL::fromString('https://github.com/adlnet/xAPI_LRS_Test'));

        $this->getMoreInfo()->shouldBeNull();

        $definition->shouldNotBe($this);
        if (($wrappedObject = $this->getWrappedObject()) !== null) {
            $definition->shouldBeAnInstanceOf($wrappedObject::class);
        }

        $definition->getMoreInfo()->equals(IRL::fromString('https://github.com/adlnet/xAPI_LRS_Test'))->shouldReturn(true);
    }

    public function it_returns_a_new_instance_with_extensions(): void
    {
        $extensions = new SplObjectStorage();
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/topic'), 'Conformance Testing');
        $extensions = new Extensions($extensions);

        $definition = $this->withExtensions($extensions);

        $this->getExtensions()->shouldBeNull();

        $definition->shouldNotBe($this);
        if (($wrappedObject = $this->getWrappedObject()) !== null) {
            $definition->shouldBeAnInstanceOf($wrappedObject::class);
        }

        $definition->getExtensions()->shouldReturn($extensions);
    }

    public function it_is_different_when_names_are_omitted_and_other_definition_contains_an_empty_list_of_names(): void
    {
        $this->equals(new Definition(new LanguageMap()))->shouldReturn(false);
    }

    public function it_is_different_when_descriptions_are_omitted_and_other_definition_contains_an_empty_list_of_descriptions(): void
    {
        $this->equals(new Definition(null, new LanguageMap()))->shouldReturn(false);
    }

    public function it_is_not_equal_to_other_definition_if_only_this_definition_has_a_type(): void
    {
        $this->beConstructedWith(null, null, IRI::fromString('http://id.tincanapi.com/activitytype/unit-test'));

        $this->equals($this->createEmptyDefinition())->shouldReturn(false);
    }

    public function it_is_not_equal_to_other_definition_if_only_the_other_definition_has_a_type(): void
    {
        $this->beConstructedWith();

        $definition = $this->createEmptyDefinition();
        $definition = $definition->withType(IRI::fromString('http://id.tincanapi.com/activitytype/unit-test'));

        $this->equals($definition)->shouldReturn(false);
    }

    public function it_is_not_equal_to_other_definition_if_types_are_not_equal(): void
    {
        $this->beConstructedWith(null, null, IRI::fromString('http://id.tincanapi.com/activitytype/unit-test'));

        $definition = $this->createEmptyDefinition();
        $definition = $definition->withType(IRI::fromString('http://id.tincanapi.com/activity-type/unit-test'));

        $this->equals($definition)->shouldReturn(false);
    }

    public function it_is_not_equal_to_other_definition_if_only_this_definition_has_more_info(): void
    {
        $this->beConstructedWith(null, null, null, IRL::fromString('https://github.com/adlnet/xAPI_LRS_Test'));

        $this->equals($this->createEmptyDefinition())->shouldReturn(false);
    }

    public function it_is_not_equal_to_other_definition_if_only_the_other_definition_has_more_info(): void
    {
        $this->beConstructedWith();

        $definition = $this->createEmptyDefinition();
        $definition = $definition->withMoreInfo(IRL::fromString('https://github.com/adlnet/xAPI_LRS_Test'));

        $this->equals($definition)->shouldReturn(false);
    }

    public function it_is_not_equal_to_other_definition_if_more_infos_are_not_equal(): void
    {
        $this->beConstructedWith(null, null, null, IRL::fromString('https://github.com/adlnet/xAPI_LRS_Test'));

        $definition = $this->createEmptyDefinition();
        $definition = $definition->withMoreInfo(IRL::fromString('https://github.com/adlnet/xAPI-Spec'));

        $this->equals($definition)->shouldReturn(false);
    }

    public function it_is_not_equal_to_other_definition_if_only_this_definition_has_extensions(): void
    {
        $extensions = new SplObjectStorage();
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/topic'), 'Conformance Testing');
        $this->beConstructedWith(null, null, null, null, new Extensions($extensions));

        $this->equals($this->createEmptyDefinition())->shouldReturn(false);
    }

    public function it_is_not_equal_to_other_definition_if_only_the_other_definition_has_extensions(): void
    {
        $this->beConstructedWith();

        $extensions = new SplObjectStorage();
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/topic'), 'Conformance Testing');

        $definition = $this->createEmptyDefinition();
        $definition = $definition->withExtensions(new Extensions($extensions));

        $this->equals($definition)->shouldReturn(false);
    }

    public function it_is_not_equal_to_other_definition_if_extensions_are_not_equal(): void
    {
        $extensions = new SplObjectStorage();
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/subject'), 'Conformance Testing');
        $this->beConstructedWith(null, null, null, null, new Extensions($extensions));

        $extensions = new SplObjectStorage();
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/topic'), 'Conformance Testing');

        $definition = $this->createEmptyDefinition();
        $definition = $definition->withExtensions(new Extensions($extensions));

        $this->equals($definition)->shouldReturn(false);
    }

    public function it_is_equal_to_other_definition_if_properties_are_equal(): void
    {
        $extensions = new SplObjectStorage();
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/topic'), 'Conformance Testing');
        $this->beConstructedWith(
            LanguageMap::create(['en-US' => 'test']),
            LanguageMap::create(['en-US' => 'test']),
            IRI::fromString('http://id.tincanapi.com/activitytype/unit-test'),
            IRL::fromString('https://github.com/adlnet/xAPI_LRS_Test'),
            new Extensions($extensions)
        );

        $extensions = new SplObjectStorage();
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/topic'), 'Conformance Testing');

        $definition = $this->createEmptyDefinition();
        $definition = $definition->withName(LanguageMap::create(['en-US' => 'test']));
        $definition = $definition->withDescription(LanguageMap::create(['en-US' => 'test']));
        $definition = $definition->withType(IRI::fromString('http://id.tincanapi.com/activitytype/unit-test'));
        $definition = $definition->withMoreInfo(IRL::fromString('https://github.com/adlnet/xAPI_LRS_Test'));
        $definition = $definition->withExtensions(new Extensions($extensions));

        $this->equals($definition)->shouldReturn(true);
    }

    protected function createEmptyDefinition(): Definition
    {
        return new Definition();
    }
}

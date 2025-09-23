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
use Xabbuh\XApi\Model\Extensions;
use Xabbuh\XApi\Model\IRI;
use Xabbuh\XApi\Model\Result;
use Xabbuh\XApi\Model\Score;

class ResultSpec extends ObjectBehavior
{
    public function its_properties_can_be_read(): void
    {
        $score = new Score(1);
        $this->beConstructedWith($score, true, true, 'test', 'PT2H');

        $this->getScore()->shouldReturn($score);
        $this->getSuccess()->shouldReturn(true);
        $this->getCompletion()->shouldReturn(true);
        $this->getResponse()->shouldReturn('test');
        $this->getDuration()->shouldReturn('PT2H');
    }

    public function it_can_be_empty(): void
    {
        $this->getScore()->shouldReturn(null);
        $this->getSuccess()->shouldReturn(null);
        $this->getCompletion()->shouldReturn(null);
        $this->getResponse()->shouldReturn(null);
        $this->getDuration()->shouldReturn(null);

        $this->equals(new Result())->shouldReturn(true);
    }

    public function it_is_empty_and_is_not_equal_to_a_result_with_a_score(): void
    {
        $this->equals(new Result(new Score(1)))->shouldReturn(false);
    }

    public function it_is_not_equal_to_other_result_if_not_both_results_have_extensions(): void
    {
        $this->beConstructedWith(new Score(1), true, true, 'test', 'PT2H');

        $extensions = new SplObjectStorage();
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/topic'), 'Conformance Testing');
        $this
            ->equals(new Result(new Score(1), true, true, 'test', 'PT2H', new Extensions($extensions)))
            ->shouldReturn(false);
    }

    public function it_is_not_equal_to_other_result_if_extensions_are_not_equal(): void
    {
        $extensions = new SplObjectStorage();
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/topic'), 'Conformance Testing');
        $this->beConstructedWith(new Score(1), true, true, 'test', 'PT2H', new Extensions($extensions));

        $extensions = new SplObjectStorage();
        $extensions->attach(IRI::fromString('http://id.tincanapi.com/extension/subject'), 'Conformance Testing');
        $this
            ->equals(new Result(new Score(1), true, true, 'test', 'PT2H', new Extensions($extensions)))
            ->shouldReturn(false);
    }

    public function it_returns_a_new_instance_with_score(): void
    {
        $score = new Score(1);
        $result = $this->withScore($score);

        $this->getScore()->shouldBeNull();

        $result->shouldNotBe($this);
        $result->shouldBeAnInstanceOf(Result::class);
        $result->getScore()->shouldReturn($score);
    }

    public function it_returns_a_new_instance_with_success(): void
    {
        $this->beConstructedWith(null, false);
        $result = $this->withSuccess(true);

        $this->getSuccess()->shouldReturn(false);

        $result->shouldNotBe($this);
        $result->shouldBeAnInstanceOf(Result::class);
        $result->getSuccess()->shouldReturn(true);
    }

    public function it_returns_a_new_instance_with_completion(): void
    {
        $this->beConstructedWith(null, null, false);
        $result = $this->withCompletion(true);

        $this->getCompletion()->shouldReturn(false);

        $result->shouldNotBe($this);
        $result->shouldBeAnInstanceOf(Result::class);
        $result->getCompletion()->shouldReturn(true);
    }

    public function it_returns_a_new_instance_with_response(): void
    {
        $result = $this->withResponse('test');

        $this->getResponse()->shouldReturn(null);

        $result->shouldNotBe($this);
        $result->shouldBeAnInstanceOf(Result::class);
        $result->getResponse()->shouldReturn('test');
    }

    public function it_returns_a_new_instance_with_duration(): void
    {
        $result = $this->withDuration('PT2H');

        $this->getDuration()->shouldReturn(null);

        $result->shouldNotBe($this);
        $result->shouldBeAnInstanceOf(Result::class);
        $result->getDuration()->shouldReturn('PT2H');
    }

    public function it_returns_a_new_instance_with_extensions(): void
    {
        $extensions = new Extensions();
        $result = $this->withExtensions($extensions);

        $this->getScore()->shouldBeNull();

        $result->shouldNotBe($this);
        $result->shouldBeAnInstanceOf(Result::class);
        $result->getExtensions()->shouldReturn($extensions);
    }
}

<?php

/*
 * This file is part of the xAPI package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Xabbuh\XApi\Model;

use DateTimeImmutable;
use PhpSpec\ObjectBehavior;
use Xabbuh\XApi\Model\ProfileDocument;

/**
 * @author Mathieu Boldo <mathieu.boldo@entrili.com>
 */
class ProfileDocumentSpec extends ObjectBehavior
{
    private DateTimeImmutable $updatedAt;

    public function let(): void
    {
        $this->updatedAt = new DateTimeImmutable('2026-10-06T12:00:00+00:00');
        $this->beConstructedWith('{"progress":0.5}', 'application/json', $this->updatedAt);
    }

    public function it_is_a_profile_document(): void
    {
        $this->shouldHaveType(ProfileDocument::class);
    }

    public function it_exposes_its_content_metadata(): void
    {
        $this->content->shouldReturn('{"progress":0.5}');
        $this->contentType->shouldReturn('application/json');
        $this->updated->shouldReturn($this->updatedAt);
    }
}

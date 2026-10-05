<?php

declare(strict_types=1);

/*
 * This file is part of the xAPI package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Xabbuh\XApi\Model;

use DateTimeImmutable;

final readonly class ProfileDocument
{
    public function __construct(
        public string $content,
        public string $contentType,
        public DateTimeImmutable $updated
    ) { }
}

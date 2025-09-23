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

/**
 * A {@link Profile} related to an {@link Activity}.
 *
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
final class ActivityProfile extends Profile
{
    public function __construct(string $profileId, private readonly Activity $activity)
    {
        parent::__construct($profileId);
    }

    /**
     * Returns the {@link Activity}.
     */
    public function getActivity(): Activity
    {
        return $this->activity;
    }
}

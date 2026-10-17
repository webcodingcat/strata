<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Group;

use WebCodingCat\WpAppFramework\Value\Labeled;

/**
 * Where the blocks of a group sit along its direction.
 */
enum GroupJustify: string implements Labeled
{
    case Start = 'start';
    case Center = 'center';
    case End = 'end';
    case Between = 'between';

    public function label(): string
    {
        return $this === self::Between ? 'Space between' : ucfirst($this->value);
    }
}

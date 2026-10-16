<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Heading;

use Saij\WpAppFramework\Value\Labeled;

enum HeadingLevel: int implements Labeled
{
    case One = 1;
    case Two = 2;
    case Three = 3;
    case Four = 4;

    public function label(): string
    {
        return 'Heading ' . $this->value;
    }
}

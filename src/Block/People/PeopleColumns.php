<?php

declare(strict_types=1);

namespace Saij\Strata\Block\People;

use Saij\WpAppFramework\Value\Labeled;

/**
 * People per row from `md` on; below, two per row (one with two columns).
 */
enum PeopleColumns: string implements Labeled
{
    case Two = '2';
    case Three = '3';
    case Four = '4';

    public function label(): string
    {
        return $this->value . ' per row';
    }
}

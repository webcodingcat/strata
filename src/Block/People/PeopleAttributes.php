<?php

declare(strict_types=1);

namespace Saij\Strata\Block\People;

final readonly class PeopleAttributes
{
    public function __construct(
        public PeopleColumns $columns = PeopleColumns::Three,
    ) {}
}

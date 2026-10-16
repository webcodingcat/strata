<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Columns;

use Saij\Strata\Block\Group\GroupGap;

final readonly class ColumnsAttributes
{
    public function __construct(
        public ColumnsRatio $ratio = ColumnsRatio::Equal,
        public GroupGap $gap = GroupGap::Large,
    ) {}
}

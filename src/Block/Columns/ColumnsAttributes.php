<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Columns;

use WebCodingCat\Strata\Block\Group\GroupGap;

final readonly class ColumnsAttributes
{
    public function __construct(
        public ColumnsRatio $ratio = ColumnsRatio::Equal,
        public GroupGap $gap = GroupGap::Large,
    ) {}
}

<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Columns;

final readonly class ColumnAttributes
{
    public function __construct(
        public ColumnAlign $verticalAlign = ColumnAlign::Start,
    ) {}
}

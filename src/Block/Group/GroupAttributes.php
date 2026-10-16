<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Group;

final readonly class GroupAttributes
{
    public function __construct(
        public GroupLayout $layout = GroupLayout::Stack,
        public GroupJustify $justify = GroupJustify::Start,
        public GroupAlign $alignItems = GroupAlign::Stretch,
        public GroupGap $gap = GroupGap::Normal,
        public bool $wrap = true,
    ) {}
}

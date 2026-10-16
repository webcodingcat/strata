<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Buttons;

final readonly class ButtonsAttributes
{
    public function __construct(
        public ButtonsJustify $justify = ButtonsJustify::Start,
    ) {}
}

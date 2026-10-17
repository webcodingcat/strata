<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Buttons;

final readonly class ButtonsAttributes
{
    public function __construct(
        public ButtonsJustify $justify = ButtonsJustify::Start,
    ) {}
}

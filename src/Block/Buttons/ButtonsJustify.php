<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Buttons;

use WebCodingCat\WpAppFramework\Value\Labeled;

enum ButtonsJustify: string implements Labeled
{
    case Start = 'start';
    case Center = 'center';
    case End = 'end';

    public function label(): string
    {
        return ucfirst($this->value);
    }
}

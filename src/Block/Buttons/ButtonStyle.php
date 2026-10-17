<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Buttons;

use WebCodingCat\WpAppFramework\Value\Labeled;

enum ButtonStyle: string implements Labeled
{
    case Primary = 'primary';
    case Secondary = 'secondary';
    case Text = 'text';

    public function label(): string
    {
        return ucfirst($this->value);
    }
}

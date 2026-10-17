<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Facts;

use WebCodingCat\WpAppFramework\Value\Labeled;

/**
 * The icon of a fact (drawn in Fact.twig).
 */
enum FactIcon: string implements Labeled
{
    case None = 'none';
    case Info = 'info';
    case Clock = 'clock';
    case Calendar = 'calendar';
    case Place = 'place';
    case Phone = 'phone';
    case Mail = 'mail';
    case People = 'people';
    case Music = 'music';
    case Star = 'star';
    case Heart = 'heart';

    public function label(): string
    {
        return match ($this) {
            self::None => 'No icon',
            default => ucfirst($this->value),
        };
    }
}

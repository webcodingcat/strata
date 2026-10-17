<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\Facts;

use WebCodingCat\WpAppFramework\Value\Link;
use WebCodingCat\WpAppFramework\Value\PlainText;

final readonly class FactAttributes
{
    public function __construct(
        public FactIcon $icon = FactIcon::Info,
        #[PlainText]
        public string $label = '',
        #[PlainText(multiline: true)]
        public string $value = '',
        public Link $link = new Link(),
    ) {}
}

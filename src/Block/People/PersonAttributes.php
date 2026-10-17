<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\People;

use WebCodingCat\WpAppFramework\Value\Image;
use WebCodingCat\WpAppFramework\Value\Label;
use WebCodingCat\WpAppFramework\Value\PlainText;

final readonly class PersonAttributes
{
    public function __construct(
        #[Image]
        #[Label('Photo')]
        public ?int $photoId = null,
        #[PlainText]
        public string $name = '',
        #[PlainText]
        public string $role = '',
        #[PlainText]
        public string $phone = '',
        #[PlainText]
        public string $email = '',
    ) {}
}

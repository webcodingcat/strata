<?php

declare(strict_types=1);

namespace Saij\Strata\Block\People;

use Saij\WpAppFramework\Value\Image;
use Saij\WpAppFramework\Value\Label;
use Saij\WpAppFramework\Value\PlainText;

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

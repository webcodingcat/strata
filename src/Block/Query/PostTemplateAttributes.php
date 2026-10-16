<?php

declare(strict_types=1);

namespace Saij\Strata\Block\Query;

use Saij\WpAppFramework\Value\Label;
use Saij\WpAppFramework\Value\PlainText;

final readonly class PostTemplateAttributes
{
    public function __construct(
        public PostTemplateLayout $layout = PostTemplateLayout::List,
        #[PlainText(inspector: true)]
        #[Label('Text without posts')]
        public string $emptyText = 'Nothing found.',
    ) {}
}

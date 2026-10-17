<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Block\People;

use WebCodingCat\Strata\Block\Category;
use WebCodingCat\WpAppFramework\Block\Block;
use WebCodingCat\WpAppFramework\Twig\TemplateRenderer;

/**
 * A person: portrait photo, name, role, and phone and email as links when given.
 */
#[Block('person', title: 'Person', category: Category::Content, icon: 'admin-users', parent: [People::class])]
final readonly class Person
{
    public function __construct(private TemplateRenderer $renderer) {}

    public function render(PersonAttributes $attrs): string
    {
        return $this->renderer->render('Block/People/Person.twig', [
            'attrs' => $attrs,
            // The number for the tel: link: digits and a leading plus only.
            'tel' => (string) preg_replace('/(?!^\+)[^0-9]/', '', trim($attrs->phone)),
        ]);
    }
}

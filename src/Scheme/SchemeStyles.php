<?php

declare(strict_types=1);

namespace WebCodingCat\Strata\Scheme;

use WebCodingCat\WpAppFramework\Hook\Hook;
use WebCodingCat\WpAppFramework\View\ViewData;

/**
 * Prints the color schemes as CSS variables after the stylesheet of the theme (front end and editor canvas): the
 * page scheme on :root, each scheme on its class (the page scheme too, for blocks inside other schemes). The tones derive from them in assets/styles.css. The colors
 * and identifiers are checked by their patterns (#[Color], #[Identifier]), so they are safe in CSS.
 *
 * In the block editor the schemes are view data for the control of the block support (ColorSchemeSupport.editor.js).
 */
final readonly class SchemeStyles
{
    /** Handle of the stylesheet the framework loads ({slug}-styles). */
    private const string HANDLE = 'strata-styles';

    public function __construct(private ColorSchemes $schemes) {}

    public static function className(ColorScheme $scheme): string
    {
        return 'scheme-' . $scheme->id;
    }

    /**
     * After the framework enqueued the stylesheet on the same action.
     */
    #[Hook('enqueue_block_assets', priority: 20)]
    public function print(): void
    {
        wp_add_inline_style(self::HANDLE, $this->css());
    }

    #[Hook('enqueue_block_editor_assets')]
    public function provide(ViewData $viewData): void
    {
        $viewData->set('colorSchemes', array_map(
            static fn(ColorScheme $scheme): array => [
                'id' => $scheme->id,
                'name' => $scheme->name,
                'background' => $scheme->background,
                'foreground' => $scheme->foreground,
                'accent' => $scheme->accent,
            ],
            $this->schemes->schemes,
        ));
    }

    public function css(): string
    {
        $css = ':root{' . self::variables($this->schemes->page()) . '}';
        foreach ($this->schemes->choices() as $scheme) {
            $variables = self::variables($scheme);
            if ($variables !== '') {
                $css .= '.' . self::className($scheme) . '{' . $variables . '}';
            }
        }

        return $css;
    }

    private static function variables(ColorScheme $scheme): string
    {
        $variables = '';
        foreach (['--scheme-bg' => $scheme->background, '--scheme-fg' => $scheme->foreground, '--scheme-accent' => $scheme->accent] as $name => $color) {
            if ($color !== '') {
                $variables .= $name . ':' . $color . ';';
            }
        }

        return $variables;
    }
}

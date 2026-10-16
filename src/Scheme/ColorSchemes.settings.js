/**
 * The scheme editor on the settings page: below the generated fields of each scheme, a preview of its colors and
 * the contrast of each pair, rated after WCAG (contrast.js). Empty colors keep those of the page scheme.
 */
import { registerSettingsControl } from '@saij/wp-app-framework/settings';

import { contrast, rating } from './contrast';

const RATINGS = { good: 'Good', medium: 'Medium', poor: 'Poor' };

// Inline styles: the settings page loads the script of a settings group, not a stylesheet.
const RATING_COLORS = { good: '#00703c', medium: '#8a5a00', poor: '#b32d2e' };
const PREVIEW_STYLE = {
	padding: '16px',
	borderRadius: '8px',
	border: '1px solid #ddd',
	fontSize: '15px',
	lineHeight: 1.5,
};
const BUTTON_STYLE = {
	display: 'inline-block',
	padding: '6px 14px',
	borderRadius: '6px',
	fontWeight: 600,
};

/**
 * The colors of a scheme, empty ones from the page scheme.
 *
 * @param {Object} scheme
 * @param {Object} page   The first scheme.
 * @return {{background: string, foreground: string, accent: string}} Colors.
 */
function colorsOf( scheme, page ) {
	const pick = ( key ) => scheme?.[ key ] || page?.[ key ] || '';
	return {
		background: pick( 'background' ),
		foreground: pick( 'foreground' ),
		accent: pick( 'accent' ),
	};
}

function Pair( { label, first, second } ) {
	const ratio = contrast( first, second );
	const rated = rating( ratio );
	return (
		<tr className="strata-scheme__pair">
			<th scope="row" style={ { textAlign: 'start', fontWeight: 400 } }>
				{ label }
			</th>
			<td>{ ratio === null ? '–' : `${ ratio.toFixed( 2 ) } : 1` }</td>
			<td>
				{ rated && (
					<span
						className={ `strata-scheme__rating strata-scheme__rating--${ rated }` }
						style={ {
							color: RATING_COLORS[ rated ],
							fontWeight: 600,
						} }
					>
						{ RATINGS[ rated ] }
					</span>
				) }
			</td>
		</tr>
	);
}

function SchemePreview( { scheme, page, isPage } ) {
	const { background, foreground, accent } = colorsOf( scheme, page );
	return (
		<div className="strata-scheme" style={ { marginTop: '12px' } }>
			<div
				className="strata-scheme__preview"
				style={ { ...PREVIEW_STYLE, background, color: foreground } }
			>
				<strong>{ scheme?.name || 'Scheme' }</strong>
				{ isPage && <span> · page scheme</span> }
				<p>
					Text on the background with{ ' ' }
					<span style={ { color: accent } }>an accent link</span>.
				</p>
				<span
					className="strata-scheme__button"
					style={ {
						...BUTTON_STYLE,
						background: accent,
						color: background,
					} }
				>
					Button
				</span>
			</div>
			<table
				className="strata-scheme__contrast"
				style={ { marginTop: '8px', borderSpacing: '12px 4px' } }
			>
				<tbody>
					<Pair
						label="Text on background"
						first={ foreground }
						second={ background }
					/>
					<Pair
						label="Accent on background (links, button text)"
						first={ accent }
						second={ background }
					/>
					<Pair
						label="Text on accent"
						first={ foreground }
						second={ accent }
					/>
				</tbody>
			</table>
		</div>
	);
}

registerSettingsControl(
	'color_schemes',
	[ 'schemes', '*' ],
	( { value, path, groupValue, DefaultControl } ) => (
		<>
			<DefaultControl />
			<SchemePreview
				scheme={ value }
				page={ groupValue.schemes?.[ 0 ] }
				isPage={ path[ 1 ] === 0 }
			/>
		</>
	)
);

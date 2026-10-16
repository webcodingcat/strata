/**
 * Contrast of two colors after WCAG 2.2 (relative luminance, 1:1 to 21:1) and its rating: good from 4.5 (body
 * text, level AA), medium from 3 (large text and controls only), poor below.
 */

/**
 * The red, green and blue of a hex color (#rgb, #rgba, #rrggbb, #rrggbbaa); the alpha is ignored.
 *
 * @param {string} color
 * @return {Array<number>|null} Channels 0–255, null for no color.
 */
export function channels( color ) {
	const hex = /^#([0-9a-f]{3,4}|[0-9a-f]{6}|[0-9a-f]{8})$/i.exec(
		color ?? ''
	)?.[ 1 ];
	if ( ! hex ) {
		return null;
	}
	const full =
		hex.length <= 4
			? [ ...hex.slice( 0, 3 ) ]
					.map( ( digit ) => digit + digit )
					.join( '' )
			: hex.slice( 0, 6 );
	return [ 0, 2, 4 ].map( ( start ) =>
		parseInt( full.slice( start, start + 2 ), 16 )
	);
}

function luminance( [ red, green, blue ] ) {
	const [ r, g, b ] = [ red, green, blue ].map( ( channel ) => {
		const value = channel / 255;
		return value <= 0.04045
			? value / 12.92
			: ( ( value + 0.055 ) / 1.055 ) ** 2.4;
	} );
	return 0.2126 * r + 0.7152 * g + 0.0722 * b;
}

/**
 * @param {string} first
 * @param {string} second
 * @return {number|null} Contrast ratio, null if a color is missing.
 */
export function contrast( first, second ) {
	const a = channels( first );
	const b = channels( second );
	if ( ! a || ! b ) {
		return null;
	}
	const [ light, dark ] = [ luminance( a ), luminance( b ) ].sort(
		( x, y ) => y - x
	);
	return ( light + 0.05 ) / ( dark + 0.05 );
}

/**
 * @param {number|null} ratio
 * @return {'good'|'medium'|'poor'|null} Rating.
 */
export function rating( ratio ) {
	if ( ratio === null ) {
		return null;
	}
	if ( ratio >= 4.5 ) {
		return 'good';
	}
	return ratio >= 3 ? 'medium' : 'poor';
}

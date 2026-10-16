/**
 * Color schemes: the settings group colors the page and the sections, and the settings page shows a preview and the
 * contrast of each scheme.
 */
const { test, expect } = require( '../fixtures' );

const {
	SCHEMES,
	block,
	cleanUp,
	colorSchemes,
	createPost,
	saveColorSchemes,
} = require( '../helpers' );

test.describe( 'Color schemes', () => {
	let stored;

	test.beforeEach( async ( { requestUtils } ) => {
		stored = await colorSchemes( requestUtils );
	} );

	test.afterEach( async ( { requestUtils } ) => {
		await saveColorSchemes( requestUtils, stored );
		await cleanUp( requestUtils );
	} );

	test( 'color the page and the sections as the settings say', async ( {
		page,
		requestUtils,
	} ) => {
		const schemes = stored.schemes.map( ( scheme ) => ( { ...scheme } ) );
		schemes[ 0 ].accent = '#c2410c';
		schemes[ 2 ].background = '#0b3d2e';
		// An empty color keeps the color around the section.
		schemes[ 2 ].foreground = '';
		await saveColorSchemes( requestUtils, { schemes } );

		const post = await createPost( requestUtils, {
			content: [
				block(
					'strata/section',
					{},
					block( 'strata/paragraph', {}, '<a href="#a">Accent</a>' )
				),
				block(
					'strata/section',
					{ colorScheme: SCHEMES.dark },
					block( 'strata/paragraph', {}, 'Dark' )
				),
			].join( '\n' ),
		} );
		await page.goto( post.link );

		await expect( page.locator( 'a', { hasText: 'Accent' } ) ).toHaveCSS(
			'color',
			'rgb(194, 65, 12)'
		);
		const dark = page.locator( 'main > .strata-section' ).nth( 1 );
		await expect( dark ).toHaveCSS( 'background-color', 'rgb(11, 61, 46)' );
		await expect( dark ).toHaveCSS( 'color', 'rgb(22, 24, 29)' );
	} );

	test( 'show a preview and the contrast of each scheme on the settings page', async ( {
		page,
	} ) => {
		await page.goto( '/wp-admin/themes.php?page=strata-settings' );
		const titles = page.locator( '.wp-app-framework-list__title' );
		await expect( titles ).toHaveText( [ 'Page', 'Soft', 'Dark' ] );

		await titles.nth( 2 ).click();
		const pairs = page.locator( '.strata-scheme__pair' );
		await expect( pairs ).toHaveCount( 3 );
		await expect( pairs.nth( 0 ) ).toContainText( '16.09 : 1' );
		await expect( pairs.nth( 0 ) ).toContainText( 'Good' );
		await expect( pairs.nth( 2 ) ).toContainText( 'Poor' );
		await expect( page.locator( '.strata-scheme__preview' ) ).toHaveCSS(
			'background-color',
			'rgb(22, 24, 29)'
		);
	} );
} );

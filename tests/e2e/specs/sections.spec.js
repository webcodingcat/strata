/**
 * Sections on the front end: across the whole window, their content limited to a width, colored by a scheme; columns
 * that stack on small screens; the page between header and footer.
 */
const { test, expect } = require( '../fixtures' );

const { SCHEMES, block, cleanUp, createPost } = require( '../helpers' );

const heading = ( text, level = 2 ) =>
	block( 'strata/heading', { level }, text );
const paragraph = ( text ) => block( 'strata/paragraph', {}, text );

test.describe( 'Sections', () => {
	test.afterEach( async ( { requestUtils } ) => {
		await cleanUp( requestUtils );
	} );

	test( 'span the window, limit their content and take a color scheme', async ( {
		page,
		requestUtils,
	} ) => {
		const post = await createPost( requestUtils, {
			content: [
				block(
					'strata/section',
					{ width: 'narrow' },
					heading( 'Narrow', 1 )
				),
				block(
					'strata/section',
					{ width: 'wide', colorScheme: SCHEMES.dark },
					[
						paragraph( 'On dark <a href="#x">with a link</a>' ),
						block(
							'strata/buttons',
							{},
							block( 'strata/button', {
								label: 'Go',
								link: { url: '#go' },
							} )
						),
					].join( '\n' )
				),
				block(
					'strata/section',
					{ colorScheme: 'deadbeef' },
					paragraph( 'Unknown scheme' )
				),
			].join( '\n' ),
		} );
		await page.setViewportSize( { width: 1280, height: 900 } );
		await page.goto( post.link );

		// The page between the parts: main holds the sections directly.
		await expect(
			page.locator( 'main > section.strata-section' )
		).toHaveCount( 3 );
		const sections = page.locator( 'main > .strata-section' );
		for ( const index of [ 0, 1 ] ) {
			const box = await sections.nth( index ).boundingBox();
			expect( box.x ).toBe( 0 );
			expect( box.width ).toBe( 1280 );
		}
		// narrow = 42rem, wide = 76rem.
		await expect(
			sections.nth( 0 ).locator( '.strata-section__content' )
		).toHaveCSS( 'max-width', '672px' );
		await expect(
			sections.nth( 1 ).locator( '.strata-section__content' )
		).toHaveCSS( 'max-width', '1216px' );

		// The page scheme on the page, the dark scheme on its section, with its accent.
		// The page scheme colors the root element (:root).
		await expect( page.locator( 'html' ) ).toHaveCSS(
			'background-color',
			'rgb(255, 255, 255)'
		);
		const dark = sections.nth( 1 );
		await expect( dark ).toHaveClass( /has-scheme scheme-c3f5a7d9/ );
		await expect( dark ).toHaveCSS( 'background-color', 'rgb(22, 24, 29)' );
		await expect( dark ).toHaveCSS( 'color', 'rgb(243, 244, 241)' );
		await expect(
			dark.locator( 'a', { hasText: 'with a link' } )
		).toHaveCSS( 'color', 'rgb(138, 164, 255)' );
		const button = dark.locator( '.strata-button' );
		await expect( button ).toHaveAttribute( 'href', '#go' );
		await expect( button ).toHaveCSS(
			'background-color',
			'rgb(138, 164, 255)'
		);
		await expect( button ).toHaveCSS( 'color', 'rgb(22, 24, 29)' );

		// A scheme that does not exist keeps the scheme around the section.
		await expect( sections.nth( 2 ) ).not.toHaveClass( /has-scheme/ );

		// No horizontal scrolling.
		expect(
			await page.evaluate( () => document.documentElement.scrollWidth )
		).toBe( 1280 );
	} );

	test( 'line up the content of columns when one of them is a box', async ( {
		page,
		requestUtils,
	} ) => {
		const column = ( attributes, text ) =>
			block(
				'strata/column',
				attributes,
				block( 'strata/heading', { level: 3 }, text )
			);
		const post = await createPost( requestUtils, {
			content: block(
				'strata/section',
				{},
				block(
					'strata/columns',
					{},
					[
						column( {}, 'Plain' ),
						column( { colorScheme: SCHEMES.dark }, 'Box' ),
					].join( '\n' )
				)
			),
		} );
		await page.setViewportSize( { width: 1280, height: 900 } );
		await page.goto( post.link );
		const headings = page.locator( '.strata-column .strata-heading' );
		const plain = await headings.nth( 0 ).boundingBox();
		const box = await headings.nth( 1 ).boundingBox();
		expect( Math.round( plain.y ) ).toBe( Math.round( box.y ) );
	} );

	test( 'stack the columns on small screens', async ( {
		page,
		requestUtils,
	} ) => {
		const column = ( text ) =>
			block( 'strata/column', {}, paragraph( text ) );
		const post = await createPost( requestUtils, {
			content: block(
				'strata/section',
				{},
				block(
					'strata/columns',
					{},
					[ column( 'A' ), column( 'B' ), column( 'C' ) ].join( '\n' )
				)
			),
		} );
		const columns = page.locator( '.strata-column' );
		const tops = async () =>
			Promise.all(
				[ 0, 1, 2 ].map(
					async ( index ) =>
						( await columns.nth( index ).boundingBox() ).y
				)
			);

		await page.setViewportSize( { width: 1280, height: 900 } );
		await page.goto( post.link );
		const wide = await tops();
		expect( new Set( wide ).size ).toBe( 1 );

		await page.setViewportSize( { width: 390, height: 900 } );
		const narrow = await tops();
		expect( narrow[ 0 ] ).toBeLessThan( narrow[ 1 ] );
		expect( narrow[ 1 ] ).toBeLessThan( narrow[ 2 ] );
		expect(
			await page.evaluate( () => document.documentElement.scrollWidth )
		).toBe( 390 );
	} );

	test( 'hold lists whose items are paragraphs and nested lists', async ( {
		page,
		requestUtils,
	} ) => {
		const item = ( ...blocks ) =>
			block( 'strata/list-item', {}, blocks.join( '\n' ) );
		const post = await createPost( requestUtils, {
			content: block(
				'strata/section',
				{},
				block(
					'strata/list',
					{},
					[
						item( paragraph( 'First' ) ),
						item(
							paragraph( 'Second' ),
							block(
								'strata/list',
								{ ordered: true },
								item( paragraph( 'Nested' ) )
							)
						),
					].join( '\n' )
				)
			),
		} );
		await page.goto( post.link );

		const outer = page.locator( 'main ul.strata-list' );
		await expect( outer.locator( ':scope > li > p' ) ).toHaveText( [
			'First',
			'Second',
		] );
		await expect(
			outer.locator( ':scope > li > ol.strata-list > li > p' )
		).toHaveText( 'Nested' );
	} );

	test( 'sit between the header with the site title and the footer with links and copyright', async ( {
		page,
		requestUtils,
	} ) => {
		const post = await createPost( requestUtils, {
			content: block( 'strata/section', {}, paragraph( 'Content' ) ),
		} );
		await page.goto( post.link );

		await expect(
			page.locator( 'header.wp-block-template-part .wp-block-site-title' )
		).toBeVisible();
		const footer = page.locator( 'footer.wp-block-template-part' );
		await expect( footer.locator( '.strata-paragraph' ) ).toHaveText(
			'Imprint · Privacy policy'
		);
		await expect( footer.locator( '.strata-copyright' ) ).toContainText(
			`© ${ new Date().getFullYear() } `
		);
	} );
} );

/**
 * The navigation on the front end: a row of links on wide screens, a panel behind the menu button on small screens
 * that closes when a link to a section of the page is followed.
 */
const { test, expect } = require( '../fixtures' );

const { block, cleanUp, createPost } = require( '../helpers' );

const link = ( label, url ) =>
	block( 'strata/navigation-link', {
		label,
		link: { url, opensInNewTab: false, kind: 'url', id: 0 },
	} );
const paragraph = ( text ) => block( 'strata/paragraph', {}, text );

test.describe( 'Navigation', () => {
	test.afterEach( async ( { requestUtils } ) => {
		await cleanUp( requestUtils );
	} );

	test( 'shows a row of links on wide screens and a panel behind the menu button on small ones', async ( {
		page,
		requestUtils,
	} ) => {
		const filler = Array.from( { length: 30 }, ( _, index ) =>
			paragraph( `Line ${ index }` )
		).join( '\n' );
		const post = await createPost( requestUtils, {
			content: [
				block(
					'strata/section',
					{},
					block(
						'strata/navigation',
						{ label: 'Main', menuLabel: 'Menu' },
						[
							link( 'About', '#about' ),
							link( 'Target', '#target' ),
						].join( '\n' )
					)
				),
				block( 'strata/section', {}, filler ),
				block(
					'strata/section',
					{ anchor: 'target' },
					paragraph( 'Target section' )
				),
			].join( '\n' ),
		} );
		const nav = page.getByRole( 'navigation', { name: 'Main' } );
		const toggle = nav.getByRole( 'button', { name: 'Menu' } );
		const panel = nav.locator( '.strata-navigation__panel' );

		await page.setViewportSize( { width: 1280, height: 800 } );
		await page.goto( post.link );
		await expect( toggle ).toBeHidden();
		const about = await nav
			.getByRole( 'link', { name: 'About' } )
			.boundingBox();
		const target = await nav
			.getByRole( 'link', { name: 'Target' } )
			.boundingBox();
		expect( target.y ).toBe( about.y );
		expect( target.x ).toBeGreaterThan( about.x );

		await page.setViewportSize( { width: 390, height: 800 } );
		await expect( toggle ).toBeVisible();
		await expect(
			nav.getByRole( 'link', { name: 'Target' } )
		).toBeHidden();

		await toggle.click();
		await expect( panel ).toBeVisible();
		expect( await panel.boundingBox() ).toEqual( {
			x: 0,
			y: 0,
			width: 390,
			height: 800,
		} );

		// Following a link to a section of the page closes the panel.
		await nav.getByRole( 'link', { name: 'Target' } ).click();
		await expect( panel ).toBeHidden();
		await expect( page ).toHaveURL( /#target$/ );
		await expect( page.getByText( 'Target section' ) ).toBeInViewport();

		// Escape closes it as well.
		await toggle.click();
		await expect( panel ).toBeVisible();
		await page.keyboard.press( 'Escape' );
		await expect( panel ).toBeHidden();
	} );
} );

/**
 * A one-page site: no blog (posts, categories and tags hidden in the backend, the REST API and the front end), no
 * search on the front end, and the 404 page with a way back.
 */
const { test, expect } = require( '../fixtures' );

test.describe( 'One page', () => {
	test( 'has no blog in the backend and the REST API', async ( {
		admin,
		page,
		requestUtils,
	} ) => {
		await admin.visitAdminPage( 'index.php' );
		await expect( page.locator( '#menu-posts' ) ).toHaveCount( 0 );
		await expect( page.locator( '#menu-pages' ) ).toBeVisible();
		await expect( page.locator( '#dashboard_quick_press' ) ).toHaveCount(
			0
		);

		const types = await requestUtils.rest( { path: '/wp/v2/types' } );
		expect( Object.keys( types ) ).not.toContain( 'post' );
		expect( Object.keys( types ) ).toContain( 'page' );
	} );

	test( 'shows a page as front page since the switch to the theme', async ( {
		page,
		requestUtils,
	} ) => {
		const settings = await requestUtils.rest( { path: '/wp/v2/settings' } );
		expect( settings.show_on_front ).toBe( 'page' );
		expect( settings.page_on_front ).toBeGreaterThan( 0 );
		expect( settings.page_for_posts ).toBe( 0 );

		const response = await page.goto( '/' );
		expect( response.status() ).toBe( 200 );
		// WordPress names the shown page in the classes of the body.
		await expect( page.locator( 'body' ) ).toHaveClass(
			new RegExp( `\\bpage-id-${ settings.page_on_front }\\b` )
		);
	} );

	test( 'answers a search and an unknown address with the 404 page', async ( {
		page,
		expectConsole,
	} ) => {
		// The browser reports every page loaded with status 404.
		expectConsole.push( {
			type: 'error',
			text: 'Failed to load resource: the server responded with a status of 404',
		} );
		for ( const address of [ '/?s=strata', '/no-such-page/' ] ) {
			const response = await page.goto( address );
			expect( response.status() ).toBe( 404 );
			const main = page.locator( 'main.wp-block-template-part' );
			await expect( main.locator( 'h1' ) ).toHaveText( 'Page not found' );
			await expect(
				main.getByRole( 'link', { name: 'Back to the home page' } )
			).toHaveAttribute( 'href', '/' );
		}
	} );
} );

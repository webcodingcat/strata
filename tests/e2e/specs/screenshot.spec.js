/**
 * The screenshot of the theme (screenshot.png, 1200 × 900 as WordPress recommends): the demo page of
 * tests/e2e/demo.html as a visitor sees it, written to the results directory. tests/screenshot copies it into the
 * theme; in every other run it checks that the demo page renders.
 */
const fs = require( 'fs' );
const path = require( 'path' );

const { test, expect } = require( '../fixtures' );

const { cleanUp, createPost } = require( '../helpers' );

test.describe( 'Screenshot', () => {
	let settings;

	test.beforeEach( async ( { requestUtils } ) => {
		settings = await requestUtils.rest( { path: '/wp/v2/settings' } );
		await requestUtils.rest( {
			method: 'POST',
			path: '/wp/v2/settings',
			data: { title: 'Strata', description: 'One-page sites' },
		} );
	} );

	test.afterEach( async ( { requestUtils } ) => {
		await requestUtils.rest( {
			method: 'POST',
			path: '/wp/v2/settings',
			data: { title: settings.title, description: settings.description },
		} );
		await cleanUp( requestUtils );
	} );

	test( 'takes the screenshot of the theme from the demo page', async ( {
		browser,
		requestUtils,
	} ) => {
		const post = await createPost( requestUtils, {
			title: 'Strata',
			content: fs.readFileSync(
				path.join( __dirname, '..', 'demo.html' ),
				'utf8'
			),
		} );
		// A visitor: no admin bar.
		const context = await browser.newContext( {
			storageState: { cookies: [], origins: [] },
			viewport: { width: 1200, height: 900 },
			deviceScaleFactor: 1,
		} );
		try {
			const page = await context.newPage();
			await page.goto( post.link );
			await expect(
				page.locator( 'main > .strata-section' )
			).toHaveCount( 3 );
			await page.evaluate( () => document.fonts.ready );
			await page.screenshot( {
				path: path.join( process.env.E2E_OUTPUT_DIR, 'screenshot.png' ),
			} );
		} finally {
			await context.close();
		}
	} );
} );

<?php
/**
 * WPSEO plugin test file.
 *
 * @package WPSEO\Tests
 */

/**
 * Unit Test Class.
 */
class WPSEO_Functions_Test extends WPSEO_UnitTestCase {

	/**
	 * Tests whether wpseo_replace_vars correctly replaces replacevars.
	 *
	 * @covers ::wpseo_replace_vars
	 */
	public function test_wpseo_replace_vars() {

		// Create author.
		$user_id = $this->factory->user->create(
			[
				'user_login'   => 'User_Login',
				'display_name' => 'User_Nicename',
			]
		);

		// Create post.
		$post_id = $this->factory->post->create(
			[
				'post_title'   => 'Post_Title',
				'post_content' => 'Post_Content',
				'post_excerpt' => 'Post_Excerpt',
				'post_author'  => $user_id,
				'post_date'    => date( 'Y-m-d H:i:s', strtotime( '2000-01-01 2:30:00' ) ),
			]
		);

		// Get post.
		$post = get_post( $post_id );

		$input    = '%%title%% %%excerpt%% %%date%% %%name%%';
		$expected = 'Post_Title Post_Excerpt ' . mysql2date( get_option( 'date_format' ), $post->post_date, true ) . ' User_Nicename';
		$output   = wpseo_replace_vars( $input, (array) $post );
		$this->assertEquals( $expected, $output );

		/*
		 * @todo
		 *  - Test all Basic Variables.
		 *  - Test all Advanced Variables.
		 */
	}

	/**
	 * Tests test_wpseo_get_capabilities correctly retrieves capabilities.
	 *
	 * @covers ::wpseo_get_capabilities
	 */
	public function test_wpseo_get_capabilities() {
		$capabilities = wpseo_get_capabilities();

		$this->assertIsArray( $capabilities );
	}
}

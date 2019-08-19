<?php

namespace Aimeos\MShop;


class DemoTest extends \PHPUnit\Framework\TestCase
{
	private $object;


	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		\Aimeos\MShop::cache( true );

		// $this->object = new \Aimeos\MShop\Demo\Manager\Standard( \TestHelper::getContext() );
	}


	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		\Aimeos\MShop::cache( false );

		unset( $this->object );
	}


	public function testDemo()
	{
		$this->markTestIncomplete( 'Just a demo' );
	}
}

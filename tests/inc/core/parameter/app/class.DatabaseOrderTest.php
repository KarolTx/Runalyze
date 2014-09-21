<?php

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2014-09-19 at 18:53:43.
 */
class DatabaseOrderTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var DatabaseOrder
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp() {
		$this->object = new DatabaseOrder;
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown() {
		
	}

	/**
	 * @covers DatabaseOrder::asQuery
	 */
	public function testAsQuery() {
		$this->object->set( DatabaseOrder::ASC );
		$this->assertEquals('ORDER BY `id` ASC', $this->object->asQuery());

		$this->object->set( DatabaseOrder::DESC );
		$this->assertEquals('ORDER BY `id` DESC', $this->object->asQuery());

		$this->object->set( DatabaseOrder::ALPHA );
		$this->assertEquals('ORDER BY `name` ASC', $this->object->asQuery());
	}

}

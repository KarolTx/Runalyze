<?php

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2014-03-06 at 14:17:00.
 */
class TrimpTest extends PHPUnit_Framework_TestCase {

	/**
	 * @var Trimp
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp() {}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown() {}

	/**
	 * @covers Trimp::checkForMaxValuesAt
	 * @todo   Implement testCheckForMaxValuesAt().
	 */
	public function testCheckForMaxValuesAt() {}

	/**
	 * @covers Trimp::forTraining
	 */
	public function testForTraining() {
		$this->assertEquals(  18, Trimp::forTraining(array(
			'id'		=> 1,
			's'			=> 60*60,
			'pulse_avg'	=> 120,
			'sportid'	=> 0,
			'typeid'	=> 0
		)));

		$this->assertEquals(  36, Trimp::forTraining(array(
			'id'		=> 1,
			's'			=> 2*60*60,
			'pulse_avg'	=> 120,
			'sportid'	=> 0,
			'typeid'	=> 0
		)));

		$this->assertEquals(  49, Trimp::forTraining(array(
			'id'		=> 1,
			's'			=> 60*60,
			'pulse_avg'	=> 160,
			'sportid'	=> 0,
			'typeid'	=> 0
		)));

		$this->assertEquals(  97, Trimp::forTraining(array(
			'id'		=> 1,
			's'			=> 2*60*60,
			'pulse_avg'	=> 160,
			'sportid'	=> 0,
			'typeid'	=> 0
		)));

		$this->assertEquals( 110, Trimp::forTraining(array(
			'id'		=> 1,
			's'			=> 60*60,
			'pulse_avg'	=> 200,
			'sportid'	=> 0,
			'typeid'	=> 0
		)));
	}

	/**
	 * @covers Trimp::forTrainingID
	 */
	public function testForTrainingID() {
		DB::getInstance()->insert('training', array('sportid', 's', 'pulse_avg'), array(0, 60*60, 120) );
		$this->assertEquals( 18, Trimp::forTrainingID(1) );

		DB::getInstance()->exec('TRUNCATE TABLE `runalyze_training`');
	}

	/**
	 * @covers Trimp::ATL
	 * @covers Trimp::CTL
	 * @covers Trimp::TSB
	 * @covers Trimp::calculateMaxValues
	 * @covers Trimp::maxATL
	 * @covers Trimp::maxCTL
	 * @covers Trimp::maxTRIMP
	 * @covers Trimp::ATLinPercent
	 * @covers Trimp::CTLinPercent
	 * @covers Trimp::arrayForATLandCTLandTSBinPercent
	 */
	public function testManyTrimpValuesInDatabase() {
		$Values = array(
			200, 100, 100, 100, 100, 100,   0,
			  0,   0,   0,   0,   0,   0,   0,
			 10,  10,  10,  10,  10,  20,   0,
			 10,  10,  10,  10,  10,  20,   0,
			  0,   0,   0,   0,   0,   0,   0,
			  0,   0,   0,   0,   0,   0,   0,
			  0,   0,   0,   0,   0,   0,   0,
			 50,  50,  50,  50,  50, 100,   0,
			 50,  50,  50,  50,  50, 100,   0,
			 50,  50,  50,  50,  50, 100,   0,
			 50,  50,  50,  50,  50, 100,   0,
			 50,  50,  50,  50,  50, 100,   0,
			 50,  50,  50,  50,  50, 100,   0
		);
		foreach ($Values as $DaysBack => $Trimp)
			DB::getInstance()->insert('training', array('trimp', 'time'), array($Trimp, time()-DAY_IN_S*$DaysBack) );

		$this->assertEquals( 100, Trimp::ATL() );
		$this->assertEquals(  20, Trimp::CTL() );
		$this->assertEquals( -80, Trimp::TSB() );

		$this->assertEquals(   0, Trimp::ATL(time()-DAY_IN_S*7) );
		$this->assertEquals(   3, Trimp::CTL(time()-DAY_IN_S*7) );
		$this->assertEquals(   3, Trimp::TSB(time()-DAY_IN_S*7) );

		$this->assertEquals(  10, Trimp::ATL(time()-DAY_IN_S*14) );
		$this->assertEquals(  12, Trimp::CTL(time()-DAY_IN_S*14) );
		$this->assertEquals(   2, Trimp::TSB(time()-DAY_IN_S*14) );

		$this->assertEquals(  50, Trimp::ATL(time()-DAY_IN_S*49) );
		$this->assertEquals(  50, Trimp::CTL(time()-DAY_IN_S*49) );
		$this->assertEquals(   0, Trimp::TSB(time()-DAY_IN_S*49) );

		$this->assertEquals(  50, Trimp::ATL(time()-DAY_IN_S*70) );
		$this->assertEquals(  25, Trimp::CTL(time()-DAY_IN_S*70) );
		$this->assertEquals( -25, Trimp::TSB(time()-DAY_IN_S*70) );

		Trimp::calculateMaxValues();

		$this->assertEquals( 100, Trimp::maxATL() );
		$this->assertEquals(  50, Trimp::maxCTL() );
		$this->assertEquals( 200, Trimp::maxTRIMP() );

		$this->assertEquals( 100, Trimp::ATLinPercent() );
		$this->assertEquals(  40, Trimp::CTLinPercent() );

		$this->assertEquals( array('ATL' => 100, 'CTL' => 40, 'TSB' => -80), Trimp::arrayForATLandCTLandTSBinPercent() );

		DB::getInstance()->exec('TRUNCATE TABLE `runalyze_training`');
	}

}

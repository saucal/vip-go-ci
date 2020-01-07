<?php

require_once( __DIR__ . '/IncludesForTests.php' );

use PHPUnit\Framework\TestCase;

final class VipgociOptionsReadEnvTest extends TestCase {
	protected function setUp() {
		// Add environmental variable
		putenv(
			'PHP_ROWNER=repo-test-owner'
		);
	}

	protected function tearDown() {
		// Remove environmental variable
		putenv(
			'PHP_ROWNER'
		);
	}

	/**
	 * @covers ::vipgoci_options_read_env
	 */
	public function testOptionsReadEnv1() {
		$options = array(
			'repo-name' => 'repo-test-name',
			'env-options' => 'repo-owner=PHP_ROWNER'
		);

		$options_recognized = array(
			'repo-name:',
			'repo-owner:',
			'env-options:',
		);

		vipgoci_unittests_output_suppress();
 
		vipgoci_option_array_handle(
			$options,
			'env-options',
			array(),
			null,
			',',
			false
		);
       
		vipgoci_options_read_env(
			$options,
			$options_recognized
		);

		vipgoci_unittests_output_unsuppress();

		/*
		 * Should successfully read from environment.
		 */
		$this->assertEquals(
			array(
				'repo-owner' => 'repo-test-owner',
				'repo-name' => 'repo-test-name',
				'env-options' => array(
					0 => 'repo-owner=PHP_ROWNER',
				),
			),
			$options
		);
	}

	/**
	 * @covers ::vipgoci_options_read_env
	 */
	public function testOptionsReadEnv2() {
		$options = array(
			'repo-name' => 'repo-test-name',
			'env-options' => 'repo-owner=PHP_ROWNER500' // invalid env var
		);

		$options_recognized = array(
			'repo-name:',
			'repo-owner:',
			'env-options:',
		);

		vipgoci_unittests_output_suppress();
 
		vipgoci_option_array_handle(
			$options,
			'env-options',
			array(),
			null,
			',',
			false
		);
       
		vipgoci_options_read_env(
			$options,
			$options_recognized
		);

		vipgoci_unittests_output_unsuppress();

		/*
		 * Should not have read from environment.
		 */
		$this->assertEquals(
			array(
				'repo-name' => 'repo-test-name',
				'env-options' => array(
					0 => 'repo-owner=PHP_ROWNER500',
				),
			),
			$options
		);
	}


	/**
	 * @covers ::vipgoci_options_read_env
	 */
	public function testOptionsReadEnv3() {
		$options = array(
			'repo-name' => 'repo-test-name',
			// No env-options
		);

		$options_recognized = array(
			'repo-name:',
			'repo-owner:',
			'env-options:',
		);

		vipgoci_unittests_output_suppress();
 
		vipgoci_option_array_handle(
			$options,
			'env-options',
			array(),
			null,
			',',
			false
		);
       
		vipgoci_options_read_env(
			$options,
			$options_recognized
		);

		vipgoci_unittests_output_unsuppress();

		/*
		 * Should not have read from environment.
		 */
		$this->assertEquals(
			array(
				'repo-name' => 'repo-test-name',
				'env-options' => array(
				),
			),
			$options
		);
	}

	/**
	 * @covers ::vipgoci_options_read_env
	 */
	public function testOptionsReadEnv4() {
		$options = array(
			'repo-name' => 'repo-test-name',
			'env-options' => 'FOO=TEST', // invalid option, is not recognized
		);

		$options_recognized = array(
			'repo-name:',
			'repo-owner:',
			'env-options:',
		);

		vipgoci_unittests_output_suppress();
 
		vipgoci_option_array_handle(
			$options,
			'env-options',
			array(),
			null,
			',',
			false
		);
       
		vipgoci_options_read_env(
			$options,
			$options_recognized
		);

		vipgoci_unittests_output_unsuppress();

		/*
		 * Should not have read from environment.
		 */
		$this->assertEquals(
			array(
				'repo-name' => 'repo-test-name',
				'env-options' => array(
					0 => 'FOO=TEST',
				),
			),
			$options
		);
	}

	/**
	 * @covers ::vipgoci_options_read_env
	 */
	public function testOptionsReadEnv5() {
		$options = array(
			'repo-name' => 'repo-test-name',
			'env-options' => 'env-options=TEST', // invalid option, is not allowed
		);

		$options_recognized = array(
			'repo-name:',
			'repo-owner:',
			'env-options:',
		);

		vipgoci_unittests_output_suppress();
 
		vipgoci_option_array_handle(
			$options,
			'env-options',
			array(),
			null,
			',',
			false
		);
       
		vipgoci_options_read_env(
			$options,
			$options_recognized
		);

		vipgoci_unittests_output_unsuppress();

		/*
		 * Should not have read from environment.
		 */
		$this->assertEquals(
			array(
				'repo-name' => 'repo-test-name',
				'env-options' => array(
					0 => 'env-options=TEST',
				),
			),
			$options
		);
	}

	/**
	 * @covers ::vipgoci_options_read_env
	 */
	public function testOptionsReadEnv6() {
		$options = array(
			'repo-name' => 'repo-test-name',
			'env-options' => 'repo-name=PHP_ROWNER', // invalid option, already specified
		);

		$options_recognized = array(
			'repo-name:',
			'repo-owner:',
			'env-options:',
		);

		vipgoci_unittests_output_suppress();
 
		vipgoci_option_array_handle(
			$options,
			'env-options',
			array(),
			null,
			',',
			false
		);
       
		vipgoci_options_read_env(
			$options,
			$options_recognized
		);

		vipgoci_unittests_output_unsuppress();

		/*
		 * Should not have read from environment.
		 */
		$this->assertEquals(
			array(
				'repo-name' => 'repo-test-name',
				'env-options' => array(
					0 => 'repo-name=PHP_ROWNER',
				),
			),
			$options
		);
	}
}

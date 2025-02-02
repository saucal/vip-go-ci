<?php

declare(strict_types=1);

namespace Vipgoci\Tests\Unit;

require_once( __DIR__ . './../../defines.php' );
require_once( __DIR__ . './../../statistics.php' );

use PHPUnit\Framework\TestCase;

// phpcs:disable PSR1.Files.SideEffects

/**
 *
 * Test counter functionality.
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
final class A00StatsCountersTest extends TestCase {
	/**
	 * @covers ::vipgoci_counter_report
	 */
	function testCounterReport1() {
		$this->assertSame(
			vipgoci_counter_report(
				'illegalaction',
				'mycounter1',
				100
			),
			false
		);

		$this->assertSame(
			array(),
			vipgoci_counter_report(
				VIPGOCI_COUNTERS_DUMP,
				null,
				null
			)
		);
	}

	/**
	 * @covers ::vipgoci_counter_report
	 */
	function testCounterReport2() {
		$this->assertSame(
			true,
			vipgoci_counter_report(
				VIPGOCI_COUNTERS_DO,
				'mycounter2',
				100
			)
		);

		$this->assertSame(
			true,
			vipgoci_counter_report(
				VIPGOCI_COUNTERS_DO,
				'mycounter2',
				1
			)
		);

		$this->assertSame(
			array(
				'mycounter2' => 101,
			),
			vipgoci_counter_report(
				VIPGOCI_COUNTERS_DUMP
			)
		);
	}


	/*
	 * @covers ::vipgoci_counter_update_with_issues_found
	 */
	function testCounterUpdateWithIssuesFound1() {
		$results = array(
			'stats' => array(
				'unique_issue' => array(
					120 => array(
						'errors' => 1,
						'warnings' => 1,
					),

					121 => array(
						'errors' => 2,
						'warnings' => 1,
					),
				)
			)
		);


		vipgoci_counter_update_with_issues_found(
			$results
		);

		$report = vipgoci_counter_report(
			VIPGOCI_COUNTERS_DUMP
		);


		unset( $report['mycounter2'] );

	
		$this->assertSame(
			array(
				'github_pr_unique_issue_issues' => 3,
			),
			$report
		);	
	}
}


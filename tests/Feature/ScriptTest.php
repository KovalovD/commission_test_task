<?php

declare(strict_types=1);

namespace App\CommissionTask\Tests\Feature;

use App\CommissionTask\Models\Operation;
use App\CommissionTask\Services\CommissionService;
use App\CommissionTask\Services\ExchangeRatesApi;
use Exception;
use PHPUnit\Framework\TestCase;

class ScriptTest extends TestCase
{
	private CommissionService $commissionService;

	public function setUp(): void
	{
		$this->commissionService = new CommissionService();

		ExchangeRatesApi::setCurrencies([
			'USD' => 1.1497,
			'EUR' => 1,
			'JPY' => 129.53,
		]);
	}

	/**
	 * @throws Exception
	 */
	public function test_process(): void
	{
		$expectedFees = [
			0.60,
			3.00,
			0.00,
			0.06,
			1.50,
			0,
			0.70,
			0.30,
			0.30,
			3.00,
			0.00,
			0.00,
			8612,
		];

		$operations = $this->commissionService->calculateFees(__DIR__.'/../../src/input.csv');

		/** @var Operation $operation */
		foreach ($operations as $key => $operation) {
			$this->assertEquals($expectedFees[$key], $operation->getFee()->getAmount());
		}
	}
}

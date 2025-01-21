<?php

namespace Tests\Unit;

use App\Exceptions\CalculatorException;
use App\Services\CalculatorService;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    private ?CalculatorService $calculator = null;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->calculator = new CalculatorService;
    }

    /**
     * A basic test example.
     */
    public function test_calculator_has_operators(): void
    {
        $this->assertGreaterThanOrEqual(1, count($this->calculator->getValidOperators()));
    }

    /**
     * A basic test example.
     */
    public function test_operator_exception(): void
    {
        $this->expectException(CalculatorException::class);
        $this->calculator->calculate('123', '456', 'zzz');
    }

    /**
     * A basic test example.
     */
    public function test_operand_exception(): void
    {
        $this->expectException(CalculatorException::class);
        $this->calculator->calculate('asd', '456', 'add');
    }

    /**
     * A basic test example.
     */
    public function test_division_exception(): void
    {
        $this->expectException(CalculatorException::class);
        $this->calculator->calculate('25', '0', 'divide');
    }

    /**
     * A basic test example.
     */
    public function test_calculations(): void
    {
        $this->assertEquals($this->calculator->calculate('25', '5', 'add'), 30);
        $this->assertEquals($this->calculator->calculate('25', '5', 'subtract'), 20);
        $this->assertEquals($this->calculator->calculate('25', '5', 'multiply'), 125);
        $this->assertEquals($this->calculator->calculate('25', '5', 'divide'), 5);

        $this->assertEquals($this->calculator->calculate('7.5', '1.25', 'add'), 8.75);
        $this->assertEquals($this->calculator->calculate('7.5', '1.25', 'subtract'), 6.25);
        $this->assertEquals($this->calculator->calculate('7.5', '4', 'multiply'), 30);
        $this->assertEquals($this->calculator->calculate('7.5', '0.5', 'divide'), 15);
    }
}

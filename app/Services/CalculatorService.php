<?php

namespace App\Services;

use App\Exceptions\CalculatorException;
use App\Interfaces\CalculatorInterface;

final class CalculatorService implements CalculatorInterface
{
    /**
     * @var array Property to hold the operators used by class methods
     */
    private ?array $operators = null;

    /**
     * The CalculatorService constructor defines the valid operators
     *
     * @return void
     */
    public function __construct()
    {
        $this->operators = [
            'add' => '+ Plus',
            'subtract' => '- Minus',
            'multiply' => 'x Multiply',
            'divide' => '&divide; Divide',
        ];
    }

    /**
     * Returns the array list of valid operators
     */
    public function getValidOperators(): array
    {
        return $this->operators;
    }

    /**
     * The public calculate is the main entry point for the service
     *
     * @param  string  $operandA  Operand to the left of the operator.
     * @param  string  $operandB  Operand to the right of the operator.
     * @param  string  $operator  The operator to be used.
     */
    public function calculate(string $operandA, string $operandB, string $operator): float
    {
        $this->validateInput($operandA, $operandB, $operator);

        return $this->calculateResult($operandA, $operandB, $operator);
    }

    /**
     * The validateInput tests that the incoming values for the calculation are valid
     *
     * @param  string  $operandA  Operand to the left of the operator.
     * @param  string  $operandB  Operand to the right of the operator.
     * @param  string  $operator  The operator to be used.
     *
     * @throws CalculatorException if a problem with the parameters is found
     */
    private function validateInput(string $operandA, string $operandB, string $operator): void
    {
        if (! is_numeric($operandA) || ! is_numeric($operandB)) {
            throw CalculatorException::operandException();
        }

        if (empty($operator) || ! isset($this->operators[$operator])) {
            throw CalculatorException::operatorException();
        }

        if (! method_exists($this, $operator.'Handler')) {
            throw CalculatorException::handlerException();
        }

        if ($operator == 'divide' && $operandB == 0) {
            throw CalculatorException::divisionException();
        }
    }

    /**
     * The calculateResult performs the calculation once parameter validation in complete
     *
     * @param  string  $operandA  Operand to the left of the operator.
     * @param  string  $operandB  Operand to the right of the operator.
     * @param  string  $operator  The operator to be used.
     */
    private function calculateResult(string $operandA, string $operandB, string $operator): float
    {
        return $this->{$operator.'Handler'}((float) $operandA, (float) $operandB);
    }

    /**
     * The addHandler performs addition calculations
     *
     * @param  float  $operandA  Operand to the left of the operator.
     * @param  float  $operandB  Operand to the right of the operator.
     */
    private function addHandler(float $operandA, float $operandB): float
    {
        return $operandA + $operandB;
    }

    /**
     * The subtractHandler performs subtraction calculations
     *
     * @param  float  $operandA  Operand to the left of the operator.
     * @param  float  $operandB  Operand to the right of the operator.
     */
    private function subtractHandler(float $operandA, float $operandB): float
    {
        return $operandA - $operandB;
    }

    /**
     * The multiplyHandler performs multiplication calculations
     *
     * @param  float  $operandA  Operand to the left of the operator.
     * @param  float  $operandB  Operand to the right of the operator.
     */
    private function multiplyHandler(float $operandA, float $operandB): float
    {
        return $operandA * $operandB;
    }

    /**
     * The divideHandler performs division calculations
     *
     * @param  float  $operandA  Operand to the left of the operator.
     * @param  float  $operandB  Operand to the right of the operator.
     */
    private function divideHandler(float $operandA, float $operandB): float
    {
        return $operandA / $operandB;
    }
}

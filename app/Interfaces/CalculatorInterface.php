<?php

namespace App\Interfaces;

interface CalculatorInterface
{
    public function getValidOperators(): array;

    public function calculate(string $operandA, string $operandB, string $operator): float;
}

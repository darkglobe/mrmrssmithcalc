<?php

namespace App\Exceptions;

use Exception;

class CalculatorException extends Exception
{
    public static function operandException(): CalculatorException
    {
        return new self('Non-Numeric or Missing Operand');
    }

    public static function operatorException(): CalculatorException
    {
        return new self('Invalid or Missing Operator');
    }

    public static function handlerException(): CalculatorException
    {
        return new self('Unhandled Operator');
    }

    public static function divisionException(): CalculatorException
    {
        return new self('Division by Zero');
    }
}

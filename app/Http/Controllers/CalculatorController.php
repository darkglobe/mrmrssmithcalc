<?php

namespace App\Http\Controllers;

use App\Services\CalculatorService;
use Illuminate\Http\Request;

class CalculatorController extends Controller
{
    private CalculatorService $calculator;

    private array $validOperators;

    public function __construct(CalculatorService $calculator)
    {
        $this->calculator = $calculator;
        $this->validOperators = $calculator->getValidOperators();
    }

    public function calculator()
    {
        return view('calculator', ['operators' => $this->validOperators]);
    }

    public function calculate(Request $request)
    {
        $validated = $request->validate([
            'operandA' => 'required|numeric',
            'operator' => 'in:'.implode(',', array_keys($this->validOperators)),
            'operandB' => 'required|numeric',
        ]);

        $result = '';
        $exception = null;

        try {
            $result = $this->calculator->calculate($request->input('operandA'), $request->input('operandB'), $request->input('operator'));
        } catch (\Exception $e) {
            $exception = $e;
        }

        return view('calculator', ['operators' => $this->validOperators, 'result' => $result, 'exception' => $exception]);
    }
}

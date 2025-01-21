<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalculatorControllerTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_calculator_view(): void
    {
        $response = $this->get('/calculator');

        $response->assertStatus(200);
        $response->assertSee('Basic Calculator');
    }

    public function test_calculate_view(): void
    {
        $response = $this->get('/calculate');

        $response->assertStatus(200);
        $response->assertSee('Basic Calculator');
    }

    public function test_calculate_post(): void
    {
        $response = $this->post('/calculate', [
            '_token' => csrf_token(),
            'operandA' => '24',
            'operandB' => '18',
            'operator' => 'add',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Basic Calculator');
        $response->assertSee('Result: 42');
    }

    public function test_calculate_post_exception(): void
    {
        $response = $this->post('/calculate', [
            '_token' => csrf_token(),
            'operandA' => '24',
            'operandB' => '0',
            'operator' => 'divide',
        ]);

        $response->assertStatus(200);
        $response->assertSee('Exception');
    }

    public function test_calculate_post_validation(): void
    {
        $response = $this->post('/calculate', [
            '_token' => csrf_token(),
            'operandA' => 'abc',
            'operandB' => '123',
            'operator' => 'add',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('operandA', 'The operand a field must be a number.');

        $response = $this->post('/calculate', [
            '_token' => csrf_token(),
            'operandA' => '123',
            'operandB' => '',
            'operator' => 'add',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('operandB', 'The operand b field is required.');

        $response = $this->post('/calculate', [
            '_token' => csrf_token(),
            'operandA' => '123',
            'operandB' => '456',
            'operator' => '',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('operator', 'The selected operator is invalid.');
    }
}

<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\MultiplicationTableController;
use Tests\TestCase;

class MultiplicationTableControllerTest extends TestCase
{
    public function test_can_create_an_instance(): void
    {
        $multiplicationTableController = new MultiplicationTableController();
        $this->assertInstanceOf(MultiplicationTableController::class, $multiplicationTableController);
    }

    public function test_instance_has_invoke_method(): void
    {
        $multiplicationTableController = new MultiplicationTableController();
        $this->assertTrue(method_exists($multiplicationTableController, '__invoke'));
    }

    public function test_instance_has_private_method(): void
    {
        $multiplicationTableController = new MultiplicationTableController();
        $this->assertTrue(method_exists($multiplicationTableController, 'getTableService'));
    }

    public function test_get_table_without_parameter_error(): void
    {
        $response = $this->get('table');
        $exception = $response->exception->getMessage();
        $response->assertStatus(302);
        $this->assertSame('The size field is required.', $exception);
    }

    public function test_get_table_with_bad_parameter_type_error(): void
    {
        $response = $this->get('table?size=' . 'string');
        $exception = $response->exception->getMessage();
        $response->assertStatus(302);
        $this->assertSame('The size field must be an integer.', $exception);
    }

    public function test_get_table_with_out_of_range_parameter_error(): void
    {
        $response = $this->get('table?size=' . 101);
        $exception = $response->exception->getMessage();
        $response->assertStatus(302);
        $this->assertSame('The size field must be between 1 and 100.', $exception);
    }

    public function test_get_table_with_valid_parameter(): void
    {
        $response = $this->get('table?size=' . 10);
        $response->assertStatus(200);
    }

    public function test_get_expected_response_value(): void
    {
        $expectedResponseValue = '{"1":{"1":1,"2":2,"3":3,"4":4,"5":5},"2":{"1":2,"2":4,"3":6,"4":8,"5":10},"3":{"1":3,"2":6,"3":9,"4":12,"5":15},"4":{"1":4,"2":8,"3":12,"4":16,"5":20},"5":{"1":5,"2":10,"3":15,"4":20,"5":25}}';
        $response = $this->get('table?size=' . 5);
        $response->assertStatus(200);
        $response->assertContent($expectedResponseValue);
    }
}

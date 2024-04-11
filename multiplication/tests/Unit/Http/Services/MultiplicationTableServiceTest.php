<?php

namespace Tests\Unit\Http\Services;

use App\Http\Services\MultiplicationTableService;
use Illuminate\Support\Facades\Cache;
use Mockery;
use Tests\TestCase;

class MultiplicationTableServiceTest extends TestCase
{
    public function test_is_get_instance_return_correct_instance()
    {
        $this->assertTrue(MultiplicationTableService::getInstance() instanceof MultiplicationTableService);
    }

    public function test_is_singleton()
    {
        $service1 = MultiplicationTableService::getInstance();
        $service2 = MultiplicationTableService::getInstance();
        $this->assertSame($service1, $service2);
    }

    public function test_is_get_table_method_work_correctly()
    {
        $expectedResponse = MultiplicationTableService::getInstance()->getTable(5);
        $service = Mockery::mock(MultiplicationTableService::class);
        $service->shouldReceive('getTable')
            ->once()
            ->with(5)
            ->andReturn($expectedResponse);
        $currentResponse = $service->getTable(5);

        $this->assertEquals($expectedResponse, $currentResponse);
    }

    public function test_is_get_table_method_generated_expected_table()
    {
        $size = 5;
        $expectedTable = [
            1 => [
                1 => 1,
                2 => 2,
                3 => 3,
                4 => 4,
                5 => 5,
            ],
            2 => [
                1 => 2,
                2 => 4,
                3 => 6,
                4 => 8,
                5 => 10,
            ],
            3 => [
                1 => 3,
                2 => 6,
                3 => 9,
                4 => 12,
                5 => 15,
            ],
            4 => [
                1 => 4,
                2 => 8,
                3 => 12,
                4 => 16,
                5 => 20,
            ],
            5 => [
                1 => 5,
                2 => 10,
                3 => 15,
                4 => 20,
                5 => 25,
            ]
        ];

        $service = MultiplicationTableService::getInstance();
        $response = $service->getTable($size);
        $this->assertSame($expectedTable, json_decode($response->getContent(), true));
    }

    public function test_instance_has_private_methods(): void
    {
        $service = MultiplicationTableService::getInstance();
        $this->assertTrue(method_exists($service, 'generateTable'));
        $this->assertTrue(method_exists($service, 'getCachedOrGenerateTable'));
    }

    public function test_new_key_after_getting_table_exist_in_cash(): void
    {
        $service = MultiplicationTableService::getInstance();
        $size = 5;
        $this->assertFalse(Cache::has('multiplication_table_with_size_' . $size));
        $service->getTable(5);
        $this->assertTrue(Cache::has('multiplication_table_with_size_' . $size));
    }
}

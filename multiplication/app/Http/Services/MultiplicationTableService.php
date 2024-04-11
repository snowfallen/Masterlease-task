<?php

namespace App\Http\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class MultiplicationTableService
{
    private const CACHE_DURATION = 3600;
    private const CACHE_PREFIX = 'multiplication_table_with_size_';
    private static ?self $instance = null;

    private function __construct(){}

    public static function getInstance(): self
    {
        return self::$instance ?? self::$instance = new self();
    }

    public function getTable(int $size): JsonResponse
    {
        return response()->json($this->getCachedOrGenerateTable($size));
    }

    private function getCachedOrGenerateTable(int $size): array
    {
        $cacheKey = self::CACHE_PREFIX . $size;

        return Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($size) {
            return $this->generateTable($size);
        });
    }

    private function generateTable(int $size): array
    {
        $table = [];
        for ($i = 1; $i <= $size; $i++) {
            for ($j = 1; $j <= $size; $j++) {
                $table[$i][$j] = $i * $j;
            }
        }

        return $table;
    }
}

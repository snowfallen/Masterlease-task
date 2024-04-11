<?php

namespace App\Http\Controllers;

use App\Http\Requests\MultiplicationTableRequest;
use App\Http\Services\MultiplicationTableService;
use Illuminate\Http\JsonResponse;

class MultiplicationTableController extends Controller
{
    public function __invoke(MultiplicationTableRequest $multiplicationTableRequest): JsonResponse
    {
        return $this->getTableService()->getTable($multiplicationTableRequest->validated()['size']);
    }

    private function getTableService(): MultiplicationTableService
    {
        return MultiplicationTableService::getInstance();
    }
}

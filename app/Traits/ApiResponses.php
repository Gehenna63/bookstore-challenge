<?php

namespace App\Traits;

trait ApiResponses {
    
    protected function ok($data) {
        return $this->success($data, 200);
    }

    protected function success($data, $statusCode = 200) {
        return response()->json([
            'data' => $data,
        ], $statusCode);
    }

    protected function error($data, $statusCode) {
        return response()->json([
            'data' => $data,
        ], $statusCode);
    }
}
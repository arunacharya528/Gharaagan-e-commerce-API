<?php

use Illuminate\Http\JsonResponse;

trait ApiHelper
{
    protected function isSuperAdmin($user): bool
    {
        if (!empty($user)) {
            return $this->tokenCan('superadmin');
        } else {
            return false;
        }
    }

    protected function isAdmin($user): bool
    {
        if (!empty($user)) {
            return $this->tokenCan('admin');
        } else {
            return false;
        }
    }

    protected function isClient($user): bool
    {
        if (!empty($user)) {
            return $this->tokenCan('client');
        } else {
            return false;
        }
    }

    protected function onSuccess($data, string $message = '', int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    protected function onError(int $code, string $message = ''): JsonResponse
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
        ], $code);
    }
}

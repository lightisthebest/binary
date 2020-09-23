<?php


namespace App\Http\Controllers\Traits;

use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Throwable;

trait ResponseTrait
{
    public static $stack = 'api';

    /**
     * @param null $message
     * @return JsonResponse
     */
    public static function apiErrorResponse($message = null): JsonResponse
    {
        $response = [
            'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
        ];
        if (is_null($message) || !env('APP_DEBUG')) $message = 'Something went wrong.';
        if (is_string($message)) {
            $message .= ' ' . 'Please, try again or contact support team.';
            $response = array_merge($response, [
                'message' => $message
            ]);
        } elseif (is_array($message)) {
            $response = array_merge($response, $message);
        }
        return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
    }


    /**
     * @param string|null $message
     * @return JsonResponse
     */
    public static function apiNotFoundResponse(?string $message = null): JsonResponse
    {
        if (is_null($message)) $message = 'Data is not found.';
        return response()->json([
            'status' => Response::HTTP_NOT_FOUND,
            'message' => $message
        ], Response::HTTP_NOT_FOUND);
    }

    /**
     * @param array $errors
     * @param null $message
     * @return JsonResponse
     */
    public static function sendValidationErrors($errors = [], $message = null): JsonResponse
    {
        if (empty($message)) $message = 'The given data was invalid.';
        return response()->json([
            'message' => $message,
            'errors' => $errors,
        ], 422);
    }

    /**
     * @param Throwable $e
     * @return JsonResponse
     */
    public static function handleException(Throwable $e): JsonResponse
    {
        if ($e instanceof NotFoundException) {
            return self::apiNotFoundResponse($e->getMessage());
        }
        if ($e instanceof ValidationException) {
            return self::sendValidationErrors($e->getErrors(), $e->getMessage());
        }
        $arr = [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ];
        Log::stack(Arr::wrap(self::$stack))->info('API failed', array_merge($arr, ['trace' => $e->getTraceAsString()]));
        return self::apiErrorResponse($arr);
    }
}

<?php


namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait HttpResponse
{
    /**
     * @param array $data
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    public function sendSuccess(array $data, string $message = 'Data Fetched Successfully', int $status = Response::HTTP_OK): JsonResponse
    {
        $result = [
            'response' => $data,
            'message' => __($message),
        ];
        return response()->json($result, $status);
    }

    /**
     * @param string $message
     * @param int $status
     * @param array|null $data
     * @return JsonResponse
     */
    public function sendError(string $message = 'Data Fetch Failed', int $status = Response::HTTP_BAD_REQUEST, ?array $data = []): JsonResponse
    {
        $result =  [
            'message' => __($message),
            'response' => $data,
        ];
        return response()->json($result, $status);
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    public function sendValidationError(array $data = []): JsonResponse
    {
        $result = [
            'message' => __('Data Validation Error'),
            'errors' => $data,
        ];
        return response()->json($result, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}

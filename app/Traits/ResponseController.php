<?php


namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseController
{

    /**
     * @var int
     */
    public int $code = 200;

    /**
     * @var string
     */
    public string $status = 'error';

    /**
     * @var mixed|null
     */
    public mixed $text = null;

    /**
     * @var mixed|null
     */
    public mixed $json = null;

    /**
     * @param bool $status
     * @return JsonResponse
     */
    public function responseJsonApi(): JsonResponse
    {
        $response = [
            'data' => [
                'status' => $this->status,
                'text' => $this->text,
                'json' => $this->json
            ],
            'code' => $this->code
        ];

        return response()->json($response['data'], $response['code']);
    }
}

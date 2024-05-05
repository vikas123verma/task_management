<?php
namespace App\Utilities;

use Illuminate\Http\Response;

class APIResponse
{
    public int $statusCode = Response::HTTP_OK;
    public array $message = [];
    public $data = null;

    public function forbidden()
    {
        $this->statusCode = Response::HTTP_FORBIDDEN;
        $this->message = ['error' => 'You don\'t have required permission.'];
    }

    public function getResponse()
    {
        $content = $this->message;
        if($this->data) {
            $content['data'] = $this->data;
        }
        return response()->json($content, $this->statusCode);
    }
}

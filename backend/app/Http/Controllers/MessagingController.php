<?php

namespace App\Http\Controllers;

use App\Services\RabbitMQService;
use Illuminate\Http\Request;

class MessagingController extends Controller
{
    // add a constructor with dependecy to RabbitMQ service

    public function __construct(protected RabbitMQService $rabbitMQService)
    {

    }

    public function publishMessage(Request $request)
    {
        $message = $request->input('message');

        $this->rabbitMQService->publish($message);

        return response()->json([
            'message' => 'Successfully sent a message!',
        ]);
    }
}

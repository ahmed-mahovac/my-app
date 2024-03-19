<?php

namespace App\Services;

use App\Events\PusherEvent;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQService
{

    protected $connection;
    protected $channel;

    public function __construct(){
        // queue definition with rules
        $this->connection = new AMQPStreamConnection(env('MQ_HOST'), env('MQ_PORT'), env('MQ_USER'), env('MQ_PASS'), env('MQ_VHOST'));
        $this->channel = $this->connection->channel();
        $this->channel->exchange_declare('laravel_exchange', 'direct', false, false, false);
        $this->channel->queue_declare('laravel_queue', false, false, false, false);
        $this->channel->queue_bind('laravel_queue', 'laravel_exchange', 'test_key');
    }

    public function __destruct(){
        $this->channel->close();
        $this->connection->close();
    }

    public function publish($message)
    {
        // sending message
        $msg = new AMQPMessage($message);
        $this->channel->basic_publish($msg, 'laravel_exchange', 'test_key');
        echo "Sent $message to laravel_exchange / laravel_queue.\n";
        
        // so the echo output not included in the response
        ob_clean();
        
    }

    public function consume()
    {
        $connection = new AMQPStreamConnection(env('MQ_HOST'), env('MQ_PORT'), env('MQ_USER'), env('MQ_PASS'), env('MQ_VHOST'));
        $channel = $connection->channel();
        $channel->queue_declare('laravel_queue', false, false, false, false);

        $messages = [];

        $callback = function ($msg) use($channel, $messages) {
            echo ' [x] Received ', $msg->body, "\n";
            array_push($messages, json_decode($msg->body, true));
            $channel->basic_ack($msg->delivery_info['delivery_tag']);
            event(new PusherEvent($msg));
        };

        

        $channel->basic_consume('laravel_queue', '', false, false, false, false, $callback);


        echo 'Waiting for new message on laravel_queue', " \n";

        // constantly wait for new messages from queue
        while (true) {
            echo 'loop';
            // seconds before a timeout due to inactivity
            $channel->wait(null,false,10);
        }

    }
}
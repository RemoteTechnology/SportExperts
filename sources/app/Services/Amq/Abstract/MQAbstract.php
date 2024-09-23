<?php

namespace App\Services\Amq\Abstract;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Channel\AMQPChannel;
use phpDocumentor\Reflection\User\Callable_;

abstract class MQAbstract
{
    /**
     * @var AMQPStreamConnection
     */
    private AMQPStreamConnection $connection;

    /**
     * @var  AMQPChannel
     */
    private AMQPChannel $channel;

    /**
     * @var Callable_|mixed
     */
    public Callable_ $callback_queue;
    private mixed $response;
    private mixed $corr_id;

    public function __construct(AMQPStreamConnection $mqConnection)
    {
        $this->connection = new AMQPStreamConnection(
            '172.24.0.7',
            $_ENV['RABBITMQ_PORT'],
            $_ENV['RABBITMQ_DEFAULT_USER'],
            $_ENV['RABBITMQ_DEFAULT_PASS']
        );
        $this->channel = $this->connection->channel();
        list($this->callback_queue, ,) = $this->channel->queue_declare(
            "",
            false,
            false,
            true,
            false
        );

        $this->channel->basic_consume(
            $this->callback_queue,
            '',
            false,
            true,
            false,
            false,
            array(
                $this,
                'onResponse'
            )
        );
    }

    /**
     * @param mixed $rep
     * @return void
     */
    public function onResponse(mixed $rep): void
    {
        if ($rep->get('correlation_id') == $this->corr_id) {
            $this->response = $rep->body;
        }
    }
    /**
     * @param mixed $n
     * @return int
     */
    abstract public function call(mixed $n): int;
}

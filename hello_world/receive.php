<?php

require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// 打开连接
$connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'admin');

// 打开管道
$channel = $connection->channel();

// 生命队列
$channel->queue_declare('hello', false, false, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg) {
    echo ' [x] Received ', $msg->body, "\n";
};

// 使用了命名为空字符串("")默认的交换机。
$channel->basic_consume('hello', '', false, true, false, false, $callback);
while ($channel->is_consuming()) {
    $channel->wait();
}
$channel->close();
$connection->close();
?>
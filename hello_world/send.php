<?php

require_once __DIR__ . '/../vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

// 创建服务器连接
$connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'admin');

// 创建通道
$channel = $connection->channel();

// 声明队列
$channel->queue_declare('hello', false, false, false, false);

$msg = new AMQPMessage('Hello World!');

// 使用了命名为空字符串("")默认的交换机。
$channel->basic_publish($msg, '', 'hello');

echo "[x] Sent 'Hello World!'\n";

// 关闭通道和连接

$channel->close();
$connection->close();




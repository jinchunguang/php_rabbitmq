<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'admin');
$channel = $connection->channel();

// 直连交换机（direct）, 主题交换机（topic）, （头交换机）headers和 扇型交换机（fanout）
// 扇型交换机（fanout）很简单，你可能从名字上就能猜测出来，它把消息发送给它所知道的所有队列。
// 交换机：logs
// 交换机类型:扇型交换机 fanout
$channel->exchange_declare('logs', 'fanout', false, false, false);

$data = implode(' ', array_slice($argv, 1));
if (empty($data)) {
    $data = "info: Hello World!";
}

$msg = new AMQPMessage($data);
// 交换机：logs
$channel->basic_publish($msg, 'logs');

echo ' [x] Sent ', $data, "\n";
$channel->close();
$connection->close();
?>
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: thesyncim
 * Date: 7/16/12
 * Time: 1:05 PM
 * To change this template use File | Settings | File Templates.
 */
namespace app\extensions\command;

use lithium\core\Libraries;
use Ratchet\Session\SessionProvider;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use lithium\storage\Session;
use Symfony\Component\HttpFoundation\Session\Storage\Handler;

ini_set('session.name', 'PHPSESSID');
ini_set('session.save_handler', 'memcached');
ini_set('session.save_path', 'localhost:11211');

/**
 * chat.php
 * Send any incoming messages to all connected clients (except sender)
 */
class Chat implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);

        session_id($conn->WebSocket->request->getCookie(ini_get('session.name')));
        session_start();
        $conn->send(($conn->WebSocket->request->getCookie(ini_get('session.name')));
    }

    public function onMessage(ConnectionInterface $from, $msg) {

        foreach ($this->clients as $client) {
            if ($from != $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }
}

class Websocket extends \lithium\console\Command {

    public function start($adress = '127.0.0.1', $port = 8000, $ssl = false) {
        $memcache = new \Memcache;
        $memcache->connect('localhost', 11211);
        $chat = new Chat();

        $handler = new Handler\MemcacheSessionHandler($memcache, array('prefix' => ''));

        $session = new SessionProvider($chat, $handler, array(
            'adapter' => 'Php', 'session.name' => 'PHPSESSID',
            'session.save_handler' => 'memcached',
            'session.save_path' => 'localhost:11211'
        ));

        // Run the server application through the WebSocket protocol on port 8000
        $server = IoServer::factory(new WsServer($session), 8000);
        $server->run();
    }

    public function run() {
    }
}
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: thesyncim
 * Date: 7/16/12
 * Time: 1:05 PM
 * To change this template use File | Settings | File Templates.
 */
namespace app\extensions\command;
use \WebSocket\Server;
use lithium\core\Libraries;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use lithium\storage\Session;

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
        var_dump(Session::read('user'));
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

        // Run the server application through the WebSocket protocol on port 8000
        $server = IoServer::factory(new WsServer(new Chat), 8000);
        $server->run();
    }

    public function run() {
    }
}
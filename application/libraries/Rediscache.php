<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * CodeIgniter Redis
 *
 * A CodeIgniter library to interact with Redis
 *
 * @package  CodeIgniter
 * @category Libraries
 * @author   Alisson Acioli
 * @version  v1.0
 * @link     https://github.com/joelcox/codeigniter-redis
 * @link     http://joelcox.nl
 * @license  http://www.opensource.org/licenses/mit-license.html
 */
class Rediscache
{

    /**
     * CI
     *
     * CodeIgniter instance
     *
     * @var object
     */
    private $_ci;

    /**
     * Connection
     *
     * Socket handle to the Redis server
     *
     * @var handle
     */
    private $_connection;

    /**
     * Debug
     *
     * Whether we're in debug mode
     *
     * @var bool
     */
    public $debug = false;

    /**
     * CRLF
     *
     * User to delimiter arguments in the Redis unified request protocol
  *
     * @var string
     */
    const CRLF = "\r\n";

    /**
     * Constructor
     */
    public function __construct($instance = 'redis_default')
    {

        log_message('debug', 'Redis Class Initialized');

        $this->_ci = get_instance();

        $this->_ci->config->load('redis');

        $config = $this->_ci->config->item($instance);

        // Create your redis client
        $this->_connection = new Predis\Client($config, ['exceptions' => true]);

        // Do something you want:
        // Set the expiration for 7 seconds
        // $redis->set("tm", "I have data for 200.");
        // $redis->expire("tm", 200);
        // $ttl = $redis->ttl("tm");

    }


    /**
     * Call
     *
     * Catches all undefined methods
     *
     * @param  string    method that was called
     * @param  mixed    arguments that were passed
     * @return mixed
     */
    public function __call($method, $arguments)
    {

        return $this->_connection->executeCommand(
            $this->_connection->createCommand($method, $arguments)
        );
    }

    public function select($database = 0)
    {

        $this->_connection->select($database);
    }

    public function set($key, $value)
    {

        return $this->_connection->set($key, $value);
    }

    public function get($key)
    {

        return $this->_connection->get($key);
    }

    public function isConnected()
    {

        return $this->_connection->isConnected();
    }

    public function getConnection()
    {
        return $this->_connection;
    }


    /**
     * Command
     *
     * Generic command function, just like redis-cli
     *
     * @param  string    full command as a string
     * @return mixed
     */
    public function command($command)
    {
        if ($this->debug === true) {
            log_message('debug', 'Command debug: ' . $command);
        }

        return $this->_connection->executeRaw($command);
    }

    /**
     * Clear Socket
     *
     * Empty the socket buffer of theconnection so data does not bleed over
     * to the next message.
     *
     * @return NULL
     */
    public function turnoff()
    {
        // Read one character at a time
        $this->_connection->disconnect();
        return null;
    }

    /**
     * Debug
     *
     * Set debug mode
     *
     * @param  bool     set the debug mode on or off
     * @return void
     */
    public function debug($bool)
    {
        $this->debug = (bool) $bool;
    }

    public function __destruct()
    {
        $this->_connection->disconnect();
    }
}

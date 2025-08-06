<?php
/**
 * PDO Connection to Sakila Database
 * This file establishes a connection to the Sakila database using a class-based approach
 */

// Include database configuration
require_once 'config.inc.php';

// Make sure $db_config is available
if (!isset($db_config) || !is_array($db_config)) {
    die('Database configuration is missing or invalid');
}

class Database {
    // Database configuration
    private $host;
    private $port;
    private $dbname;
    private $username;
    private $password;
    private $charset;
    private $pdo;
    
    // PDO options
    private $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    
    /**
     * Constructor - establishes database connection
     * 
     * @param string $host The database host
     * @param int $port The database port
     * @param string $dbname The database name
     * @param string $username The database username
     * @param string $password The database password
     * @param string $charset The database charset
     */
    public function __construct($host, $port, $dbname, $username, $password, $charset = 'utf8mb4') {
        $this->host = $host;
        $this->port = $port;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
        $this->charset = $charset;
        $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->dbname};charset={$this->charset}";
        
        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, $this->options);
            // Connection successful
        } catch (PDOException $e) {
            // Connection failed
            die("Connection failed: " . $e->getMessage());
        }
    }
    
    /**
     * Get the PDO connection instance
     * 
     * @return PDO The PDO connection instance
     */
    public function getConnection() {
        return $this->pdo;
    }
}

// Create database instance with connection parameters from config file
$database = new Database(
    $db_config['host'],
    $db_config['port'],
    $db_config['dbname'],
    $db_config['username'],
    $db_config['password'],
    $db_config['charset']
);

// Return the PDO connection
return $database->getConnection();
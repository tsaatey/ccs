<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DatabaseEntities
 *
 * @author ESTHER
 */
class DatabaseEntities {

    private $host;
    private $username;
    private $password;
    private $sqlFilePath;

    public function __construct($host, $username, $password) {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->sqlFilePath = "../files/database.sql";
    }

    public function connectToMysqlServer() {
        $hostString = "mysql:host=" . $this->host . ";charset=utf8";
        $errorMode = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
        $connection = new PDO($hostString, $this->username, $this->password, $errorMode);
        return $connection;
    }

    public function isDatabaseExists($host, $username, $password) {
        try {
            $connect = new DatabaseEntities($host, $username, $password);
            $connection = $connect->connectToMysqlServer();

            $query = $connection->prepare("SHOW DATABASES LIKE 'ccs'");
            $query->execute();
            if ($query->rowCount() != 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            
        }
    }

    public function executeDummyQuery($connection) {
        try {
            $query = $connection->prepare("SELECT USER FROM mysql.user");
            $query->execute();
            if ($query->rowCount() != 0) {
                return true;
            }
        } catch (Exception $ex) {
            
        }
    }

    public function executeSQL() {
        //load file
        $commands = file_get_contents($this->sqlFilePath);

        //delete comments
        $lines = explode("\n", $commands);
        $commands = '';
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line && !$this->startsWith($line, '--')) {
                $commands .= $line . "\n";
            }
        }

        //convert to array
        $commands = explode(";", $commands);

        //run commands
        $connection = $this->connectToMysqlServer();
        foreach ($commands as $command) {
            if (trim($command)) {
                $execQuery = $connection->prepare($command);
                $execQuery->execute();
            }
        }

    }

    // Here's a startsWith function
    public function startsWith($haystack, $needle) {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }
    

}

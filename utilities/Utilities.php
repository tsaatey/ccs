<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utilities
 *
 * @author ESTHER
 */

class Utilities {

    private $filePath;
    private $hostPath;

    public function __construct() {
        $this->filePath = "../files/credentials.txt";
        $this->hostPath = "../files/host.txt";
    }

    public function getVendorUrl() {
        $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] === 433) ? 'https://' : 'http://';
        $url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        return $url;
    }

    public function saveDatabaseCredentials($host, $username, $password) {
        $credentials = fopen($this->filePath, 'w');
        fwrite($credentials, $host . '\n');
        fwrite($credentials, $username . '\n');
        fwrite($credentials, $password . '\n');
        fclose($credentials);
    }

    public function retrieveDatabaseCredentials() {
        if (!file_exists($this->filePath)) {
            return null;
        } else {
            $credentials = explode("\n", file_get_contents($this->filePath));
            return $credentials;
        }
    }

    public function deleteCredentialsFile() {
        return unlink($this->filePath);
    }

    public function saveComputername($name) {
        $hostname = fopen($this->hostPath, 'w');
        fwrite($hostname, $name);
        fclose($hostname);
    }

    public function getSavedHostName() {
        if (!file_exists($this->hostPath)) {
            return null;
        } else {
            $name = explode("\n", file_get_contents($this->hostPath));
            return $name;
        }
    }

    public function isInteger($value) {
        if (preg_match('/^[1-9][0-9]{0,20}$/', $value)) {
            return true;
        }
        return false;
    }

    public function getClientIpAddress() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }

    public function isDateValid($date) {
        if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date)) {
            return true;
        } else {
            return false;
        }
    }
    

}

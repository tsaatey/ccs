<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SendEmail
 *
 * @author ARTLIB
 */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

require_once '../vendor/autoload.php';

class SendEmail {
    
    private $receiver_address;
    private $host;
    private $sender_username;
    private $sender_password;
    private $port_number;
    private $mail_subject;
    private $mail_body;
    private $new_password;
    private $contentBody;
    
    public function __construct($receiver_address, $new_password, $mailSubject, $messageBody) {
        $this->receiver_address = $receiver_address;
        $this->new_password = $new_password;
        $this->host = 'smtp.gmail.com';
        $this->port_number = 587;
        $this->sender_username = 'ccshield2018@gmail.com';
        $this->sender_password = 'ccshield.gh';
        $this->mail_subject = $mailSubject;
        $this->mail_body = 'Dear customer, this is your new password, use it to login: '.$this->new_password;
        $this->contentBody .= '<p>'.$messageBody.' '.'<strong>'.$this->new_password.'</strong></p>';
    }
    
    public function sendPassword() {
        $mail = new PHPMailer;
        //$mail->SMTPDebug = 3;
        $mail->isSMTP();
        $mail->isHTML(true);
        $mail->Host = $this->host;
        $mail->SMTPAuth = true;
        $mail->Username = $this->sender_username;
        $mail->Password = $this->sender_password;
        $mail->SMTPSecure = 'tls';
        $mail->Port = $this->port_number;
        $mail->From = 'tsaatey15@gmail.com';
        $mail->FromName = 'CCS Admin';
        $mail->addAddress($this->receiver_address);
        $mail->Subject = $this->mail_subject;
        $mail->Body = $this->contentBody;
        $mail->AltBody = $this->mail_body;
        
        if ($mail->send()) {
            return true;
        } 
        return false;
    }

}

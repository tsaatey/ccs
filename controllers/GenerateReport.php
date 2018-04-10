<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GenerateReport
 *
 * @author ARTLIB
 */
require_once 'DatabaseConnection.php';
require_once '../utilities/Utilities.php';
require_once '../libraries/fpdf181/fpdf.php';

class GenerateReport {

    private $report_size;
    private $connection;
    private $dataFromFile;
    private $credentials;
    private $pdf;

    public function __construct($report_size) {
        $this->report_size = $report_size;
        $util = new Utilities();
        $this->dataFromFile = $util->retrieveDatabaseCredentials();
        $this->credentials = explode('\n', $this->dataFromFile[0]);
        $this->pdf = new FPDF();
        $db = new DatabaseConnection($this->credentials[0], $this->credentials[1], $this->credentials[2]);
        $this->connection = $db->ConnectDB();
    }

    public function getDailyTransactionReport() {
        try {
            $query = $this->connection->prepare("SELECT CONCAT(credit_card_holder.firstname,' ',credit_card_holder.lastname) AS 'name', "
                    . "transaction_location.country AS 'country', transaction_location.region AS 'region', "
                    . "transaction_location.city AS 'city', transaction_details.amount AS 'amount', "
                    . "transaction_details.date_time AS 'date_time' FROM transaction_location, transaction_details, credit_card_holder "
                    . "WHERE credit_card_holder.id = transaction_details.credit_card_holder_id AND "
                    . "transaction_details.id = transaction_location.transactionId AND transaction_details.date_time LIKE CONCAT('',:date_time, '%')");
            $query->execute([
                'date_time' => date('Y-m-d')
            ]);
            if ($query->rowCount() > 0) {
                $this->pdf->AddPage($this->report_size);
                $this->pdf->SetFont("Arial", "", 14);
                date_default_timezone_set("GMT");
                $this->pdf->SetFont("Arial", "", 12);
                $this->pdf->Cell(195, 10, "CreditCard Shield", 0, 1, "C");
                $this->pdf->Cell(0, 10, "Transaction Report", 0, 1, "C");
                $this->pdf->Cell(0, 10, "" . date("d/m/Y") . '  ' . date("h:i:sa"), 0, 1, "R");
                $this->pdf->Cell(0, 5, "", 0, 1);
                $this->pdf->Cell(55, 8, "Name", 1, 0, "C");
                $this->pdf->Cell(55, 8, "Country", 1, 0, "C");
                $this->pdf->Cell(55, 8, "Region", 1, 0, "C");
                $this->pdf->Cell(55, 8, "City", 1, 0, "C");
                $this->pdf->Cell(28, 8, "Amount", 1, 0, "C");
                $this->pdf->Cell(28, 8, "Date/Time", 1, 1, "C");

                while ($result = $query->fetch()) {
                    $this->pdf->Cell(55, 8, $result['name'], 1, 0, "C");
                    $this->pdf->Cell(55, 8, $result['country'], 1, 0, "C");
                    $this->pdf->Cell(55, 8, $result['region'], 1, 0, "C");
                    $this->pdf->Cell(55, 8, $result['city'], 1, 0, "C");
                    $this->pdf->Cell(28, 8, $result['amount'], 1, 0, "C");
                    $this->pdf->Cell(28, 8, $result['date_time'], 1, 1, "C");
                }
                $this->pdf->Output();
            } else {
                echo 'No records to display currently';
            }
        } catch (Exception $ex) {
            
        }
    }

    public function getSpecificTransactionReport($startDate, $endDate) {
        try {
            $query = $this->connection->prepare("SELECT CONCAT(credit_card_holder.firstname,' ',credit_card_holder.lastname) AS 'name', "
                    . "transaction_location.country AS 'country', transaction_location.region AS 'region', "
                    . "transaction_location.city AS 'city', transaction_details.amount AS 'amount', "
                    . "transaction_details.date_time AS 'date_time' FROM transaction_location, transaction_details, credit_card_holder "
                    . "WHERE credit_card_holder.id = transaction_details.credit_card_holder_id AND "
                    . "transaction_details.id = transaction_location.transactionId AND transaction_details.transaction_date BETWEEN :start_date AND :end_date");
            $query->execute([
                'start__date' => $startDate,
                'end_date' => $endDate
            ]);
            if ($query->rowCount() > 0) {
                $this->pdf->AddPage($this->report_size);
                $this->pdf->SetFont("Arial", "", 14);
                date_default_timezone_set("GMT");
                $this->pdf->SetFont("Arial", "", 12);
                $this->pdf->Cell(195, 10, "CreditCard Shield", 0, 1, "C");
                $this->pdf->Cell(0, 10, "Transaction Report", 0, 1, "C");
                $this->pdf->Cell(0, 10, "" . date("d/m/Y") . '  ' . date("h:i:sa"), 0, 1, "R");
                $this->pdf->Cell(0, 5, "", 0, 1);
                $this->pdf->Cell(55, 8, "Name", 1, 0, "C");
                $this->pdf->Cell(55, 8, "Country", 1, 0, "C");
                $this->pdf->Cell(55, 8, "Region", 1, 0, "C");
                $this->pdf->Cell(55, 8, "City", 1, 0, "C");
                $this->pdf->Cell(28, 8, "Amount", 1, 0, "C");
                $this->pdf->Cell(28, 8, "Date/Time", 1, 1, "C");

                while ($result = $query->fetch()) {
                    $this->pdf->Cell(55, 8, $result['name'], 1, 0, "C");
                    $this->pdf->Cell(55, 8, $result['country'], 1, 0, "C");
                    $this->pdf->Cell(55, 8, $result['region'], 1, 0, "C");
                    $this->pdf->Cell(55, 8, $result['city'], 1, 0, "C");
                    $this->pdf->Cell(28, 8, $result['amount'], 1, 0, "C");
                    $this->pdf->Cell(28, 8, $result['date_time'], 1, 1, "C");
                }
                $this->pdf->Output();
            } else {
                echo 'No records to display currently';
            }
        } catch (Exception $ex) {
            
        }
    }

}

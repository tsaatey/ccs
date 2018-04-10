<?php
session_start();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CrudOperation
 *
 * @author ESTHER
 */
require_once '../models/Account.php';
require_once '../models/Employee.php';
require_once '../models/CreditCardHolder.php';
require_once '../models/Secret.php';
require_once '../models/CreditCard.php';
require_once '../models/CreditCardIssuer.php';
require_once '../models/SecretQuestion.php';
require_once '../models/Transaction.php';
require_once '../models/TransactionLocation.php';
require_once '../models/SecurityCheckHistory.php';
require_once 'DatabaseConnection.php';
require_once '../utilities/Utilities.php';

class CrudOperation {

    private $connection;
    private $dataFromFile;
    private $credentials;

    public function __construct() {
        $util = new Utilities();
        $this->dataFromFile = $util->retrieveDatabaseCredentials();
        $this->credentials = explode('\n', $this->dataFromFile[0]);

        $db = new DatabaseConnection($this->credentials[0], $this->credentials[1], $this->credentials[2]);
        $this->connection = $db->ConnectDB();
    }

    public function userLogin(Account $account) {
        try {
            $query = $this->connection->prepare("SELECT firstname, roleid FROM employee WHERE email = :email");
            $query->execute(['email' => $account->getUsername()]);
            if ($query->rowCount() == 0) {
                $query = $this->connection->prepare("SELECT firstname, roleid FROM credit_card_holder WHERE email = :email");
                $query->execute(['email' => $account->getUsername()]);
                if ($query->rowCount() > 0) {

                    $_SESSION['username'] = $account->getUsername();
                    $_SESSION['card_holder_loggedin'] = 1;
                    while ($result = $query->fetch()) {
                        $_SESSION['firstname'] = $result['firstname'];
                        $_SESSION['roleId'] = $result['roleid'];
                    }
                    $query = $this->connection->prepare("SELECT username, password, roleid FROM account WHERE username = :username AND password = :password");
                    $query->execute([
                        'username' => $account->getUsername(),
                        'password' => $account->getPassword()
                    ]);
                    if ($query->rowCount() > 0) {
                        $_SESSION['email_sent'] = 0;
                        header("Location: ../views/home.php");
                        exit();
                    } else {
                        $_SESSION['forgot_password'] = 1;
                        header("Location: ../index.php?wrong_username_password=1");
                    }
                } else {
                    header("Location: ../index.php?username_password_invalid=1");
                }
            } else {
                while ($result = $query->fetch()) {
                    $_SESSION['firstname'] = $result['firstname'];
                    $_SESSION['roleId'] = $result['roleid'];
                    $_SESSION['username'] = $account->getUsername();
                }

                $query = $this->connection->prepare("SELECT username, password, roleid FROM account WHERE username = :username AND password = :password");
                $query->execute([
                    'username' => $account->getUsername(),
                    'password' => $account->getPassword()
                ]);

                if ($query->rowCount() > 0) {
                    $query = $this->connection->prepare("SELECT username FROM account_reset_history WHERE username = :username");
                    $query->execute([
                        'username' => $account->getUsername()
                    ]);
                    if ($query->rowCount() > 0) {
                        $_SESSION['account_reset'] = 1;
                    }
                    header("Location: ../views/home.php");
                    $_SESSION['last_activity'] = time();
                    exit();
                } else {
                    header("Location: ../index.php?wrong_username_password=1");
                    session_destroy();
                }
            }
        } catch (Exception $ex) {
            
        }
    }

    public function getEmployeeId() {
        $prefix = 'CCS-GHA';
        $id = '';
        try {
            $query = $this->connection->prepare("SELECT id FROM employee");
            $query->execute();
            $rows = $query->rowCount() + 1;

            if ($rows < 10) {
                $id = $prefix . '00' . $rows;
            }

            if ($rows > 9 && $rows < 100) {
                $id = $prefix . '0' . $rows;
            }

            if ($rows > 99) {
                $id = $prefix . $rows;
            }

            return $id;
        } catch (Exception $ex) {
            
        }
    }

    public function getCardHolderId() {
        $prefix = 'CCS-CH-GH';
        $id = '';
        try {
            $query = $this->connection->prepare("SELECT id FROM credit_card_holder");
            $query->execute();
            $rows = $query->rowCount() + 1;

            if ($rows < 10) {
                $id = $prefix . '00' . $rows;
            }

            if ($rows > 9 && $rows < 100) {
                $id = $prefix . '0' . $rows;
            }

            if ($rows > 99) {
                $id = $prefix . $rows;
            }

            return $id;
        } catch (Exception $ex) {
            
        }
    }

    public function insertEmployee(Employee $employee) {
        try {
            $query = $this->connection->prepare("INSERT INTO employee VALUES(:id, :firstname, :lastname, :gender, :dateOfBirth, :phone, :email, :address, :roleId)");
            $query->execute([
                'id' => $employee->getId(),
                'firstname' => $employee->getFirstname(),
                'lastname' => $employee->getLastname(),
                'gender' => $employee->getGender(),
                'dateOfBirth' => $employee->getDateOfBirth(),
                'phone' => $employee->getPhone(),
                'email' => $employee->getEmail(),
                'address' => $employee->getAddress(),
                'roleId' => $employee->getRoleId()
            ]);

            return true;
        } catch (Exception $ex) {
            
        }
    }

    public function createAccount(Account $account) {
        try {
            $query = $this->connection->prepare("INSERT INTO account(username, password, roleId) VALUES(:username, :password, :roleId)");
            $query->execute([
                'username' => $account->getUsername(),
                'password' => $account->getPassword(),
                'roleId' => $account->getRoleId()
            ]);
            return true;
        } catch (Exception $ex) {
            
        }
    }

    public function getSecretId() {
        $prefix = 'CCS-SC-GH';
        $id = '';
        try {
            $query = $this->connection->prepare("SELECT id FROM secret");
            $query->execute();
            $rows = $query->rowCount() + 1;

            if ($rows < 10) {
                $id = $prefix . '00' . $rows;
            }

            if ($rows > 9 && $rows < 100) {
                $id = $prefix . '0' . $rows;
            }

            if ($rows > 99) {
                $id = $prefix . $rows;
            }

            return $id;
        } catch (Exception $ex) {
            
        }
    }

    public function retriveUserInfo() {
        $query = $this->connection->prepare("SELECT CONCAT(firstname,' ',lastname) AS 'Employee name', "
                . "phone AS 'Phone number', email AS 'Email address', "
                . "address AS 'Residential address' FROM employee");
        $query->execute();

        if ($query->rowCount() > 0) {
            ?>
            <table class = "table table bordered" id="user_table">
                <tr>
                    <th>Name of Employee</th>
                    <th>Phone Number</th>
                    <th>Email Address</th>
                    <th>Residential Address</th>
                </tr>
                <?php
                while ($result = $query->fetch()) {
                    ?>
                    <tr>
                        <td><?php echo $result['Employee name']; ?></td>
                        <td><?php echo $result['Phone number']; ?></td>
                        <td><?php echo $result['Email address']; ?></td>
                        <td><?php echo $result['Residential address']; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php
        }
    }

    public function displayEMployeeForDeletion() {
        $query = $this->connection->prepare("SELECT id, CONCAT(firstname,' ',lastname) AS 'Employee name', "
                . "phone AS 'Phone number', email AS 'Email address', "
                . "address AS 'Residential address' FROM employee WHERE email != 'admin@ccs.gh'");
        $query->execute();

        if ($query->rowCount() > 0) {
            ?>
            <table class = "table table bordered" id="user_table">
                <tr>
                    <th>Name of Employee</th>
                    <th style="padding-left: 60px;">Phone Number</th>
                    <th style="padding-left: 50px;">Email Address</th>
                    <th style="padding-right: 160px; padding-left: 50px;">Residential Address</th>
                    <th></th>
                </tr>
            </table>
            <?php
            $counter = 1;
            while ($result = $query->fetch()) {
                ?>
                <div class="table-responsive">
                    <form class="form-horizontal delete_employee_form" role="form" name="delete_employee_form" id="delete_employee_form<?php echo $counter; ?>">
                        <table class="table table bordered" id="user_delete_table">
                            <tr>
                            <input type="hidden" id="employee_id<?php echo $counter ?>" value="<?php echo $result['id']; ?>"/>
                            <td style="padding-top: 15px;"><?php echo $result['Employee name']; ?></td>
                            <td style="padding-left: 40px; padding-top: 15px;"><?php echo $result['Phone number']; ?></td>
                            <td style="padding-left: 40px; padding-top: 15px;"><?php echo $result['Email address']; ?></td>
                            <td id="address_column" style="padding-left: 35px; padding-top: 15px;"><?php echo $result['Residential address']; ?></td>
                            <td id="button_column"><button type="button" class="btn btn-info delete confirm" onclick="displayConfirmAlert('Delete this user?', 'delete_user', '<?php echo $result['id'] ?>', '<?php echo $result['Email address'] ?>', 'You won\'t be able to revert this!', 'delete it');">Delete</button></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <?php
                $counter += 1;
            }
            ?>
            <?php
        } else {
            $_SESSION['no_records'] = 1;
        }
    }

    public function deleteEmployee(Employee $employee) {
        try {
            $query = $this->connection->prepare("DELETE FROM employee WHERE id = :id");
            $query->execute([
                'id' => $employee->getId()
            ]);
        } catch (Exception $ex) {
            
        }
    }

    public function deleteAccount(Account $account) {
        try {
            $query = $this->connection->prepare("DELETE FROM account WHERE username = :username");
            $query->execute([
                'username' => $account->getUsername()
            ]);
        } catch (Exception $ex) {
            
        }
    }

    public function displayAccountForReset() {
        $query = $this->connection->prepare("SELECT CONCAT(firstname,' ',lastname) AS 'Employee name', "
                . "email AS 'Email address', user_role.rolename AS 'status' FROM employee, user_role WHERE user_role.id = employee.roleId AND email != 'admin@ccs.gh'");
        $query->execute();

        if ($query->rowCount() > 0) {
            ?>
            <table class = "table table bordered" id="user_table">
                <tr>
                    <th>Name of Account Holder</th>
                    <th style="padding-right: 190px;">Email Address</th>
                    <th>Status</th>
                </tr>
            </table>
            <?php
            $counter = 1;
            while ($result = $query->fetch()) {
                ?>
                <div class="table-responsive">
                    <form class="form-horizontal delete_employee_form" role="form" name="dreset_account_form">
                        <table class="table table bordered" id="user_delete_table">
                            <tr>
                                <td style="padding-top: 15px;"><?php echo $result['Employee name']; ?></td>
                                <td style="padding-top: 15px; padding-right: 20px;"><?php echo $result['Email address']; ?></td>
                                <td style="padding-top: 15px; padding-right: 20px;"><?php echo $result['status']; ?></td>
                                <td id="button_column"><button type="button" class="btn btn-info delete confirm" onclick="displayConfirmAlert('Reset this account?', 'reset_account', '', '<?php echo $result['Email address'] ?>', 'Password will be reset to default', 'reset it');">Reset</button></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <?php
                $counter += 1;
            }
        } else {
            $_SESSION['no_records'] = 1;
        }
    }

    public function updateAccount(Account $account) {
        $email = $account->getUsername();
        $username = ucwords($email);
        try {
            $query = $this->connection->prepare("UPDATE account SET password = :password WHERE username = :username");
            $query->execute([
                'password' => sha1($username),
                'username' => $email
            ]);
            try {
                $query = $this->connection->prepare("INSERT INTO account_reset_history(username) VALUES(:username)");
                $query->execute([
                    'username' => $email
                ]);
                return true;
            } catch (Exception $ex) {
                
            }
        } catch (Exception $ex) {
            
        }
    }

    public function resetPassword(Account $account) {
        try {
            $query = $this->connection->prepare("UPDATE account SET password = :password WHERE username = :username");
            $query->execute([
                'password' => $account->getPassword(),
                'username' => $account->getUsername()
            ]);

            $query = $this->connection->prepare("DELETE FROM account_reset_history WHERE username = :username");
            $query->execute([
                'username' => $account->getUsername()
            ]);
            return true;
        } catch (Exception $ex) {
            
        }
    }

    public function fetchSecretQuestions() {
        $results = array();
        try {
            $query = $this->connection->prepare("SELECT * FROM secret_question");
            $query->execute();
            $counter = 0;
            if ($query->rowCount() > 0) {
                while ($res = $query->fetch()) {
                    $results[] = array('id' => $res['id'], 'question' => $res['question']);
                }
            }
            return $results;
        } catch (Exception $ex) {
            
        }
    }

    public function fetchCardIssuers() {
        $results = array();
        try {
            $query = $this->connection->prepare("SELECT * FROM credit_card_issuer");
            $query->execute();
            if ($query->rowCount() > 0) {
                while ($res = $query->fetch()) {
                    $results[] = array('id' => $res['id'], 'company' => $res['company']);
                }
            }
            return $results;
        } catch (Exception $ex) {
            
        }
    }

    public function registerCardHolder(CreditCardHolder $creditCardHolder) {
        try {
            $query = $this->connection->prepare("INSERT INTO credit_card_holder VALUES(:id, :firstname, :lastname, :gender, :dateOfBirth, "
                    . ":phone, :email, :country, :city, :address, :nextOfKin, :addressOfKin, :phoneOfKin, :secretId, :roleId)");
            $query->execute([
                'id' => $creditCardHolder->getId(),
                'firstname' => $creditCardHolder->getFirstname(),
                'lastname' => $creditCardHolder->getLastname(),
                'gender' => $creditCardHolder->getGender(),
                'dateOfBirth' => $creditCardHolder->getDateOfBirth(),
                'phone' => $creditCardHolder->getPhone(),
                'email' => $creditCardHolder->getEmail(),
                'country' => $creditCardHolder->getCountry(),
                'city' => $creditCardHolder->getCity(),
                'address' => $creditCardHolder->getAddress(),
                'nextOfKin' => $creditCardHolder->getNextOfKin(),
                'addressOfKin' => $creditCardHolder->getAddressOfKin(),
                'phoneOfKin' => $creditCardHolder->getPhoneOfKin(),
                'secretId' => $creditCardHolder->getSecretId(),
                'roleId' => $creditCardHolder->getRoleId()
            ]);
            return true;
        } catch (Exception $ex) {
            
        }
    }

    public function saveSecretAnswer(Secret $secret) {
        try {
            $query = $this->connection->prepare("INSERT INTO secret VALUES(:id, :question_id, :answer)");
            $query->execute([
                'id' => $secret->getId(),
                'question_id' => $secret->getQuestion_id(),
                'answer' => $secret->getAnswer()
            ]);
            return true;
        } catch (Exception $ex) {
            
        }
    }

    public function saveCreditCardDetails(CreditCard $creditCard) {
        try {
            $query = $this->connection->prepare("INSERT INTO credit_card VALUES(:card_number, :issue_date, :expiry_date, :cvv, :issuerId, :holderId)");
            $query->execute([
                'card_number' => $creditCard->getNumber(),
                'issue_date' => $creditCard->getIssueDate(),
                'expiry_date' => $creditCard->getExpiryDate(),
                'cvv' => $creditCard->getCvv(),
                'issuerId' => $creditCard->getIssuerId(),
                'holderId' => $creditCard->getHolderId()
            ]);
            return true;
        } catch (Exception $ex) {
            
        }
    }

    public function resetCustomerPassword(Account $account) {
        try {
            $query = $this->connection->prepare("UPDATE account SET password = :password WHERE username = :username");
            $query->execute([
                'password' => $account->getPassword(),
                'username' => $account->getUsername()
            ]);
        } catch (Exception $ex) {
            
        }
    }

    public function isUsernameValid($username) {
        try {
            $query = $this->connection->prepare("SELECT * from account WHERE username = :username");
            $query->execute([
                'username' => $username
            ]);

            if ($query->rowCount() > 0) {
                return true;
            }

            return false;
        } catch (Exception $ex) {
            
        }
    }

    public function insertCompany($name, $image) {
        $query = $this->connection->prepare("INSERT INTO test_image(company, image) VALUES(:company, :image)");
        $query->execute([
            'company' => $name,
            'image' => $image
        ]);
    }

    public function saveCreditCardIssuerInfo(CreditCardIssuer $issuer) {
        $query = $this->connection->prepare("INSERT INTO credit_card_issuer(company, image) VALUES (:company, :image)");
        $query->execute([
            'company' => $issuer->getCompany(),
            'image' => $issuer->getImage()
        ]);
        return true;
    }

    public function saveSecurityQuestion(SecretQuestion $question) {
        $query = $this->connection->prepare("INSERT INTO secret_question(question) VALUES(:question)");
        $query->execute([
            'question' => $question->getQuestion()
        ]);
        return true;
    }

    public function getCardIssuerLogo(CreditCard $card) {
        $result = array();
        $query = $this->connection->prepare("SELECT image FROM credit_card_issuer, credit_card "
                . "WHERE credit_card.issuerId = credit_card_issuer.id AND credit_card.card_number = :card_number");
        $query->execute([
            'card_number' => $card->getNumber()
        ]);

        if ($query->rowCount() > 0) {
            while ($row = $query->fetch()) {
                $result[] = array('image' => $row['image']);
            }
            return $result;
        } else {
            return 'no_result';
        }
    }

    public function getTransactionId() {
        $prefix = 'CCS-TRA-GH';
        $id = '';
        try {
            $query = $this->connection->prepare("SELECT id FROM transaction_details");
            $query->execute();
            $rows = $query->rowCount() + 1;

            if ($rows < 10) {
                $id = $prefix . '00' . $rows;
            }

            if ($rows > 9 && $rows < 100) {
                $id = $prefix . '0' . $rows;
            }

            if ($rows > 99) {
                $id = $prefix . $rows;
            }

            return $id;
        } catch (Exception $ex) {
            
        }
    }

    public function isCardValid(CreditCard $card) {
        try {
            $query = $this->connection->prepare("SELECT * FROM credit_card WHERE card_number = :card_number AND cvv = :cvv AND expiry_date = :expiry_date");
            $query->execute([
                'card_number' => $card->getNumber(),
                'cvv' => $card->getCvv(),
                'expiry_date' => $card->getExpiryDate()
            ]);

            if ($query->rowCount() > 0) {
                return true;
            }
            return false;
        } catch (Exception $ex) {
            
        }
    }

    public function getPreviousLocationDetails($card_number) {
        $location = array();
        try {
            $query = $this->connection->prepare("SELECT transaction_location.country AS 'country', "
                    . "transaction_location.region AS 'region', transaction_location.city AS 'city' "
                    . "FROM transaction_details, transaction_location, credit_card_holder WHERE "
                    . "credit_card_holder.id = transaction_details.credit_card_holder_id AND "
                    . "transaction_details.id = transaction_location.transactionId AND "
                    . "transaction_details.credit_card_number = :card_number");
            $query->execute([
                'card_number' => $card_number
            ]);

            if ($query->rowCount() > 0) {
                while ($result = $query->fetch()) {
                    $location[] = array('country' => $result['country'], 'region' => $result['region'], 'city' => $result['city']);
                }

                return $location;
            } else {
                return null;
            }
        } catch (Exception $ex) {
            
        }
    }

    public function getLastTransactionAmount($card_number) {
        $amount = 0;
        $query = $this->connection->prepare("SELECT amount FROM transaction_details WHERE credit_card_number = :credit_card_number ORDER BY id DESC LIMIT 1");
        $query->execute([
            'credit_card_number' => $card_number
        ]);

        if ($query->rowCount() > 0) {
            while ($result = $query->fetch()) {
                $amount = $result['amount'];
            }
        }

        return $amount;
    }

    public function loginToBuy(Account $account) {
        try {
            $query = $this->connection->prepare("SELECT username, password FROM account WHERE username = :username AND password = :password");
            $query->execute([
                'username' => $account->getUsername(),
                'password' => $account->getPassword()
            ]);

            if ($query->rowCount() > 0) {
                $_SESSION['card_holder_loggedin'] = 1;
                $_SESSION['buyer_login'] = 1;

                $query = $this->connection->prepare("SELECT firstname FROM credit_card_holder WHERE email = :username");
                $query->execute([
                    'username' => $account->getUsername()
                ]);

                while ($result = $query->fetch()) {
                    $_SESSION['firstname'] = $result['firstname'];
                }

                return true;
            } else {
                $_SESSION['login_failed'] = 1;
                return false;
            }
        } catch (Exception $ex) {
            
        }
    }

    public function getBuyerId($username) {
        $id = '';
        try {
            $query = $this->connection->prepare("SELECT id FROM credit_card_holder WHERE email = :username");
            $query->execute([
                'username' => $username
            ]);

            if ($query->rowCount() > 0) {
                while ($result = $query->fetch()) {
                    $id = $result['id'];
                }
            }
            return $id;
        } catch (Exception $ex) {
            
        }
    }

    public function recordTransaction(Transaction $transaction) {
        try {
            $query = $this->connection->prepare("INSERT INTO transaction_details VALUES (:id, :credit_card_holder_id, :credit_card_number, :vendor_site, :amount, :transaction_date, :date_time)");
            $query->execute([
                'id' => $transaction->getId(),
                'credit_card_holder_id' => $transaction->getCreditCardHolderId(),
                'credit_card_number' => $transaction->getCreditCardNumber(),
                'vendor_site' => $transaction->getVendorSite(),
                'amount' => $transaction->getAmount(),
                'transaction_date' =>$transaction->getTransactionDate(),
                'date_time' => $transaction->getDateTime()
            ]);
            return true;
        } catch (Exception $ex) {
            
        }
    }

    public function recordTransactionLocation(TransactionLocation $transactionLocation) {
        try {
            $query = $this->connection->prepare("INSERT INTO transaction_location(transactionId, country, region, city, longitude, latitude) VALUES(:transactionId, :country, :region, :city, :longitude, :latitude)");
            $query->execute([
                'transactionId' => $transactionLocation->getTransactionId(),
                'country' => $transactionLocation->getCountry(),
                'region' => $transactionLocation->getRegion(),
                'city' => $transactionLocation->getCity(),
                'longitude' => $transactionLocation->getLongitude(),
                'latitude' => $transactionLocation->getLatitude()
            ]);
            return true;
        } catch (Exception $ex) {
            
        }
    }

    public function recordSecurityCheckHistory(SecurityCheckHistory $sec) {
        try {
            $query = $this->connection->prepare("INSERT INTO security_check_history (buyer_id, suspicious_activity, occurrence) VALUES (:buyer_id, :suspicious_activity, :occurrence)");
            $query->execute([
                'buyer_id' => $sec->getBuyerId(),
                'suspicious_activity' => $sec->getSuspiciousActivity(),
                'occurrence' => $sec->getOccurrence()
            ]);

            return true;
        } catch (Exception $ex) {
            
        }
    }

    public function updateOccurrenceValue($value, $buyerId) {
        try {
            $query = $this->connection->prepare("UPDATE security_check_history SET occurrence = :occurrence WHERE buyer_id = :buyer_id");
            $query->execute([
                'occurrence' => $value,
                'buyer_id' => $buyerId
            ]);

            return true;
        } catch (Exception $ex) {
            
        }
    }

    public function getSecurityCheckValues($buyerId) {
        try {
            $query = $this->connection->prepare("SELECT suspicious_activity, occurrence FROM security_check_history WHERE buyer_id = :buyer_id");
            $query->execute([
                'buyer_id' => $buyerId
            ]);

            $suspiciousActivity = 0;
            $occurrence = 0;
            if ($query->rowCount() > 0) {
                while ($result = $query->fetch()) {
                    $suspiciousActivity = $result['suspicious_activity'];
                    $occurrence = $result['occurrence'];
                }
            }
            return array(
                'suspicious_activity' => $suspiciousActivity,
                'occurrence' => $occurrence
            );
        } catch (Exception $ex) {
            
        }
    }

    public function resetSecurityCheckHistory($id) {
        try {
            $query = $this->connection->prepare("DELETE FROM security_check_history WHERE buyer_id = :buyer_id");
            $query->execute([
                'buyer_id' => $id
            ]);
            return true;
        } catch (Exception $ex) {
            
        }
    }

    public function getSecretDetails($username) {
        try {
            $query = $this->connection->prepare("SELECT credit_card_holder.phone AS 'phone', credit_card_holder.nextOfKin AS 'kin', secret.answer AS 'answer' FROM "
                    . "credit_card_holder, secret WHERE credit_card_holder.secretId = secret.id AND credit_card_holder.email = :email");
            $query->execute([
                'email' => $username
            ]);
            $phone = '';
            $kin = '';
            $answer = '';
            if ($query->rowCount() > 0) {
                while ($result = $query->fetch()) {
                    $phone = $result['phone'];
                    $kin = $result['kin'];
                    $answer = $result['answer'];
                }
            }
            return array(
                'phone' => $phone,
                'kin' => $kin,
                'answer' => $answer
            );
        } catch (Exception $ex) {
            
        }
    }

    public function displayTransactionsForToday() {
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
                ?>
                <table class = "table table-bordered table-responsive" id="user_table">
                    <tr>
                        <th>S/N</th>
                        <th>Name</th>
                        <th>Country</th>
                        <th>Region</th>
                        <th>City</th>
                        <th>Amount</th>
                        <th>Date/Time</th>
                    </tr>
                    <?php
                    $counter = 1;
                    while ($result = $query->fetch()) {
                        ?>
                        <tr>
                            <td><?php echo $counter; ?>
                            <td><?php echo $result['name']; ?></td>
                            <td><?php echo $result['country']; ?></td>
                            <td><?php echo $result['region']; ?></td>
                            <td><?php echo $result['city']; ?></td>
                            <td><?php echo $result['amount']; ?></td>
                            <td><?php echo $result['date_time']; ?></td>
                        </tr>
                        <?php
                        $counter += 1;
                    }
                    ?>
                </table>
                <?php
            }
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }

    public function displayAllTransactions() {
        try {
            $query = $this->connection->prepare("SELECT CONCAT(credit_card_holder.firstname,' ',credit_card_holder.lastname) AS 'name', "
                    . "transaction_location.country AS 'country', transaction_location.region AS 'region', "
                    . "transaction_location.city AS 'city', transaction_details.amount AS 'amount', "
                    . "transaction_details.date_time AS 'date_time' FROM transaction_location, transaction_details, credit_card_holder "
                    . "WHERE credit_card_holder.id = transaction_details.credit_card_holder_id AND "
                    . "transaction_details.id = transaction_location.transactionId");
            $query->execute();

            if ($query->rowCount() > 0) {
                ?>
                <table class = "table table-bordered table-responsive" id="user_table">
                    <tr>
                        <th>S/N</th>
                        <th>Name</th>
                        <th>Country</th>
                        <th>Region</th>
                        <th>City</th>
                        <th>Amount</th>
                        <th>Date/Time</th>
                    </tr>
                    <?php
                    $counter = 1;
                    while ($result = $query->fetch()) {
                        ?>
                        <tr>
                            <td><?php echo $counter; ?>
                            <td><?php echo $result['name']; ?></td>
                            <td><?php echo $result['country']; ?></td>
                            <td><?php echo $result['region']; ?></td>
                            <td><?php echo $result['city']; ?></td>
                            <td><?php echo $result['amount']; ?></td>
                            <td><?php echo $result['date_time']; ?></td>
                        </tr>
                        <?php
                        $counter += 1;
                    }
                    ?>
                </table>
                <?php
            }
        } catch (Exception $ex) {
            die($ex->getMessage());
        }
    }

}

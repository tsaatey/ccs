CREATE DATABASE IF NOT EXISTS ccs DEFAULT CHARACTER SET utf8;

USE ccs;

CREATE TABLE IF NOT EXISTS user_role(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    rolename VARCHAR(15) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS account_reset_history(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS employee(
    id VARCHAR(10) PRIMARY KEY,
    firstname VARCHAR(25) NOT NULL,
    lastname VARCHAR(25) NOT NULL,
    gender VARCHAR(4) NOT NULL,
    dateOfBirth VARCHAR(10) NOT NULL,
    phone VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    address VARCHAR(200) NOT NULL,
    roleId INTEGER NOT NULL,
    CONSTRAINT roldd FOREIGN KEY(roleId) REFERENCES user_role(id) ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS account(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(200) NOT NULL,
    roleId INTEGER NOT NULL,
    CONSTRAINT rol FOREIGN KEY(roleId) REFERENCES user_role(id) ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS credit_card_issuer(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    company VARCHAR(100) NOT NULL UNIQUE,
    image BLOB NOT NULL
);

CREATE TABLE IF NOT EXISTS secret_question(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(200) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS secret(
    id VARCHAR(20) PRIMARY KEY,
    question_id INTEGER NOT NULL,
    answer VARCHAR(200) NOT NULL,
    CONSTRAINT qid FOREIGN KEY(question_id) REFERENCES secret_question(id) ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS credit_card_holder(
    id VARCHAR(20) PRIMARY KEY,
    firstname VARCHAR(25) NOT NULL,
    lastname VARCHAR(25) NOT NULL,
    gender VARCHAR(4) NOT NULL,
    dateOfBirth DATE NOT NULL,
    phone VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    country VARCHAR(100) NOT NULL,
    city VARCHAR(100) NOT NULL,
    address VARCHAR(200) NOT NULL,
    nextOfKin VARCHAR(100) NOT NULL,
    addressOfKin VARCHAR(200) NOT NULL,
    phoneOfKin VARCHAR(20) NOT NULL,
    secretId VARCHAR(20) NOT NULL,
    roleId INTEGER NOT NULL,
    CONSTRAINT rldd FOREIGN KEY(roleId) REFERENCES user_role(id) ON UPDATE CASCADE,
    CONSTRAINT siid FOREIGN KEY(secretId) REFERENCES secret(id) ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS credit_card(
    card_number VARCHAR(100) PRIMARY KEY,
    issue_date DATE NOT NULL,
    expiry_date DATE NOT NULL,
    cvv VARCHAR(4) NOT NULL UNIQUE,
    issuerId INTEGER NOT NULL,
    holderId VARCHAR(20) NOT NULL,
    CONSTRAINT isid FOREIGN KEY(issuerId) REFERENCES credit_card_issuer(id) ON UPDATE CASCADE,
    CONSTRAINT hid FOREIGN KEY(holderId) REFERENCES credit_card_holder(id) ON UPDATE CASCADE
);


CREATE TABLE IF NOT EXISTS transaction_details(
    id VARCHAR(100) PRIMARY KEY,
    credit_card_holder_id VARCHAR(20) NOT NULL,
    credit_card_number VARCHAR(100) NOT NULL,
    vendor_site VARCHAR(1000) NOT NULL,
    amount DOUBLE NOT NULL,
    transaction_date DATE NOT NULL,
    date_time DATETIME NOT NULL,
    CONSTRAINT cchid FOREIGN KEY(credit_card_holder_id) REFERENCES credit_card_holder(id) ON UPDATE CASCADE,
    CONSTRAINT ccn FOREIGN KEY(credit_card_number) REFERENCES credit_card(card_number) ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS transaction_location(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    transactionId VARCHAR(100) NOT NULL,
    country VARCHAR(100) NOT NULL,
    region VARCHAR(100) NOT NULL,
    city VARCHAR(100) NOT NULL,
    longitude VARCHAR(20) NOT NULL,
    latitude VARCHAR(20) NOT NULL,
    CONSTRAINT tiddd FOREIGN KEY(transactionId) REFERENCES transaction_details(id) ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS security_check_history(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    buyer_id VARCHAR(20),
    suspicious_activity INTEGER,
    occurrence INTEGER,
    CONSTRAINT byid FOREIGN KEY(buyer_id) REFERENCES credit_card_holder(id) ON UPDATE CASCADE
);

INSERT INTO user_role(rolename) VALUES('Admin');
INSERT INTO user_role(rolename) VALUES('Employee');
INSERT INTO user_role(rolename) VALUES('Customer');
INSERT INTO user_role(rolename) VALUES('CEO');

INSERT INTO employee VALUES('CCS-GHA001', 'CCS Admin', 'CCS','U', '2018-02-13', '0247961400', 'admin@ccs.gh', 'CCS Office Kumasi', 1);

INSERT INTO account(username, password, roleid) VALUES('admin@ccs.gh', SHA1('admin@ccs.gh'), 1);

CREATE DATABASE IF NOT EXISTS ctlwebservice;
USE ctlwebservice;
CREATE TABLE ctloperations (id INT(20) AUTO_INCREMENT PRIMARY KEY,
randomrpcid varchar(30),
operationtime TIMESTAMP,
operation varchar(20),
movement varchar(20),
unit varchar(20),
result varchar(20))
ENGINE=InnoDB

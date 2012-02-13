CREATE TABLE DATABASE2 (id INT(20) AUTO_INCREMENT PRIMARY KEY,
snapshottime TIMESTAMP,
databasename varchar(20))
ENGINE=InnoDB;

CREATE TABLE TABLES2 (id INT(20) AUTO_INCREMENT PRIMARY KEY,
database_id INT(20),
FOREIGN KEY (database_id) REFERENCES DATABASE2 (id) ON DELETE CASCADE,
tablename varchar(20))
ENGINE=InnoDB;

CREATE TABLE COLUMNS2 (id INT(20) AUTO_INCREMENT PRIMARY KEY,
table_id INT(20),
FOREIGN KEY (table_id) REFERENCES TABLES2 (id) ON DELETE CASCADE,
columnname varchar(20),
columntype varchar(20))
ENGINE=InnoDB;

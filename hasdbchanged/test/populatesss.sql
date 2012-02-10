INSERT INTO DATABASE2 (snapshottime,databasename) VALUES (NOW(), 'userdb');
INSERT INTO TABLES2 (database_id, tablename) VALUES (LAST_INSERT_ID(), 'users');
INSERT INTO COLUMNS2(table_id, columnname, columntype) VALUES (LAST_INSERT_ID(), 'address', 'int(10)'); 


INSERT INTO DATABASE2 (snapshottime,databasename) VALUES (NOW(), 'admindb');
INSERT INTO TABLES2 (database_id, tablename) VALUES (LAST_INSERT_ID(), 'adminfolk');
INSERT INTO COLUMNS2(table_id, columnname, columntype) VALUES (LAST_INSERT_ID(), 'position', 'int(10)'); 


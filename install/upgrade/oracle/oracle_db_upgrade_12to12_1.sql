/*
============================================================
File name   : oracle_db_upgrade_11to12.sql
Begin       : 2012-11-22
Last Update : 2013-07-02

Description : primexam database structure upgrade commands
              (from version 12 to 12.1).
Database    : Oracle

Author: Ifeoluwa Opeyemi O

(c) Copyright:
              Ifeoluwa Opeyemi O
              htreasure.com LTD
              www.htreasure.com
              info@htreasure.com

License:
   Copyright (C) 2004-2013 Ifeoluwa Opeyemi O - htreasure.com LTD

   This program is free software: you can redistribute it and/or modify
   it under the terms of the GNU Affero General Public License as
   published by the Free Software Foundation, either version 3 of the
   License, or (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details.

   You should have received a copy of the GNU Affero General Public License
   along with this program.  If not, see <http://www.gnu.org/licenses/>.

   Additionally, you can't remove, move or hide the original primexam logo,
   copyrights statements and links to htreasure.com and primexam websites.

   See LICENSE.TXT file for more information.
//============================================================+
*/


CREATE TABLE prime_sslcerts (
	ssl_id NUMBER(19,0) NOT NULL,
	ssl_name VARCHAR2(255) NOT NULL,
	ssl_hash VARCHAR2(32) NOT NULL,
	ssl_end_date DATE NOT NULL,
	ssl_enabled NUMBER(1) DEFAULT '0' NOT NULL,
	ssl_user_id NUMBER(19,0) DEFAULT 1 NOT NULL,
constraint pk_prime_sslcerts primary key (ssl_id)
);
CREATE SEQUENCE prime_sslcerts_seq MINVALUE 1 START WITH 1 INCREMENT BY 1 CACHE 3;
CREATE OR REPLACE TRIGGER prime_sslcerts_trigger BEFORE INSERT ON prime_sslcerts FOR EACH ROW BEGIN SELECT prime_sslcerts_seq.nextval INTO :new.tus_id FROM DUAL; END;;

CREATE TABLE prime_testsslcerts (
	tstssl_test_id NUMBER(19,0) NOT NULL,
	tstssl_ssl_id NUMBER(19,0) NOT NULL,
constraint pk_prime_testsslcerts primary key (tstssl_test_id, tstssl_ssl_id)
);

ALTER TABLE prime_testsslcerts ADD Constraint rel_test_ssl foreign key (tstssl_test_id) references prime_tests (test_id) ON DELETE cascade;
ALTER TABLE prime_testsslcerts ADD Constraint rel_ssl_test foreign key (tstssl_ssl_id) references prime_sslcerts (ssl_id) ON DELETE cascade;

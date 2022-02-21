/*
============================================================
File name   : oracle_db_upgrade_11to12.sql
Begin       : 2012-11-22
Last Update : 2012-12-26

Description : primexam database structure upgrade commands
              (from version 11 to 11.5).
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

ALTER TABLE prime_users ADD user_otpkey VARCHAR2(255);
ALTER TABLE prime_tests ADD test_questions_order_mode NUMBER(5,0) DEFAULT 0 NOT NULL;
ALTER TABLE prime_tests ADD test_answers_order_mode NUMBER(5,0) DEFAULT 0 NOT NULL;
ALTER TABLE prime_tests ADD test_password VARCHAR2(255);
ALTER TABLE prime_tests_users DROP Constraint ak_testuser;
ALTER TABLE prime_tests_users ADD Constraint ak_testuser UNIQUE (testuser_test_id,testuser_user_id,testuser_status);
CREATE TABLE prime_testuser_stat (tus_id NUMBER(19,0) NOT NULL, tus_date DATE NOT NULL, constraint pk_prime_testuser_stat primary key (tus_id));
CREATE SEQUENCE prime_testuser_stat_seq MINVALUE 1 START WITH 1 INCREMENT BY 1 CACHE 3;
CREATE OR REPLACE TRIGGER prime_testuser_stat_trigger BEFORE INSERT ON prime_testuser_stat FOR EACH ROW BEGIN SELECT prime_testuser_stat_seq.nextval INTO :new.tus_id FROM DUAL; END;;

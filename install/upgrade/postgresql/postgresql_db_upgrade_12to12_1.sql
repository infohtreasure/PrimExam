/*
============================================================
File name   : postgresql_db_upgrade_11to12.sql
Begin       : 2012-11-22
Last Update : 2013-07-05

Description : primexam database structure upgrade commands
              (from version 12 to 12.1).
Database    : PostgreSQL 8+

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

CREATE TABLE "prime_sslcerts" (
	"ssl_id" BigSerial NOT NULL,
	"ssl_name" Varchar(255) NOT NULL,
	"ssl_hash" Varchar(32) NOT NULL,
	"ssl_end_date" Timestamp NOT NULL,
	"ssl_enabled" Boolean NOT NULL Default '0',
	"ssl_user_id" Bigint NOT NULL Default 1,
constraint "pk_prime_sslcerts" primary key ("ssl_id")
) Without Oids;

CREATE TABLE "prime_testsslcerts" (
	"tstssl_test_id" Bigint NOT NULL,
	"tstssl_ssl_id" Bigint NOT NULL,
constraint "pk_prime_testsslcerts" primary key ("tstssl_test_id", "tstssl_ssl_id")
) Without Oids;

ALTER TABLE "prime_testsslcerts" ADD CONSTRAINT "rel_test_ssl" foreign key ("tstssl_test_id") references "prime_tests" ("test_id") ON DELETE cascade;
ALTER TABLE "prime_testsslcerts" ADD CONSTRAINT "rel_ssl_test" foreign key ("tstssl_ssl_id") references "prime_sslcerts" ("ssl_id") ON DELETE cascade;

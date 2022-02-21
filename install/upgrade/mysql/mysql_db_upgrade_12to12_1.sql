/*
============================================================
File name   : mysql_db_upgrade_11to12.sql
Begin       : 2012-11-22
Last Update : 2013-07-02

Description : primexam database structure upgrade commands
              (from version 12 to 12.1).
Database    : MySQL 4.1+

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
	ssl_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
	ssl_name VARCHAR(255) NOT NULL,
	ssl_hash VARCHAR(32) NOT NULL,
	ssl_end_date DATETIME NOT NULL,
	ssl_enabled Bool NOT NULL DEFAULT '0',
	ssl_user_id BIGINT UNSIGNED NOT NULL DEFAULT 1,
 Primary Key (ssl_id)
) ENGINE = InnoDB
CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE prime_testsslcerts (
	tstssl_test_id BIGINT UNSIGNED NOT NULL,
	tstssl_ssl_id BIGINT UNSIGNED NOT NULL,
 Primary Key (tstssl_test_id, tstssl_ssl_id)
) ENGINE = InnoDB
CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER TABLE prime_testsslcerts ADD INDEX p_tstssl_test_id (tstssl_test_id);
ALTER TABLE prime_testsslcerts ADD INDEX p_tstssl_ssl_id (tstssl_ssl_id);

ALTER TABLE prime_testsslcerts ADD Foreign Key (tstssl_test_id) references prime_tests (test_id) ON DELETE cascade ON UPDATE no action;
ALTER TABLE prime_testsslcerts ADD Foreign Key (tstssl_ssl_id) references prime_sslcerts (ssl_id) ON DELETE cascade ON UPDATE no action;

/*
============================================================
File name   : postgresql_db_upgrade_7to8.sql
Begin       : 2009-02-20
Last Update : 2009-02-20

Description : primexam database structure upgrade commands
              (from version 7 to 8).
Database    : PostgreSQL 8+

Author: Ifeoluwa Opeyemi O

(c) Copyright:
              Ifeoluwa Opeyemi O
              htreasure.com LTD
              www.htreasure.com
              info@htreasure.com

License:
   Copyright (C) 2004-2010 Ifeoluwa Opeyemi O - htreasure.com LTD

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

ALTER TABLE "prime_questions" ADD "question_explanation" Text NULL;
ALTER TABLE "prime_answers" ADD "answer_explanation" Text NULL;
ALTER TABLE "prime_users" ALTER "user_ip" TYPE Varchar(39);
ALTER TABLE "prime_tests_logs" ALTER "testlog_user_ip" TYPE Varchar(39);


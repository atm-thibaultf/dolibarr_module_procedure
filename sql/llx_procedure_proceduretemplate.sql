-- Copyright (C) 2023 SuperAdmin <thibault.fiacre@atm-consulting.fr>
--
-- This program is free software: you can redistribute it and/or modify
-- it under the terms of the GNU General Public License as published by
-- the Free Software Foundation, either version 3 of the License, or
-- (at your option) any later version.
--
-- This program is distributed in the hope that it will be useful,
-- but WITHOUT ANY WARRANTY; without even the implied warranty of
-- MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
-- GNU General Public License for more details.
--
-- You should have received a copy of the GNU General Public License
-- along with this program.  If not, see https://www.gnu.org/licenses/.


CREATE TABLE IF NOT EXISTS llx_procedure_template(
    -- BEGIN MODULEBUILDER FIELDS
	rowid integer AUTO_INCREMENT PRIMARY KEY NOT NULL, 
	entity integer DEFAULT 1 NOT NULL, 
	ref varchar(128) DEFAULT '(PROV)' NOT NULL, 
	label varchar(255), 
	description text, 
	note_public text, 
	note_private text, 
	version varchar(20), 
	trigger_type varchar(10) NOT NULL, 
	fk_user_contact_point integer, 
	fk_group_contact_point integer, 
	date_last_review date, 
	fk_user_review integer, 
	date_next_review date, 
	date_valid date, 
	fk_user_valid integer, 
	date_creation datetime NOT NULL, 
	fk_user_creat integer NOT NULL, 
	fk_user_modif integer, 
	last_main_doc varchar(255), 
	import_key varchar(14), 
	model_pdf varchar(255), 
	status integer NOT NULL, 
	tms timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
	-- END MODULEBUILDER FIELDS
) ENGINE=innodb;

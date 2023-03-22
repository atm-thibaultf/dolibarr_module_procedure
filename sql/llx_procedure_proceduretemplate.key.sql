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


-- BEGIN MODULEBUILDER INDEXES
ALTER TABLE llx_procedure_proceduretemplate ADD INDEX idx_procedure_proceduretemplate_rowid (rowid);
ALTER TABLE llx_procedure_proceduretemplate ADD INDEX idx_procedure_proceduretemplate_entity (entity);
ALTER TABLE llx_procedure_proceduretemplate ADD INDEX idx_procedure_proceduretemplate_ref (ref);
ALTER TABLE llx_procedure_proceduretemplate ADD INDEX idx_procedure_proceduretemplate_fk_user_contact_point (fk_user_contact_point);
ALTER TABLE llx_procedure_proceduretemplate ADD CONSTRAINT llx_procedure_proceduretemplate_fk_user_contact_point FOREIGN KEY (fk_user_contact_point) REFERENCES llx_user(rowid);
ALTER TABLE llx_procedure_proceduretemplate ADD INDEX idx_procedure_proceduretemplate_fk_group_contact_point (fk_group_contact_point);
ALTER TABLE llx_procedure_proceduretemplate ADD CONSTRAINT llx_procedure_proceduretemplate_fk_group_contact_point FOREIGN KEY (fk_group_contact_point) REFERENCES llx_usergroup(rowid);
ALTER TABLE llx_procedure_proceduretemplate ADD INDEX idx_procedure_proceduretemplate_fk_user_review (fk_user_review);
ALTER TABLE llx_procedure_proceduretemplate ADD CONSTRAINT llx_procedure_proceduretemplate_fk_user_review FOREIGN KEY (fk_user_review) REFERENCES llx_user(rowid);
ALTER TABLE llx_procedure_proceduretemplate ADD INDEX idx_procedure_proceduretemplate_fk_user_valid (fk_user_valid);
ALTER TABLE llx_procedure_proceduretemplate ADD CONSTRAINT llx_procedure_proceduretemplate_fk_user_valid FOREIGN KEY (fk_user_valid) REFERENCES llx_user(rowid);
ALTER TABLE llx_procedure_proceduretemplate ADD INDEX idx_procedure_proceduretemplate_fk_user_creat (fk_user_creat);
ALTER TABLE llx_procedure_proceduretemplate ADD CONSTRAINT llx_procedure_proceduretemplate_fk_user_creat FOREIGN KEY (fk_user_creat) REFERENCES llx_user(rowid);
ALTER TABLE llx_procedure_proceduretemplate ADD INDEX idx_procedure_proceduretemplate_fk_user_modif (fk_user_modif);
ALTER TABLE llx_procedure_proceduretemplate ADD INDEX idx_procedure_proceduretemplate_status (status);
-- END MODULEBUILDER INDEXES

-- ALTER TABLE llx_procedure_myobject ADD UNIQUE INDEX uk_procedure_myobject_fieldxy(fieldx, fieldy);
-- ALTER TABLE llx_procedure_myobject ADD CONSTRAINT llx_procedure_myobject_fk_field FOREIGN KEY (fk_field) REFERENCES llx_procedure_myotherobject(rowid);






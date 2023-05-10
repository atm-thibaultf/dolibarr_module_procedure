<?php
/* Copyright (C) 2017  Laurent Destailleur      <eldy@users.sourceforge.net>
 * Copyright (C) 2023  Frédéric France          <frederic.france@netlogic.fr>
 * Copyright (C) 2023 SuperAdmin <thibault.fiacre@atm-consulting.fr>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

/**
 * \file        class/proceduretemplatestep.class.php
 * \ingroup     procedure
 * \brief       This file is a CRUD class file for ProcedureTemplateStep (Create/Read/Update/Delete)
 */

// Put here all includes required by your class file
require_once DOL_DOCUMENT_ROOT.'/core/class/commonobject.class.php';
require_once DOL_DOCUMENT_ROOT.'/custom/procedure/class/proceduretemplate.class.php';

/**
 * Class for ProcedureTemplateStep
 */
class ProcedureTemplateStep extends CommonObject
{
	/**
	 * @var string ID of module.
	 */
	public $module = 'procedure';

	/**
	 * @var string ID to identify managed object.
	 */
	public $element = 'proceduretemplatestep';

	/**
	 * @var string Name of table without prefix where object is stored. This is also the key used for extrafields management.
	 */
	public $table_element = 'procedure_template_step';

	/**
	 * @var int  Does this object support multicompany module ?
	 * 0=No test on entity, 1=Test with field entity, 'field@table'=Test with link by field@table
	 */
	public $ismultientitymanaged = 0;

	/**
	 * @var int  Does object support extrafields ? 0=No, 1=Yes
	 */
	public $isextrafieldmanaged = 1;

	/**
	 * @var string String with name of icon for myobject. Must be a 'fa-xxx' fontawesome code (or 'fa-xxx_fa_color_size') or 'myobject@procedure' if picto is file 'img/object_myobject.png'.
	 */
	public $picto = 'fa-file';

	/**
	 *  'type' field format:
	 *  	'integer', 'integer:ObjectClass:PathToClass[:AddCreateButtonOrNot[:Filter[:Sortfield]]]',
	 *  	'select' (list of values are in 'options'),
	 *  	'sellist:TableName:LabelFieldName[:KeyFieldName[:KeyFieldParent[:Filter[:Sortfield]]]]',
	 *  	'chkbxlst:...',
	 *  	'varchar(x)',
	 *  	'text', 'text:none', 'html',
	 *   	'double(24,8)', 'real', 'price',
	 *  	'date', 'datetime', 'timestamp', 'duration',
	 *  	'boolean', 'checkbox', 'radio', 'array',
	 *  	'mail', 'phone', 'url', 'password', 'ip'
	 *		Note: Filter must be a Dolibarr Universal Filter syntax string. Example: "(t.ref:like:'SO-%') or (t.date_creation:<:'20160101') or (t.status:!=:0) or (t.nature:is:NULL)"
	 *  'label' the translation key.
	 *  'picto' is code of a picto to show before value in forms
	 *  'enabled' is a condition when the field must be managed (Example: 1 or '$conf->global->MY_SETUP_PARAM' or 'isModEnabled("multicurrency")' ...)
	 *  'position' is the sort order of field.
	 *  'notnull' is set to 1 if not null in database. Set to -1 if we must set data to null if empty ('' or 0).
	 *  'visible' says if field is visible in list (Examples: 0=Not visible, 1=Visible on list and create/update/view forms, 2=Visible on list only, 3=Visible on create/update/view form only (not list), 4=Visible on list and update/view form only (not create). 5=Visible on list and view only (not create/not update). Using a negative value means field is not shown by default on list but can be selected for viewing)
	 *  'noteditable' says if field is not editable (1 or 0)
	 *  'alwayseditable' says if field can be modified also when status is not draft ('1' or '0')
	 *  'default' is a default value for creation (can still be overwrote by the Setup of Default Values if field is editable in creation form). Note: If default is set to '(PROV)' and field is 'ref', the default value will be set to '(PROVid)' where id is rowid when a new record is created.
	 *  'index' if we want an index in database.
	 *  'foreignkey'=>'tablename.field' if the field is a foreign key (it is recommanded to name the field fk_...).
	 *  'searchall' is 1 if we want to search in this field when making a search from the quick search button.
	 *  'isameasure' must be set to 1 or 2 if field can be used for measure. Field type must be summable like integer or double(24,8). Use 1 in most cases, or 2 if you don't want to see the column total into list (for example for percentage)
	 *  'css' and 'cssview' and 'csslist' is the CSS style to use on field. 'css' is used in creation and update. 'cssview' is used in view mode. 'csslist' is used for columns in lists. For example: 'css'=>'minwidth300 maxwidth500 widthcentpercentminusx', 'cssview'=>'wordbreak', 'csslist'=>'tdoverflowmax200'
	 *  'help' and 'helplist' is a 'TranslationString' to use to show a tooltip on field. You can also use 'TranslationString:keyfortooltiponlick' for a tooltip on click.
	 *  'showoncombobox' if value of the field must be visible into the label of the combobox that list record
	 *  'disabled' is 1 if we want to have the field locked by a 'disabled' attribute. In most cases, this is never set into the definition of $fields into class, but is set dynamically by some part of code.
	 *  'arrayofkeyval' to set a list of values if type is a list of predefined values. For example: array("0"=>"Draft","1"=>"Active","-1"=>"Cancel"). Note that type can be 'integer' or 'varchar'
	 *  'autofocusoncreate' to have field having the focus on a create form. Only 1 field should have this property set to 1.
	 *  'comment' is not used. You can store here any text of your choice. It is not used by application.
	 *	'validate' is 1 if need to validate with $this->validateField()
	 *  'copytoclipboard' is 1 or 2 to allow to add a picto to copy value into clipboard (1=picto after label, 2=picto after value)
	 *
	 *  Note: To have value dynamic, you can set value to 0 in definition and edit the value on the fly into the constructor.
	 */

	// BEGIN MODULEBUILDER PROPERTIES
	/**
	 * @var array  Array with all fields and their property. Do not use it as a static var. It may be modified by constructor.
	 */
	public $fields=array(
		'rowid' => array('type'=>'integer', 'label'=>'TechnicalID', 'enabled'=>'1', 'position'=>1, 'notnull'=>1, 'visible'=>0, 'noteditable'=>'1', 'index'=>1, 'css'=>'left', 'comment'=>"Id"),
		'rank' => array('type'=>'integer', 'label'=>'Rank', 'enabled'=>'1', 'position'=>20, 'notnull'=>1, 'visible'=>5, 'noteditable'=>'1', 'default'=>'1', 'index'=>1, 'css'=>'left', 'csslist'=>'left', 'searchall'=>1, 'validate'=>'1', 'comment'=>"Rank of object"),
		'label' => array('type'=>'varchar(255)', 'label'=>'Label', 'enabled'=>'1', 'position'=>30, 'notnull'=>0, 'visible'=>1, 'alwayseditable'=>'0', 'searchall'=>1, 'cssview'=>'wordbreak', 'help'=>"Help text", 'showoncombobox'=>'2', 'validate'=>'1',),
		'description' => array('type'=>'html', 'label'=>'Description', 'enabled'=>'1', 'position'=>60, 'notnull'=>0, 'visible'=>1, 'validate'=>'1', 'csslist'=>'minwidth300 widthcentpercentminusx',),
		'fk_proceduretemplate' => array('type'=>'integer:ProcedureTemplate:procedure/class/proceduretemplate.class.php', 'label'=>'ProcedureTemplate', 'enabled'=>'1', 'position'=>50, 'notnull'=>1, 'visible'=>3, 'noteditable'=>0, 'index'=>1, 'css'=>'maxwidth500 widthcentpercentminusxx', 'csslist'=>'tdoverflowmax150',),
		'date_creation' => array('type'=>'datetime', 'label'=>'DateCreation', 'enabled'=>'1', 'position'=>500, 'notnull'=>1, 'visible'=>-2,),
		'tms' => array('type'=>'timestamp', 'label'=>'DateModification', 'enabled'=>'1', 'position'=>501, 'notnull'=>0, 'visible'=>-2,),
		'fk_user_creat' => array('type'=>'integer:User:user/class/user.class.php', 'label'=>'UserAuthor', 'picto'=>'user', 'enabled'=>'1', 'position'=>510, 'notnull'=>1, 'visible'=>-2, 'foreignkey'=>'user.rowid', 'csslist'=>'tdoverflowmax150',),
		'fk_user_modif' => array('type'=>'integer:User:user/class/user.class.php', 'label'=>'UserModif', 'picto'=>'user', 'enabled'=>'1', 'position'=>511, 'notnull'=>-1, 'visible'=>-2, 'csslist'=>'tdoverflowmax150',),
		'import_key' => array('type'=>'varchar(14)', 'label'=>'ImportId', 'enabled'=>'1', 'position'=>1000, 'notnull'=>-1, 'visible'=>-2,),
	);
	public $rowid;
	public $fk_proceduretemplate;
	public $rank;
	public $label;
	public $description;
	public $date_creation;
	public $tms;
	public $fk_user_creat;
	public $fk_user_modif;
	public $import_key;


	// END MODULEBUILDER PROPERTIES

	/**
	  * @var string    Field with ID of parent key if this object has a parent
	*/
	public $fk_element = 'fk_proceduretemplate';

	/**
	 * Constructor
	 *
	 * @param DoliDb $db Database handler
	 */
	public function __construct(DoliDB $db)
	{
		global $conf, $langs;

		$this->db = $db;

		if (empty($conf->global->MAIN_SHOW_TECHNICAL_ID) && isset($this->fields['rowid']) && !empty($this->fields['ref'])) {
			$this->fields['rowid']['visible'] = 0;
		}
		if (!isModEnabled('multicompany') && isset($this->fields['entity'])) {
			$this->fields['entity']['enabled'] = 0;
		}

		// Example to show how to set values of fields definition dynamically
		/*if ($user->hasRights->('procedure', 'myobject', 'read')) {
			$this->fields['myfield']['visible'] = 1;
			$this->fields['myfield']['noteditable'] = 0;
		}*/

		// Unset fields that are disabled
		foreach ($this->fields as $key => $val) {
			if (isset($val['enabled']) && empty($val['enabled'])) {
				unset($this->fields[$key]);
			}
		}

		// Translate some data of arrayofkeyval
		if (is_object($langs)) {
			foreach ($this->fields as $key => $val) {
				if (!empty($val['arrayofkeyval']) && is_array($val['arrayofkeyval'])) {
					foreach ($val['arrayofkeyval'] as $key2 => $val2) {
						$this->fields[$key]['arrayofkeyval'][$key2] = $langs->trans($val2);
					}
				}
			}
		}
	}

	/**
	 * Create object into database
	 *
	 * @param  User $user      User that creates
	 * @param  bool $notrigger false=launch triggers after, true=disable triggers
	 * @return int             <0 if KO, Id of created object if OK
	 */
	public function create(User $user, $notrigger = false)
	{

		$resultcreate = $this->createCommon($user, $notrigger);

		// if source steps exist we save them in database
		if ($resultcreate && !empty($this->step_source)) {
			$this->create_source_step($user, $this->id);
		}

		$this->db->commit();

		return $resultcreate;
	}

	/**
	 * Load object in memory from the database
	 *
	 * @param int    $id   Id object
	 * @param string $ref  Ref
	 * @return int         <0 if KO, 0 if not found, >0 if OK
	 */
	public function fetch($id, $ref = null)
	{
		$result = $this->fetchCommon($id, $ref);
		if ($result > 0 && !empty($this->table_element_line)) {
			$this->fetchLines();
		}
		return $result;
	}

	/**
	 * Load list of objects in memory from the database.
	 *
	 * @param  string      $sortorder    Sort Order
	 * @param  string      $sortfield    Sort field
	 * @param  int         $limit        limit
	 * @param  int         $offset       Offset
	 * @param  array       $filter       Filter array. Example array('field'=>'valueforlike', 'customurl'=>...)
	 * @param  string      $filtermode   Filter mode (AND or OR)
	 * @return array|int                 int <0 if KO, array of pages if OK
	 */
	public function fetchAll($sortorder = '', $sortfield = '', $limit = 0, $offset = 0, $filter = '', $filtermode = 'AND')
	{
		global $conf;

		dol_syslog(__METHOD__, LOG_DEBUG);

		$records = array();

		$sql = "SELECT ";
		$sql .= $this->getFieldList('t') . ", pt.label AS labelproceduretemplate";
		$sql .= " FROM ".$this->db->prefix().$this->table_element." as t";
		$sql .= " LEFT JOIN ".$this->db->prefix()."procedure_template as pt ON pt.rowid = t.".$this->fk_element;
		if (isset($this->ismultientitymanaged) && $this->ismultientitymanaged == 1) {
			$sql .= " WHERE t.entity IN (".getEntity($this->element).")";
		} else {
			$sql .= " WHERE 1 = 1";
		}
		// Manage filter
		$sqlwhere = array();
		if (!empty($filter)) {
			foreach ($filter as $key => $value) {
				if ($key == 't.rowid') {
					$sqlwhere[] = $key." = ".((int) $value);
				} elseif (in_array($this->fields[$key]['type'], array('date', 'datetime', 'timestamp'))) {
					$sqlwhere[] = $key." = '".$this->db->idate($value)."'";
				} elseif ($key == 'customsql') {
					$sqlwhere[] = $value;
				} elseif (strpos($value, '%') === false) {
					$sqlwhere[] = $key." IN (".$this->db->sanitize($this->db->escape($value)).")";
				} else {
					$sqlwhere[] = $key." LIKE '%".$this->db->escape($value)."%'";
				}
			}
		}
		if (count($sqlwhere) > 0) {
			$sql .= " AND (".implode(" ".$filtermode." ", $sqlwhere).")";
		}

		if (!empty($sortfield)) {
			$sql .= $this->db->order($sortfield, $sortorder);
		}
		if (!empty($limit)) {
			$sql .= $this->db->plimit($limit, $offset);
		}

		$resql = $this->db->query($sql);

		if ($resql) {
			$num = $this->db->num_rows($resql);

			$i = 0;
			while ($i < ($limit ? min($limit, $num) : $num)) {
				$obj = $this->db->fetch_object($resql);

				$record = new self($this->db);
				$record->setVarsFromFetchObj($obj);
				$record->labelproceduretemplate = $obj->labelproceduretemplate;
				$records[$i] = $record;

				$i++;
			}
			$this->db->free($resql);

			return $records;
		} else {
			$this->errors[] = 'Error '.$this->db->lasterror();
			dol_syslog(__METHOD__.' '.join(',', $this->errors), LOG_ERR);

			return -1;
		}
	}

	/**
	 * Update object into database
	 *
	 * @param  User $user      User that modifies
	 * @param  bool $notrigger false=launch triggers after, true=disable triggers
	 * @return int             <0 if KO, >0 if OK
	 */
	public function update(User $user, $notrigger = false)
	{
		$resultupdate = $this->updateCommon($user, $notrigger);

		// if source steps exist we save them in database
		if ($resultupdate && !empty($this->step_source)) {
			$this->delete_source_step($user, $this->id);
			$this->create_source_step($user, $this->id);
		}

		return $resultupdate;

	}

	/**
	 * Delete object in database
	 *
	 * @param User $user       User that deletes
	 * @param bool $notrigger  false=launch triggers, true=disable triggers
	 * @return int             <0 if KO, >0 if OK
	 */
	public function delete(User $user, $notrigger = false)
	{
		return $this->deleteCommon($user, $notrigger);
		//return $this->deleteCommon($user, $notrigger, 1);
	}

	/**
	 * getTooltipContentArray
	 * @param array $params params to construct tooltip data
	 * @since v18
	 * @return array
	 */
	public function getTooltipContentArray($params)
	{
		global $conf, $langs, $user;

		$datas = [];

		if (!empty($conf->global->MAIN_OPTIMIZEFORTEXTBROWSER)) {
			return ['optimize' => $langs->trans("ShowProcedureTemplateStep")];
		}
		$datas['picto'] = img_picto('', $this->picto).' <u>'.$langs->trans("ProcedureTemplateStep").'</u>';
		if (isset($this->status)) {
			$datas['picto'] .= ' '.$this->getLibStatut(5);
		}
		$datas['ref'] .= '<br><b>'.$langs->trans('Ref').':</b> '.$this->ref;

		return $datas;
	}

	/**
	 *	Load the info information in the object
	 *
	 *	@param  int		$id       Id of object
	 *	@return	void
	 */
	public function info($id)
	{
		$sql = "SELECT rowid,";
		$sql .= " date_creation as datec, tms as datem,";
		$sql .= " fk_user_creat, fk_user_modif";
		$sql .= " FROM ".MAIN_DB_PREFIX.$this->table_element." as t";
		$sql .= " WHERE t.rowid = ".((int) $id);

		$result = $this->db->query($sql);
		if ($result) {
			if ($this->db->num_rows($result)) {
				$obj = $this->db->fetch_object($result);

				$this->id = $obj->rowid;

				$this->user_creation_id = $obj->fk_user_creat;
				$this->user_modification_id = $obj->fk_user_modif;
				if (!empty($obj->fk_user_valid)) {
					$this->user_validation_id = $obj->fk_user_valid;
				}
				$this->date_creation     = $this->db->jdate($obj->datec);
				$this->date_modification = empty($obj->datem) ? '' : $this->db->jdate($obj->datem);
				if (!empty($obj->datev)) {
					$this->date_validation   = empty($obj->datev) ? '' : $this->db->jdate($obj->datev);
				}
			}

			$this->db->free($result);
		} else {
			dol_print_error($this->db);
		}
	}

	// SOURCE STEPS ------------------------------------------------------------------------------------------------------------------------------

	/**
	 * Load source steps from the database
	 *
	 * @param int    $id   Id of step
	 * @return array|int	int <0 if KO, array of source steps if OK
	 */
	public function fetch_source_steps($id)
	{
		// if source steps exist we save them in database
		if ($id) {

			$this->db->begin();

			if (!$error) {
				$sql = "SELECT fk_source_step";
				$sql .= " FROM ".MAIN_DB_PREFIX."procedure_template_step_link as t";
				$sql .= " WHERE t.fk_step = ".((int) $id);
				$resql = $this->db->query($sql);

				if ($resql) {

					$num = $this->db->num_rows($resql);
					$source_step = $resql->fetch_all();
					$i = 0;

					while ($i < $num) {
						$records[$i] = $source_step[$i][0];
						$i++;
					}

					$this->db->free($resql);

					return $records;

				} else {
					$this->errors[] = 'Error '.$this->db->lasterror();
					dol_syslog(__METHOD__.' '.join(',', $this->errors), LOG_ERR);
					return -1;
				}
			} else {
				$this->db->rollback();
				$error++;
				// Creation KO
				if (!empty($this->errors)) {
					setEventMessages(null, $this->errors, 'errors');
				} else {
					setEventMessages($this->error, null, 'errors');
				}
			}
		} else {
			setEventMessages($this->error, null, 'errors');
		}
		return -1;
	}

	/**
	 *  Output html form to select a source step
	 *
	 *	@param	int   	$selected       Preselected step id
	 *	@param  string	$htmlname       Name of field in form
	 *  @param  string	$filter         Optionnal filters criteras (example: 's.rowid <> x')
	 *	@param	int		$showempty		Add an empty field
	 * 	@param	int		$showtype		Show third party type in combolist (customer, prospect or supplier)
	 * 	@param	int		$forcecombo		Force to use combo box
	 *  @param	array	$event			Event options. Example: array(array('method'=>'getContacts', 'url'=>dol_buildpath('/core/ajax/contacts.php',1), 'htmlname'=>'contactid', 'params'=>array('add-customer-contact'=>'disabled')))
	 *  @param	string	$filterkey		Filter on key value
	 *  @param	int		$outputmode		0=HTML select string, 1=Array, 2=without form tag
	 *  @param	int		$limit			Limit number of answers
	 *  @param	string	$morecss		More css
	 * 	@param	bool	$multiple       add [] in the name of element and add 'multiple' attribut
	 * 	@return	string|array			HTML string with
	 */
	public function select_step_source($selected = '', $htmlname = 'fk_source_step', $filter = '', $showempty = 0, $showtype = 0, $forcecombo = 0, $event = array(), $filterkey = '', $outputmode = 0, $limit = 20, $morecss = '', $multiple = false)
	{
		// phpcs:enable
		global $conf, $user, $langs;

		$out = '';
		$outarray = array();

		$stepstat = new ProcedureTemplateStep($this->db);


		$steps_used = $stepstat->fetchAll('ASC', 't.rowid', $limit, 0, $filter);

		if (!empty($selected) && !is_array($selected)) {
			$selected = array($selected);
		}

		if ($outputmode != 2) {
			$out = '<form action="'.$_SERVER["PHP_SELF"].'" method="POST">';
			$out .= '<input type="hidden" name="token" value="'.newToken().'">';
		}

		if ($stepstat) {
			// Construct $out and $outarray
			$out .= '<select id="'.$htmlname.'" class="flat minwidth100'.($morecss ? ' '.$morecss : '').'" name="'.$htmlname.($multiple ? '[]' : '').'" '.($multiple ? 'multiple' : '').'>'."\n";
			if ($showempty) {
				$out .= '<option value="-1">&nbsp;</option>'."\n";
			}

			$num = 0;
			if (is_array($steps_used)) {
				$num = count($steps_used);
			}

			$i = 0;

			if ($num) {
				while ($i < $num) {

						$label = $steps_used[$i]->label;

						// Test if entry is the first element of $selected.
						if ((isset($selected[0]) && is_object($selected[0]) && $selected[0]->id == $steps_used[$i]->id) || ((!isset($selected[0]) || !is_object($selected[0])) && !empty($selected) && in_array($steps_used[$i]->id, $selected))) {
							$out .= '<option value="' . $steps_used[$i]->id . '" selected>' . $steps_used[$i]->labelproceduretemplate . ' >> ' . $label . '</option>';
						} else {
							if ($steps_used[$i]->id != $this->id) {
								$out .= '<option value="' . $steps_used[$i]->id . '">' . $steps_used[$i]->labelproceduretemplate . ' >> ' . $label . '</option>';
							}
						}

						array_push($outarray, array('key' => $steps_used[$i]->id, 'value' => $steps_used[$i]->id, 'label' => $label));

						$i++;
				}
			}
			$out .= '</select>'."\n";

			if (!empty($conf->use_javascript_ajax) && !empty($conf->global->RESOURCE_USE_SEARCH_TO_SELECT) && !$forcecombo) {
				//$minLength = (is_numeric($conf->global->RESOURCE_USE_SEARCH_TO_SELECT)?$conf->global->RESOURCE_USE_SEARCH_TO_SELECT:2);
				$out .= ajax_combobox($htmlname, $event, $conf->global->RESOURCE_USE_SEARCH_TO_SELECT);
			} else {
				$out .= ajax_combobox($htmlname);
			}

			if ($outputmode != 2) {
				$out .= '<input type="submit" class="button" value="'.$langs->trans("Search").'"> &nbsp; &nbsp; ';

				$out .= '</form>';
			}
		} else {
			dol_print_error($this->db);
		}

		if ($outputmode && $outputmode != 2) {
			return $outarray;
		}
		return $out;
	}

	/**
	 * Create source steps into database
	 *
	 * @param  User $user      User that creates
	 * @param  Id $id		   Id of the step to delete source steps from
	 * @return int             <0 if KO, Id of created object if OK
	 */
	public function create_source_step(User $user, $id)
	{
		$error = 0;

		$this->db->begin();

		if (!$error) {
			foreach ($this->step_source AS $key => $value) {
				$sql = "INSERT INTO " . $this->db->prefix() . 'procedure_template_step_link';
				$sql .= " (fk_source_step, fk_step)";
				$sql .= " VALUES (" . $value . ", " . $this->id . ");";
				$res = $this->db->query($sql);
			}
			if (!$res) {
				$error++;
				$this->errors[] = $this->db->lasterror();
			}
		}

		// Commit or rollback
		if ($error) {
			$this->db->rollback();
			$error++;
			// Creation KO
			if (!empty($this->errors)) {
				setEventMessages(null, $this->errors, 'errors');
				return -1;
			} else {
				setEventMessages($this->error, null, 'errors');
				return -1;
			}
			$action = 'create';
		}

		$this->db->commit();

		return 1;
	}

	/**
	 * Delete source steps of a step in database
	 *
	 * @param User $user       User that deletes
	 * @param Id $id			Id of the step to delete source steps from
	 * @return int             <0 if KO, >0 if OK
	 */
	public function delete_source_step(User $user, $id)
	{
		$error = 0;

		$this->db->begin();

		if (!$error) {
			$sql = 'DELETE FROM '.$this->db->prefix().'procedure_template_step_link WHERE fk_step='.((int) $this->id);

			$resql = $this->db->query($sql);
			if (!$resql) {
				$error++;
				$this->errors[] = $this->db->lasterror();
			}
		}

		// Commit or rollback
		if ($error) {
			$this->db->rollback();
			return -1;
		} else {
			$this->db->commit();
			return 1;
		}
	}


}

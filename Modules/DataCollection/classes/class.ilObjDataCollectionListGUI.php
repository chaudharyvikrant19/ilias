<?php

/* Copyright (c) 1998-2009 ILIAS open source, Extended GPL, see docs/LICENSE */

include_once "Services/Object/classes/class.ilObjectListGUI.php";

/**
* Class ilObjDataCollectionListGUI
*
* @author Jörg Lützenkirchen <luetzenkirchen@leifos.com>
* $Id: class.ilObjRootFolderListGUI.php 23764 2010-05-06 15:11:30Z smeyer $
*
* @extends ilObjectListGUI
*/
class ilObjDataCollectionListGUI extends ilObjectListGUI
{
	/**
	 * initialisation
	 */
	public function init()
	{
		$this->copy_enabled = true;
		$this->delete_enabled = true;
		$this->cut_enabled = true;
		$this->subscribe_enabled = true;
		$this->link_enabled = true;
		$this->payment_enabled = false;
		$this->info_screen_enabled = true;
		$this->type = "dcl";
		$this->gui_class_name = "ilobjdatacollectiongui";

		// general commands array
		include_once('./Modules/DataCollection/classes/class.ilObjDataCollectionAccess.php');
		$this->commands = ilObjDataCollectionAccess::_getCommands();
	}

	/**
	 * Get item properties
	 *
	 * @return	array		array of property arrays:
	 *					"alert" (boolean) => display as an alert property (usually in red)
	 *					"property" (string) => property name
	 *					"value" (string) => property value
	 */
	public function getProperties()
	{
		global $lng, $ilUser;

		$props = array();

		include_once("./Modules/DataCollection/classes/class.ilObjDataCollectionAccess.php");

		if(!ilObjDataCollectionAccess::_lookupOnline($this->obj_id))
		{
			$props[] = array(
				"alert" => true, 
				"property" => $lng->txt("status"),
				"value" => $lng->txt("offline")
			);
		}

		return $props;
	}
}

?>
<?php
/*
	+-----------------------------------------------------------------------------+
	| ILIAS open source                                                           |
	+-----------------------------------------------------------------------------+
	| Copyright (c) 1998-2001 ILIAS open source, University of Cologne            |
	|                                                                             |
	| This program is free software; you can redistribute it and/or               |
	| modify it under the terms of the GNU General Public License                 |
	| as published by the Free Software Foundation; either version 2              |
	| of the License, or (at your option) any later version.                      |
	|                                                                             |
	| This program is distributed in the hope that it will be useful,             |
	| but WITHOUT ANY WARRANTY; without even the implied warranty of              |
	| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the               |
	| GNU General Public License for more details.                                |
	|                                                                             |
	| You should have received a copy of the GNU General Public License           |
	| along with this program; if not, write to the Free Software                 |
	| Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA. |
	+-----------------------------------------------------------------------------+
*/

require_once("./Services/COPage/classes/class.ilPageContent.php");

/**
* Class ilPCVerification
*
* Verification content object (see ILIAS DTD)
*
* @author Jörg Lützenkirchen <luetzenkirchen@leifos.com>
* @version $Id: class.ilPCListItem.php 22210 2009-10-26 09:46:06Z akill $
*
* @ingroup ServicesCOPage
*/
class ilPCVerification extends ilPageContent
{
	var $dom;

	/**
	* Init page content component.
	*/
	function init()
	{
		$this->setType("vrfc");
	}

	/**
	* Set node
	*/
	function setNode(&$a_node)
	{
		parent::setNode($a_node);		// this is the PageContent node
		$this->vrfc_node =& $a_node->first_child();		// this is the verification node
	}

	/**
	* Create verification node in xml.
	*
	* @param	object	$a_pg_obj		Page Object
	* @param	string	$a_hier_id		Hierarchical ID
	*/
	function create(&$a_pg_obj, $a_hier_id, $a_pc_id = "")
	{
		$this->node = $this->createPageContentNode();
		$a_pg_obj->insertContent($this, $a_hier_id, IL_INSERT_AFTER, $a_pc_id);
		$this->vrfc_node = $this->dom->create_element("Verification");
		$this->vrfc_node = $this->node->append_child($this->vrfc_node);
	}

	/**
	 * Set verification data
	 *
	 * @param string $a_type
	 * @param int $a_id
	 */
	function setData($a_type, $a_id)
	{
		global $ilUser;
		
		$this->vrfc_node->set_attribute("Type", $a_type);
		$this->vrfc_node->set_attribute("Id", $a_id);
		$this->vrfc_node->set_attribute("User", $ilUser->getId());
	}

	/**
	* Get verification data
	*
	* @return array
	*/
	function getData()
	{
		if (is_object($this->vrfc_node))
		{
			return array("id"=>$this->vrfc_node->get_attribute("Id"),
				"type"=>$this->vrfc_node->get_attribute("Type"),
				"user"=>$this->vrfc_node->get_attribute("User"));
		}
	}
	
	public static function isInPortfolioPage(ilPortfolioPage $a_page, $a_type, $a_id)
	{
		// try to find verification in portfolio page
		$a_page->buildDom();
		$dom = $a_page->getDom();					
		if($dom instanceof php4DOMDocument)
		{
			$dom = $dom->myDOMDocument;
		}		
		$xpath_temp = new DOMXPath($dom);
		$nodes = $xpath_temp->query("//PageContent/Verification");
		foreach($nodes as $node)
		{
			if($node->getAttribute("Type") == $a_type &&
				$node->getAttribute("Id") == $a_id)
			{
				return true;
			}
		}
		
		return false;
	}
}

?>
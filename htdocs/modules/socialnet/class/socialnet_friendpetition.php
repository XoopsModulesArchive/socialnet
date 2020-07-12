<?php
//  ------------------------------------------------------------------------ //
//                      SOCIALNET - MODULE FOR XOOPS 2                       //
//                  Copyright (c) 2009-2010  David Yanez Osses               //
//                     <http://www.ipwgc.com/>                      		 //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

include_once XOOPS_ROOT_PATH."/class/xoopsobject.php";
/**
* socialnet_friendpetition class.  
* $this class is responsible for providing data access mechanisms to the data source 
* of XOOPS user class objects.
*/


class socialnet_friendpetition extends XoopsObject
{ 
	var $db;

// constructor
	function socialnet_friendpetition ($id=null)
	{
		$this->db =& Database::getInstance();
		$this->initVar("friendpet_id",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("petitioner_uid",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("petioned_uid",XOBJ_DTYPE_INT,null,false,10);
		if ( !empty($id) ) {
			if ( is_array($id) ) {
				$this->assignVars($id);
			} else {
					$this->load(intval($id));
			}
		} else {
			$this->setNew();
		}
		
	}

	function load($id)
	{
		$sql = 'SELECT * FROM '.$this->db->prefix("socialnet_friendpetition").' WHERE friendpet_id='.$id;
		$myrow = $this->db->fetchArray($this->db->query($sql));
		$this->assignVars($myrow);
		if (!$myrow) {
			$this->setNew();
		}
	}

	function getAllsocialnet_friendpetitions($criteria=array(), $asobject=false, $sort="friendpet_id", $order="ASC", $limit=0, $start=0)
	{
		$db =& Database::getInstance();
		$ret = array();
		$where_query = "";
		if ( is_array($criteria) && count($criteria) > 0 ) {
			$where_query = " WHERE";
			foreach ( $criteria as $c ) {
				$where_query .= " $c AND";
			}
			$where_query = substr($where_query, 0, -4);
		} elseif ( !is_array($criteria) && $criteria) {
			$where_query = " WHERE ".$criteria;
		}
		if ( !$asobject ) {
			$sql = "SELECT friendpet_id FROM ".$db->prefix("socialnet_friendpetition")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = $myrow['socialnet_friendpetition_id'];
			}
		} else {
			$sql = "SELECT * FROM ".$db->prefix("socialnet_friendpetition")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = new socialnet_friendpetition ($myrow);
			}
		}
		return $ret;
	}
}
// -------------------------------------------------------------------------
// ------------------socialnet_friendpetition user handler class -------------------
// -------------------------------------------------------------------------
/**
* socialnet_friendpetitionhandler class.  
* This class provides simple mecanisme for socialnet_friendpetition object
*/

class Xoopssocialnet_friendpetitionHandler extends XoopsObjectHandler
{

	/**
	* create a new socialnet_friendpetition
	* 
	* @param bool $isNew flag the new objects as "new"?
	* @return object socialnet_friendpetition
	*/
	function &create($isNew = true)	{
		$socialnet_friendpetition = new socialnet_friendpetition();
		if ($isNew) {
			$socialnet_friendpetition->setNew();
		}
		else{
		$socialnet_friendpetition->unsetNew();
		}

		
		return $socialnet_friendpetition;
	}

	/**
	* retrieve a socialnet_friendpetition
	* 
	* @param int $id of the socialnet_friendpetition
	* @return mixed reference to the {@link socialnet_friendpetition} object, FALSE if failed
	*/
	function &get($id)	{
			$sql = 'SELECT * FROM '.$this->db->prefix('socialnet_friendpetition').' WHERE friendpet_id='.$id;
			if (!$result = $this->db->query($sql)) {
				return false;
			}
			$numrows = $this->db->getRowsNum($result);
			if ($numrows == 1) {
				$socialnet_friendpetition = new socialnet_friendpetition();
				$socialnet_friendpetition->assignVars($this->db->fetchArray($result));
				return $socialnet_friendpetition;
			}
				return false;
	}

/**
* insert a new socialnet_friendpetition in the database
* 
* @param object $socialnet_friendpetition reference to the {@link socialnet_friendpetition} object
* @param bool $force
* @return bool FALSE if failed, TRUE if already present and unchanged or successful
*/
	function insert(&$socialnet_friendpetition, $force = false) {
		Global $xoopsConfig;
		if (get_class($socialnet_friendpetition) != 'socialnet_friendpetition') {
				return false;
		}
		if (!$socialnet_friendpetition->isDirty()) {
				return true;
		}
		if (!$socialnet_friendpetition->cleanVars()) {
				return false;
		}
		foreach ($socialnet_friendpetition->cleanVars as $k => $v) {
				${$k} = $v;
		}
		$now = "date_add(now(), interval ".$xoopsConfig['server_TZ']." hour)";
		if ($socialnet_friendpetition->isNew()) {
			// ajout/modification d'un socialnet_friendpetition
			$socialnet_friendpetition = new socialnet_friendpetition();
			$format = "INSERT INTO %s (friendpet_id, petitioner_uid, petioned_uid)";
			$format .= "VALUES (%u, %u, %u)";
			$sql = sprintf($format , 
			$this->db->prefix('socialnet_friendpetition'), 
			$friendpet_id
			,$petitioner_uid
			,$petioned_uid
			);
			$force = true;
		} else {
			$format = "UPDATE %s SET ";
			$format .="friendpet_id=%u, petitioner_uid=%u, petioned_uid=%u";
			$format .=" WHERE friendpet_id = %u";
			$sql = sprintf($format, $this->db->prefix('socialnet_friendpetition'),
			$friendpet_id
			,$petitioner_uid
			,$petioned_uid
			, $friendpet_id);
		}
		if (false != $force) {
			$result = $this->db->queryF($sql);
		} else {
			$result = $this->db->query($sql);
		}
		if (!$result) {
			return false;
		}
		if (empty($friendpet_id)) {
			$friendpet_id = $this->db->getInsertId();
		}
		$socialnet_friendpetition->assignVar('friendpet_id', $friendpet_id);
		return true;
	}

	/**
	 * delete a socialnet_friendpetition from the database
	 * 
	 * @param object $socialnet_friendpetition reference to the socialnet_friendpetition to delete
	 * @param bool $force
	 * @return bool FALSE if failed.
	 */
	function delete(&$socialnet_friendpetition, $force = false)
	{
		if (get_class($socialnet_friendpetition) != 'socialnet_friendpetition') {
			return false;
		}
		$sql = sprintf("DELETE FROM %s WHERE friendpet_id = %u", $this->db->prefix("socialnet_friendpetition"), $socialnet_friendpetition->getVar('friendpet_id'));
		if (false != $force) {
			$result = $this->db->queryF($sql);
		} else {
			$result = $this->db->query($sql);
		}
		if (!$result) {
			return false;
		}
		return true;
	}

	/**
	* retrieve socialnet_friendpetitions from the database
	* 
	* @param object $criteria {@link CriteriaElement} conditions to be met
	* @param bool $id_as_key use the UID as key for the array?
	* @return array array of {@link socialnet_friendpetition} objects
	*/
	function &getObjects($criteria = null, $id_as_key = false)
	{
		$ret = array();
		$limit = $start = 0;
		$sql = 'SELECT * FROM '.$this->db->prefix('socialnet_friendpetition');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		if ($criteria->getSort() != '') {
			$sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
		}
		$limit = $criteria->getLimit();
		$start = $criteria->getStart();
		}
		$result = $this->db->query($sql, $limit, $start);
		if (!$result) {
			return $ret;
		}
		while ($myrow = $this->db->fetchArray($result)) {
			$socialnet_friendpetition = new socialnet_friendpetition();
			$socialnet_friendpetition->assignVars($myrow);
			if (!$id_as_key) {
				$ret[] =& $socialnet_friendpetition;
			} else {
				$ret[$myrow['friendpet_id']] =& $socialnet_friendpetition;
			}
			unset($socialnet_friendpetition);
		}
		return $ret;
	}

	/**
	* count socialnet_friendpetitions matching a condition
	* 
	* @param object $criteria {@link CriteriaElement} to match
	* @return int count of socialnet_friendpetitions
	*/
	function getCount($criteria = null)
	{
		$sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('socialnet_friendpetition');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		$result = $this->db->query($sql);
		if (!$result) {
			return 0;
		}
		list($count) = $this->db->fetchRow($result);
		return $count;
	} 

	/**
	* delete socialnet_friendpetitions matching a set of conditions
	* 
	* @param object $criteria {@link CriteriaElement} 
	* @return bool FALSE if deletion failed
	*/
	function deleteAll($criteria = null)
	{
		$sql = 'DELETE FROM '.$this->db->prefix('socialnet_friendpetition');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		if (!$result = $this->db->query($sql)) {
			return false;
		}
		return true;
	}
}


?>
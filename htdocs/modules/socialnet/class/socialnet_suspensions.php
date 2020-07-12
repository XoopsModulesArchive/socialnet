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
* socialnet_suspensions class.  
* $this class is responsible for providing data access mechanisms to the data source 
* of XOOPS user class objects.
*/


class socialnet_suspensions extends XoopsObject
{ 
	var $db;

// constructor
	function socialnet_suspensions ($id=null)
	{
		$this->db =& Database::getInstance();
		$this->initVar("uid",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("old_pass",XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar("old_email",XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar("old_signature",XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar("suspension_time",XOBJ_DTYPE_INT,null,false,10);
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
		$sql = 'SELECT * FROM '.$this->db->prefix("socialnet_suspensions").' WHERE uid='.$id;
		$myrow = $this->db->fetchArray($this->db->query($sql));
		$this->assignVars($myrow);
		if (!$myrow) {
			$this->setNew();
		}
	}

	function getAllsocialnet_suspensionss($criteria=array(), $asobject=false, $sort="uid", $order="ASC", $limit=0, $start=0)
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
			$sql = "SELECT uid FROM ".$db->prefix("socialnet_suspensions")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = $myrow['socialnet_suspensions_id'];
			}
		} else {
			$sql = "SELECT * FROM ".$db->prefix("socialnet_suspensions")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = new socialnet_suspensions ($myrow);
			}
		}
		return $ret;
	}
}
// -------------------------------------------------------------------------
// ------------------socialnet_suspensions user handler class -------------------
// -------------------------------------------------------------------------
/**
* socialnet_suspensionshandler class.  
* This class provides simple mecanisme for socialnet_suspensions object
*/

class Xoopssocialnet_suspensionsHandler extends XoopsObjectHandler
{

	/**
	* create a new socialnet_suspensions
	* 
	* @param bool $isNew flag the new objects as "new"?
	* @return object socialnet_suspensions
	*/
	function &create($isNew = true)	{
		$socialnet_suspensions = new socialnet_suspensions();
		if ($isNew) {
			$socialnet_suspensions->setNew();
		}
		else{
		$socialnet_suspensions->unsetNew();
		}

		
		return $socialnet_suspensions;
	}

	/**
	* retrieve a socialnet_suspensions
	* 
	* @param int $id of the socialnet_suspensions
	* @return mixed reference to the {@link socialnet_suspensions} object, FALSE if failed
	*/
	function &get($id)	{
			$sql = 'SELECT * FROM '.$this->db->prefix('socialnet_suspensions').' WHERE uid='.$id;
			if (!$result = $this->db->query($sql)) {
				return false;
			}
			$numrows = $this->db->getRowsNum($result);
			if ($numrows == 1) {
				$socialnet_suspensions = new socialnet_suspensions();
				$socialnet_suspensions->assignVars($this->db->fetchArray($result));
				return $socialnet_suspensions;
			}
				return false;
	}

/**
* insert a new socialnet_suspensions in the database
* 
* @param object $socialnet_suspensions reference to the {@link socialnet_suspensions} object
* @param bool $force
* @return bool FALSE if failed, TRUE if already present and unchanged or successful
*/
	function insert(&$socialnet_suspensions, $force = false) {
		Global $xoopsConfig;
		if (get_class($socialnet_suspensions) != 'socialnet_suspensions') {
				return false;
		}
		if (!$socialnet_suspensions->isDirty()) {
				return true;
		}
		if (!$socialnet_suspensions->cleanVars()) {
				return false;
		}
		foreach ($socialnet_suspensions->cleanVars as $k => $v) {
				${$k} = $v;
		}
		$now = "date_add(now(), interval ".$xoopsConfig['server_TZ']." hour)";
		if ($socialnet_suspensions->isNew()) {
			// ajout/modification d'un socialnet_suspensions
			$socialnet_suspensions = new socialnet_suspensions();
			$format = "INSERT INTO %s (uid, old_pass, old_email, old_signature, suspension_time)";
			$format .= "VALUES (%u, %s, %s, %s, %u)";
			$sql = sprintf($format , 
			$this->db->prefix('socialnet_suspensions'), 
			$uid
			,$this->db->quoteString($old_pass)
			,$this->db->quoteString($old_email)
			,$this->db->quoteString($old_signature)
			,$suspension_time
			);
			$force = true;
		} else {
			$format = "UPDATE %s SET ";
			$format .="uid=%u, old_pass=%s, old_email=%s, old_signature=%s, suspension_time=%u";
			$format .=" WHERE uid = %u";
			$sql = sprintf($format, $this->db->prefix('socialnet_suspensions'),
			$uid
			,$this->db->quoteString($old_pass)
			,$this->db->quoteString($old_email)
			,$this->db->quoteString($old_signature)
			,$suspension_time
			, $uid);
		}
		if (false != $force) {
			$result = $this->db->queryF($sql);
		} else {
			$result = $this->db->query($sql);
		}
		if (!$result) {
			return false;
		}
		if (empty($uid)) {
			$uid = $this->db->getInsertId();
		}
		$socialnet_suspensions->assignVar('uid', $uid);
		return true;
	}

	/**
	 * delete a socialnet_suspensions from the database
	 * 
	 * @param object $socialnet_suspensions reference to the socialnet_suspensions to delete
	 * @param bool $force
	 * @return bool FALSE if failed.
	 */
	function delete(&$socialnet_suspensions, $force = false)
	{
		if (get_class($socialnet_suspensions) != 'socialnet_suspensions') {
			return false;
		}
		$sql = sprintf("DELETE FROM %s WHERE uid = %u", $this->db->prefix("socialnet_suspensions"), $socialnet_suspensions->getVar('uid'));
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
	* retrieve socialnet_suspensionss from the database
	* 
	* @param object $criteria {@link CriteriaElement} conditions to be met
	* @param bool $id_as_key use the UID as key for the array?
	* @return array array of {@link socialnet_suspensions} objects
	*/
	function &getObjects($criteria = null, $id_as_key = false)
	{
		$ret = array();
		$limit = $start = 0;
		$sql = 'SELECT * FROM '.$this->db->prefix('socialnet_suspensions');
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
			$socialnet_suspensions = new socialnet_suspensions();
			$socialnet_suspensions->assignVars($myrow);
			if (!$id_as_key) {
				$ret[] =& $socialnet_suspensions;
			} else {
				$ret[$myrow['uid']] =& $socialnet_suspensions;
			}
			unset($socialnet_suspensions);
		}
		return $ret;
	}

	/**
	* count socialnet_suspensionss matching a condition
	* 
	* @param object $criteria {@link CriteriaElement} to match
	* @return int count of socialnet_suspensionss
	*/
	function getCount($criteria = null)
	{
		$sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('socialnet_suspensions');
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
	* delete socialnet_suspensionss matching a set of conditions
	* 
	* @param object $criteria {@link CriteriaElement} 
	* @return bool FALSE if deletion failed
	*/
	function deleteAll($criteria = null)
	{
		$sql = 'DELETE FROM '.$this->db->prefix('socialnet_suspensions');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		if (!$result = $this->db->queryF($sql)) {
			return false;
		}
		return true;
	}
}


?>
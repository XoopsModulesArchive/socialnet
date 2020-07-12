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
* socialnet_visitors class.  
* $this class is responsible for providing data access mechanisms to the data source 
* of XOOPS user class objects.
*/


class socialnet_visitors extends XoopsObject
{ 
	var $db;

// constructor
	function socialnet_visitors ($id=null)
	{
		$this->db =& Database::getInstance();
		$this->initVar("cod_visit",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("uid_owner",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("uid_visitor",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("uname_visitor",XOBJ_DTYPE_TXTBOX, null, false);
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
		$sql = 'SELECT * FROM '.$this->db->prefix("socialnet_visitors").' WHERE cod_visit='.$id;
		$myrow = $this->db->fetchArray($this->db->query($sql));
		$this->assignVars($myrow);
		if (!$myrow) {
			$this->setNew();
		}
	}

	function getAllsocialnet_visitorss($criteria=array(), $asobject=false, $sort="cod_visit", $order="ASC", $limit=0, $start=0)
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
			$sql = "SELECT cod_visit FROM ".$db->prefix("socialnet_visitors")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = $myrow['socialnet_visitors_id'];
			}
		} else {
			$sql = "SELECT * FROM ".$db->prefix("socialnet_visitors")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = new socialnet_visitors ($myrow);
			}
		}
		return $ret;
	}
}
// -------------------------------------------------------------------------
// ------------------socialnet_visitors user handler class -------------------
// -------------------------------------------------------------------------
/**
* socialnet_visitorshandler class.  
* This class provides simple mecanisme for socialnet_visitors object
*/

class Xoopssocialnet_visitorsHandler extends XoopsObjectHandler
{

	/**
	* create a new socialnet_visitors
	* 
	* @param bool $isNew flag the new objects as "new"?
	* @return object socialnet_visitors
	*/
	function &create($isNew = true)	{
		$socialnet_visitors = new socialnet_visitors();
		if ($isNew) {
			$socialnet_visitors->setNew();
		}
		else{
		$socialnet_visitors->unsetNew();
		}

		
		return $socialnet_visitors;
	}

	/**
	* retrieve a socialnet_visitors
	* 
	* @param int $id of the socialnet_visitors
	* @return mixed reference to the {@link socialnet_visitors} object, FALSE if failed
	*/
	function &get($id)	{
			$sql = 'SELECT * FROM '.$this->db->prefix('socialnet_visitors').' WHERE cod_visit='.$id;
			if (!$result = $this->db->query($sql)) {
				return false;
			}
			$numrows = $this->db->getRowsNum($result);
			if ($numrows == 1) {
				$socialnet_visitors = new socialnet_visitors();
				$socialnet_visitors->assignVars($this->db->fetchArray($result));
				return $socialnet_visitors;
			}
				return false;
	}

/**
* insert a new socialnet_visitors in the database
* 
* @param object $socialnet_visitors reference to the {@link socialnet_visitors} object
* @param bool $force
* @return bool FALSE if failed, TRUE if already present and unchanged or successful
*/
	function insert(&$socialnet_visitors, $force = false) {
		Global $xoopsConfig;
		if (get_class($socialnet_visitors) != 'socialnet_visitors') {
				return false;
		}
		if (!$socialnet_visitors->isDirty()) {
				return true;
		}
		if (!$socialnet_visitors->cleanVars()) {
				return false;
		}
		foreach ($socialnet_visitors->cleanVars as $k => $v) {
				${$k} = $v;
		}
		$now = "date_add(now(), interval ".$xoopsConfig['server_TZ']." hour)";
		if ($socialnet_visitors->isNew()) {
			// ajout/modification d'un socialnet_visitors
			$socialnet_visitors = new socialnet_visitors();
			$format = "INSERT INTO %s (cod_visit, uid_owner, uid_visitor,uname_visitor)";
			$format .= "VALUES (%u, %u, %u, %s)";
			$sql = sprintf($format , 
			$this->db->prefix('socialnet_visitors'), 
			$cod_visit
			,$uid_owner
			,$uid_visitor
			,$this->db->quoteString($uname_visitor)
			);
			$force = true;
		} else {
			$format = "UPDATE %s SET ";
			$format .="cod_visit=%u, uid_owner=%u, uid_visitor=%u, uname_visitor=%s ";
			$format .=" WHERE cod_visit = %u";
			$sql = sprintf($format, $this->db->prefix('socialnet_visitors'),
			$cod_visit
			,$uid_owner
			,$uid_visitor
			,$this->db->quoteString($uname_visitor)
			, $cod_visit);
		}
		if (false != $force) {
			$result = $this->db->queryF($sql);
		} else {
			$result = $this->db->query($sql);
		}
		if (!$result) {
			return false;
		}
		if (empty($cod_visit)) {
			$cod_visit = $this->db->getInsertId();
		}
		$socialnet_visitors->assignVar('cod_visit', $cod_visit);
		return true;
	}

	/**
	 * delete a socialnet_visitors from the database
	 * 
	 * @param object $socialnet_visitors reference to the socialnet_visitors to delete
	 * @param bool $force
	 * @return bool FALSE if failed.
	 */
	function delete(&$socialnet_visitors, $force = false)
	{
		if (get_class($socialnet_visitors) != 'socialnet_visitors') {
			return false;
		}
		$sql = sprintf("DELETE FROM %s WHERE cod_visit = %u", $this->db->prefix("socialnet_visitors"), $socialnet_visitors->getVar('cod_visit'));
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
	* retrieve socialnet_visitorss from the database
	* 
	* @param object $criteria {@link CriteriaElement} conditions to be met
	* @param bool $id_as_key use the UID as key for the array?
	* @return array array of {@link socialnet_visitors} objects
	*/
	function &getObjects($criteria = null, $id_as_key = false)
	{
		$ret = array();
		$limit = $start = 0;
		$sql = 'SELECT * FROM '.$this->db->prefix('socialnet_visitors');
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
			$socialnet_visitors = new socialnet_visitors();
			$socialnet_visitors->assignVars($myrow);
			if (!$id_as_key) {
				$ret[] =& $socialnet_visitors;
			} else {
				$ret[$myrow['cod_visit']] =& $socialnet_visitors;
			}
			unset($socialnet_visitors);
		}
		return $ret;
	}

	/**
	* count socialnet_visitorss matching a condition
	* 
	* @param object $criteria {@link CriteriaElement} to match
	* @return int count of socialnet_visitorss
	*/
	function getCount($criteria = null)
	{
		$sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('socialnet_visitors');
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
	* delete socialnet_visitorss matching a set of conditions
	* 
	* @param object $criteria {@link CriteriaElement} 
	* @return bool FALSE if deletion failed
	*/
	function deleteAll($criteria = null, $force=false)
	{
		$sql = 'DELETE FROM '.$this->db->prefix('socialnet_visitors');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		if (false != $force) {
			if (!$result = $this->db->queryF($sql)) {
			return false;
		};
		} else {
			if (!$result = $this->db->query($sql)) {
			return false;
		}
		}
		
		return true;
	}
	
	function purgeVisits(){
		
		$sql = 'DELETE FROM '.$this->db->prefix('socialnet_visitors').' WHERE (datetime<(DATE_SUB(NOW(), INTERVAL 7 DAY))) ';

			if (!$result = $this->db->queryF($sql)) {
			return false;
		}
		
		
		return true;
		
	}
}


?>
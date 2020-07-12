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


if (!defined('XOOPS_ROOT_PATH')){ exit(); }
include_once XOOPS_ROOT_PATH."/class/xoopsobject.php";



/**
* socialnet_ishot class.  
* $this class is responsible for providing data access mechanisms to the data source 
* of XOOPS user class objects.
*/


class socialnet_ishot extends XoopsObject
{ 
	var $db;

// constructor
	function socialnet_ishot ($id=null)
	{
		$this->db =& Database::getInstance();
		$this->initVar("cod_ishot",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("uid_voter",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("uid_voted",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("ishot",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("date",XOBJ_DTYPE_TXTBOX, null, false);
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
		$sql = 'SELECT * FROM '.$this->db->prefix("socialnet_ishot").' WHERE cod_ishot='.$id;
		$myrow = $this->db->fetchArray($this->db->query($sql));
		$this->assignVars($myrow);
		if (!$myrow) {
			$this->setNew();
		}
	}

	function getAllsocialnet_ishots($criteria=array(), $asobject=false, $sort="cod_ishot", $order="ASC", $limit=0, $start=0)
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
			$sql = "SELECT cod_ishot FROM ".$db->prefix("socialnet_ishot")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = $myrow['socialnet_ishot_id'];
			}
		} else {
			$sql = "SELECT * FROM ".$db->prefix("socialnet_ishot")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = new socialnet_ishot ($myrow);
			}
		}
		return $ret;
	}
}
// -------------------------------------------------------------------------
// ------------------socialnet_ishot user handler class -------------------
// -------------------------------------------------------------------------
/**
* socialnet_ishothandler class.  
* This class provides simple mecanisme for socialnet_ishot object
*/

class Xoopssocialnet_ishotHandler extends XoopsObjectHandler
{

	/**
	* create a new socialnet_ishot
	* 
	* @param bool $isNew flag the new objects as "new"?
	* @return object socialnet_ishot
	*/
	function &create($isNew = true)	{
		$socialnet_ishot = new socialnet_ishot();
		if ($isNew) {
			$socialnet_ishot->setNew();
		}
		else{
		$socialnet_ishot->unsetNew();
		}

		
		return $socialnet_ishot;
	}

	/**
	* retrieve a socialnet_ishot
	* 
	* @param int $id of the socialnet_ishot
	* @return mixed reference to the {@link socialnet_ishot} object, FALSE if failed
	*/
	function &get($id)	{
			$sql = 'SELECT * FROM '.$this->db->prefix('socialnet_ishot').' WHERE cod_ishot='.$id;
			if (!$result = $this->db->query($sql)) {
				return false;
			}
			$numrows = $this->db->getRowsNum($result);
			if ($numrows == 1) {
				$socialnet_ishot = new socialnet_ishot();
				$socialnet_ishot->assignVars($this->db->fetchArray($result));
				return $socialnet_ishot;
			}
				return false;
	}

/**
* insert a new socialnet_ishot in the database
* 
* @param object $socialnet_ishot reference to the {@link socialnet_ishot} object
* @param bool $force
* @return bool FALSE if failed, TRUE if already present and unchanged or successful
*/
	function insert(&$socialnet_ishot, $force = false) {
		Global $xoopsConfig;
		if (get_class($socialnet_ishot) != 'socialnet_ishot') {
				return false;
		}
		if (!$socialnet_ishot->isDirty()) {
				return true;
		}
		if (!$socialnet_ishot->cleanVars()) {
				return false;
		}
		foreach ($socialnet_ishot->cleanVars as $k => $v) {
				${$k} = $v;
		}
		$now = "date_add(now(), interval ".$xoopsConfig['server_TZ']." hour)";
		if ($socialnet_ishot->isNew()) {
			// ajout/modification d'un socialnet_ishot
			$socialnet_ishot = new socialnet_ishot();
			$format = "INSERT INTO %s (cod_ishot, uid_voter, uid_voted, ishot, date)";
			$format .= "VALUES (%u, %u, %u, %u, %s)";
			$sql = sprintf($format , 
			$this->db->prefix('socialnet_ishot'), 
			$cod_ishot
			,$uid_voter
			,$uid_voted
			,$ishot
			,$this->db->quoteString($date)
			);
			$force = true;
		} else {
			$format = "UPDATE %s SET ";
			$format .="cod_ishot=%u, uid_voter=%u, uid_voted=%u, ishot=%u, date=%s";
			$format .=" WHERE cod_ishot = %u";
			$sql = sprintf($format, $this->db->prefix('socialnet_ishot'),
			$cod_ishot
			,$uid_voter
			,$uid_voted
			,$ishot
			,$this->db->quoteString($date)
			, $cod_ishot);
		}
		if (false != $force) {
			$result = $this->db->queryF($sql);
		} else {
			$result = $this->db->query($sql);
		}
		if (!$result) {
			return false;
		}
		if (empty($cod_ishot)) {
			$cod_ishot = $this->db->getInsertId();
		}
		$socialnet_ishot->assignVar('cod_ishot', $cod_ishot);
		return true;
	}

	/**
	 * delete a socialnet_ishot from the database
	 * 
	 * @param object $socialnet_ishot reference to the socialnet_ishot to delete
	 * @param bool $force
	 * @return bool FALSE if failed.
	 */
	function delete(&$socialnet_ishot, $force = false)
	{
		if (get_class($socialnet_ishot) != 'socialnet_ishot') {
			return false;
		}
		$sql = sprintf("DELETE FROM %s WHERE cod_ishot = %u", $this->db->prefix("socialnet_ishot"), $socialnet_ishot->getVar('cod_ishot'));
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
	* retrieve socialnet_ishots from the database
	* 
	* @param object $criteria {@link CriteriaElement} conditions to be met
	* @param bool $id_as_key use the UID as key for the array?
	* @return array array of {@link socialnet_ishot} objects
	*/
	function &getObjects($criteria = null, $id_as_key = false)
	{
		$ret = array();
		$limit = $start = 0;
		$sql = 'SELECT * FROM '.$this->db->prefix('socialnet_ishot');
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
			$socialnet_ishot = new socialnet_ishot();
			$socialnet_ishot->assignVars($myrow);
			if (!$id_as_key) {
				$ret[] =& $socialnet_ishot;
			} else {
				$ret[$myrow['cod_ishot']] =& $socialnet_ishot;
			}
			unset($socialnet_ishot);
		}
		return $ret;
	}

	/**
	* count socialnet_ishots matching a condition
	* 
	* @param object $criteria {@link CriteriaElement} to match
	* @return int count of socialnet_ishots
	*/
	function getCount($criteria = null)
	{
		$sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('socialnet_ishot');
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
	* delete socialnet_ishots matching a set of conditions
	* 
	* @param object $criteria {@link CriteriaElement} 
	* @return bool FALSE if deletion failed
	*/
	function deleteAll($criteria = null)
	{
		$sql = 'DELETE FROM '.$this->db->prefix('socialnet_ishot');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		if (!$result = $this->db->query($sql)) {
			return false;
		}
		return true;
	}

	function getHottest($criteria = null)
	{


		$sql = 'SELECT DISTINCTROW uname, user_avatar, uid_voted, COUNT(cod_ishot) AS qtd FROM '.$this->db->prefix('socialnet_ishot').', '.$this->db->prefix('users');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		//attention here this is kind of a hack
		$sql .= " AND uid = uid_voted";
		if ($criteria->getGroupby() != '') {
			$sql .= $criteria->getGroupby();
		}
		if ($criteria->getSort() != '') {
			$sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
		}
		$limit = $criteria->getLimit();
		$start = $criteria->getStart();
		
		$result = $this->db->query($sql, $limit, $start);
		$vetor = array();
		$i=0;
		while ($myrow = $this->db->fetchArray($result)) {
			
			$vetor[$i]['qtd']= $myrow['qtd'];
			$vetor[$i]['uid_voted']= $myrow['uid_voted'];
			$vetor[$i]['uname']= $myrow['uname'];
			$vetor[$i]['user_avatar']= $myrow['user_avatar'];
			$i++;
		}
		
		
		return $vetor;
	} 

function getHotFriends($criteria = null, $id_as_key = false)
	{
		$ret = array();
		$limit = $start = 0;
		$sql = 'SELECT uname, user_avatar, uid_voted FROM '.$this->db->prefix('socialnet_ishot').', '.$this->db->prefix('users');;
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		//attention here this is kind of a hack
		$sql .= " AND uid = uid_voted AND ishot=1" ;
		if ($criteria->getSort() != '') {
			$sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
		}
		$limit = $criteria->getLimit();
		$start = $criteria->getStart();
		
		$result = $this->db->query($sql, $limit, $start);
		$vetor = array();
		$i=0;
		while ($myrow = $this->db->fetchArray($result)) {
			
			$vetor[$i]['uid_voted']= $myrow['uid_voted'];
			$vetor[$i]['uname']= $myrow['uname'];
			$vetor[$i]['user_avatar']= $myrow['user_avatar'];
			$i++;
		}
		
		
		return $vetor;

		}
	}
}


?>
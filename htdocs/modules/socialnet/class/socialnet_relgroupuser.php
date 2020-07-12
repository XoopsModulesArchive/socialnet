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
* socialnet_relgroupuser class.  
* $this class is responsible for providing data access mechanisms to the data source 
* of XOOPS user class objects.
*/


class socialnet_relgroupuser extends XoopsObject
{ 
	var $db;

// constructor
	function socialnet_relgroupuser ($id=null)
	{
		$this->db =& Database::getInstance();
		$this->initVar("rel_id",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("rel_group_id",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("rel_user_uid",XOBJ_DTYPE_INT,null,false,10);
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
		$sql = 'SELECT * FROM '.$this->db->prefix("socialnet_relgroupuser").' WHERE rel_id='.$id;
		$myrow = $this->db->fetchArray($this->db->query($sql));
		$this->assignVars($myrow);
		if (!$myrow) {
			$this->setNew();
		}
	}

	function getAllsocialnet_relgroupusers($criteria=array(), $asobject=false, $sort="rel_id", $order="ASC", $limit=0, $start=0)
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
			$sql = "SELECT rel_id FROM ".$db->prefix("socialnet_relgroupuser")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = $myrow['socialnet_relgroupuser_id'];
			}
		} else {
			$sql = "SELECT * FROM ".$db->prefix("socialnet_relgroupuser")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = new socialnet_relgroupuser ($myrow);
			}
		}
		return $ret;
	}
}
// -------------------------------------------------------------------------
// ------------------socialnet_relgroupuser user handler class -------------------
// -------------------------------------------------------------------------
/**
* socialnet_relgroupuserhandler class.  
* This class provides simple mecanisme for socialnet_relgroupuser object
*/

class Xoopssocialnet_relgroupuserHandler extends XoopsObjectHandler
{

	/**
	* create a new socialnet_relgroupuser
	* 
	* @param bool $isNew flag the new objects as "new"?
	* @return object socialnet_relgroupuser
	*/
	function &create($isNew = true)	{
		$socialnet_relgroupuser = new socialnet_relgroupuser();
		if ($isNew) {
			$socialnet_relgroupuser->setNew();
		}
		else{
		$socialnet_relgroupuser->unsetNew();
		}

		
		return $socialnet_relgroupuser;
	}

	/**
	* retrieve a socialnet_relgroupuser
	* 
	* @param int $id of the socialnet_relgroupuser
	* @return mixed reference to the {@link socialnet_relgroupuser} object, FALSE if failed
	*/
	function &get($id)	{
			$sql = 'SELECT * FROM '.$this->db->prefix('socialnet_relgroupuser').' WHERE rel_id='.$id;
			if (!$result = $this->db->query($sql)) {
				return false;
			}
			$numrows = $this->db->getRowsNum($result);
			if ($numrows == 1) {
				$socialnet_relgroupuser = new socialnet_relgroupuser();
				$socialnet_relgroupuser->assignVars($this->db->fetchArray($result));
				return $socialnet_relgroupuser;
			}
				return false;
	}

/**
* insert a new socialnet_relgroupuser in the database
* 
* @param object $socialnet_relgroupuser reference to the {@link socialnet_relgroupuser} object
* @param bool $force
* @return bool FALSE if failed, TRUE if already present and unchanged or successful
*/
	function insert(&$socialnet_relgroupuser, $force = false) {
		Global $xoopsConfig;
		if (get_class($socialnet_relgroupuser) != 'socialnet_relgroupuser') {
				return false;
		}
		if (!$socialnet_relgroupuser->isDirty()) {
				return true;
		}
		if (!$socialnet_relgroupuser->cleanVars()) {
				return false;
		}
		foreach ($socialnet_relgroupuser->cleanVars as $k => $v) {
				${$k} = $v;
		}
		$now = "date_add(now(), interval ".$xoopsConfig['server_TZ']." hour)";
		if ($socialnet_relgroupuser->isNew()) {
			// ajout/modification d'un socialnet_relgroupuser
			$socialnet_relgroupuser = new socialnet_relgroupuser();
			$format = "INSERT INTO %s (rel_id, rel_group_id, rel_user_uid)";
			$format .= "VALUES (%u, %u, %u)";
			$sql = sprintf($format , 
			$this->db->prefix('socialnet_relgroupuser'), 
			$rel_id
			,$rel_group_id
			,$rel_user_uid
			);
			$force = true;
		} else {
			$format = "UPDATE %s SET ";
			$format .="rel_id=%u, rel_group_id=%u, rel_user_uid=%u";
			$format .=" WHERE rel_id = %u";
			$sql = sprintf($format, $this->db->prefix('socialnet_relgroupuser'),
			$rel_id
			,$rel_group_id
			,$rel_user_uid
			, $rel_id);
		}
		if (false != $force) {
			$result = $this->db->queryF($sql);
		} else {
			$result = $this->db->query($sql);
		}
		if (!$result) {
			return false;
		}
		if (empty($rel_id)) {
			$rel_id = $this->db->getInsertId();
		}
		$socialnet_relgroupuser->assignVar('rel_id', $rel_id);
		return true;
	}

	/**
	 * delete a socialnet_relgroupuser from the database
	 * 
	 * @param object $socialnet_relgroupuser reference to the socialnet_relgroupuser to delete
	 * @param bool $force
	 * @return bool FALSE if failed.
	 */
	function delete(&$socialnet_relgroupuser, $force = false)
	{
		if (get_class($socialnet_relgroupuser) != 'socialnet_relgroupuser') {
			return false;
		}
		$sql = sprintf("DELETE FROM %s WHERE rel_id = %u", $this->db->prefix("socialnet_relgroupuser"), $socialnet_relgroupuser->getVar('rel_id'));
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
	* retrieve socialnet_relgroupusers from the database
	* 
	* @param object $criteria {@link CriteriaElement} conditions to be met
	* @param bool $id_as_key use the UID as key for the array?
	* @return array array of {@link socialnet_relgroupuser} objects
	*/
	function &getObjects($criteria = null, $id_as_key = false)
	{
		$ret = array();
		$limit = $start = 0;
		$sql = 'SELECT * FROM '.$this->db->prefix('socialnet_relgroupuser');
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
			$socialnet_relgroupuser = new socialnet_relgroupuser();
			$socialnet_relgroupuser->assignVars($myrow);
			if (!$id_as_key) {
				$ret[] =& $socialnet_relgroupuser;
			} else {
				$ret[$myrow['rel_id']] =& $socialnet_relgroupuser;
			}
			unset($socialnet_relgroupuser);
		}
		return $ret;
	}

	/**
	* count socialnet_relgroupusers matching a condition
	* 
	* @param object $criteria {@link CriteriaElement} to match
	* @return int count of socialnet_relgroupusers
	*/
	function getCount($criteria = null)
	{
		$sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('socialnet_relgroupuser');
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
	* delete socialnet_relgroupusers matching a set of conditions
	* 
	* @param object $criteria {@link CriteriaElement} 
	* @return bool FALSE if deletion failed
	*/
	function deleteAll($criteria = null)
	{
		$sql = 'DELETE FROM '.$this->db->prefix('socialnet_relgroupuser');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		if (!$result = $this->db->query($sql)) {
			return false;
		}
		return true;
	}
	
	function getGroups($nbgroups, $criteria = null, $shuffle=1)
	{
		$ret = array();
		
		$sql = 'SELECT rel_id, rel_group_id, rel_user_uid, group_title, group_desc, group_img, owner_uid FROM '.$this->db->prefix('socialnet_groups').', '.$this->db->prefix('socialnet_relgroupuser');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
			//attention here this is kind of a hack
			$sql .= " AND group_id = rel_group_id " ;
			if ($criteria->getSort() != '') {
				$sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
			}
			$limit = $criteria->getLimit();
			$start = $criteria->getStart();

			$result = $this->db->query($sql, $limit, $start);
			$vetor = array();
			$i=0;

			while ($myrow = $this->db->fetchArray($result)) {

				$vetor[$i]['title']	= $myrow['group_title'];
				$vetor[$i]['desc']	= $myrow['group_desc'];
				$vetor[$i]['img']	= $myrow['group_img'];
				$vetor[$i]['id']	= $myrow['rel_id'];
				$vetor[$i]['uid']	= $myrow['owner_uid'];
				$vetor[$i]['group_id']	= $myrow['rel_group_id'];
				
				$i++;
			}

			if ($shuffle==1){
				shuffle($vetor);
				$vetor = array_slice($vetor,0,$nbgroups);
			}
			return $vetor;

		}
	}
	
		function getUsersFromGroup($groupId,$start,$nbUsers,$isShuffle=0)
	{
		$ret = array();
		
		$sql = 'SELECT rel_group_id, rel_user_uid, owner_uid, uname, user_avatar, uid FROM '.$this->db->prefix('users').', '.$this->db->prefix('socialnet_groups').', '.$this->db->prefix('socialnet_relgroupuser');
		$sql .= " WHERE rel_user_uid = uid AND rel_group_id = group_id AND group_id =".$groupId." GROUP BY rel_user_uid " ;
			

			$result = $this->db->query($sql, $nbUsers, $start);
			$ret = array();
			$i=0;

			while ($myrow = $this->db->fetchArray($result)) {

				$ret[$i]['uid']	= $myrow['uid'];
				$ret[$i]['uname']	= $myrow['uname'];
				$ret[$i]['avatar']	= $myrow['user_avatar'];
				$isOwner = ($myrow['rel_user_uid']==$myrow['owner_uid'])?1:0;
				$ret[$i]['isOwner']	= $isOwner;
				$i++;
			}

			if ($isShuffle==1){
				shuffle($ret);
				$ret = array_slice($ret,0,$nbUsers);
			}
			
			return $ret;

		}
	
	
	
}


?>
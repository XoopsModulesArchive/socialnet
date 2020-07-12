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
* socialnet_configs class.  
* $this class is responsible for providing data access mechanisms to the data source 
* of XOOPS user class objects.
*/


class socialnet_configs extends XoopsObject
{ 
	var $db;

// constructor
	function socialnet_configs ($id=null)
	{
		$this->db =& Database::getInstance();
		$this->initVar("config_id",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("config_uid",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("pictures",XOBJ_DTYPE_INT,null,false,10);
        $this->initVar("audio",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("videos",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("groups",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("scraps",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("friends",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("profile_contact",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("profile_general",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("profile_stats",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("suspension",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("backup_password",XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar("backup_email",XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar("end_suspension",XOBJ_DTYPE_TXTBOX, null, false);
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
		$sql = 'SELECT * FROM '.$this->db->prefix("socialnet_configs").' WHERE config_id='.$id;
		$myrow = $this->db->fetchArray($this->db->query($sql));
		$this->assignVars($myrow);
		if (!$myrow) {
			$this->setNew();
		}
	}

	function getAllsocialnet_configss($criteria=array(), $asobject=false, $sort="config_id", $order="ASC", $limit=0, $start=0)
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
			$sql = "SELECT config_id FROM ".$db->prefix("socialnet_configs")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = $myrow['socialnet_configs_id'];
			}
		} else {
			$sql = "SELECT * FROM ".$db->prefix("socialnet_configs")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = new socialnet_configs ($myrow);
			}
		}
		return $ret;
	}
}
// -------------------------------------------------------------------------
// ------------------socialnet_configs user handler class -------------------
// -------------------------------------------------------------------------
/**
* socialnet_configshandler class.  
* This class provides simple mecanisme for socialnet_configs object
*/

class Xoopssocialnet_configsHandler extends XoopsObjectHandler
{

	/**
	* create a new socialnet_configs
	* 
	* @param bool $isNew flag the new objects as "new"?
	* @return object socialnet_configs
	*/
	function &create($isNew = true)	{
		$socialnet_configs = new socialnet_configs();
		if ($isNew) {
			$socialnet_configs->setNew();
		}
		else{
		$socialnet_configs->unsetNew();
		}

		
		return $socialnet_configs;
	}

	/**
	* retrieve a socialnet_configs
	* 
	* @param int $id of the socialnet_configs
	* @return mixed reference to the {@link socialnet_configs} object, FALSE if failed
	*/
	function &get($id)	{
			$sql = 'SELECT * FROM '.$this->db->prefix('socialnet_configs').' WHERE config_id='.$id;
			if (!$result = $this->db->query($sql)) {
				return false;
			}
			$numrows = $this->db->getRowsNum($result);
			if ($numrows == 1) {
				$socialnet_configs = new socialnet_configs();
				$socialnet_configs->assignVars($this->db->fetchArray($result));
				return $socialnet_configs;
			}
				return false;
	}

/**
* insert a new socialnet_configs in the database
* 
* @param object $socialnet_configs reference to the {@link socialnet_configs} object
* @param bool $force
* @return bool FALSE if failed, TRUE if already present and unchanged or successful
*/
	function insert(&$socialnet_configs, $force = false) {
		Global $xoopsConfig;
		if (get_class($socialnet_configs) != 'socialnet_configs') {
				return false;
		}
		if (!$socialnet_configs->isDirty()) {
				return true;
		}
		if (!$socialnet_configs->cleanVars()) {
				return false;
		}
		foreach ($socialnet_configs->cleanVars as $k => $v) {
				${$k} = $v;
		}
		$now = "date_add(now(), interval ".$xoopsConfig['server_TZ']." hour)";
		if ($socialnet_configs->isNew()) {
			// ajout/modification d'un socialnet_configs
			$socialnet_configs = new socialnet_configs();
			$format = "INSERT INTO %s (config_id, config_uid, pictures, audio, videos, groups, scraps, friends, profile_contact, profile_general, profile_stats, suspension, backup_password, backup_email, end_suspension)";
			$format .= "VALUES (%u, %u, %u, %u, %u, %u, %u, %u, %u, %u, %u, %u, %s, %s, %s)";
			$sql = sprintf($format , 
			$this->db->prefix('socialnet_configs'), 
			$config_id
			,$config_uid
			,$pictures
            ,$audio
			,$videos
			,$groups
			,$scraps
			,$friends
			,$profile_contact
			,$profile_general
			,$profile_stats
			,$suspension
			,$this->db->quoteString($backup_password)
			,$this->db->quoteString($backup_email)
			,$this->db->quoteString($end_suspension)
			);
			$force = true;
		} else {
			$format = "UPDATE %s SET ";
			$format .="config_id=%u, config_uid=%u, pictures=%u, audio=%u, videos=%u, groups=%u, scraps=%u, friends=%u, profile_contact=%u, profile_general=%u, profile_stats=%u, suspension=%u, backup_password=%s, backup_email=%s, end_suspension=%s";
			$format .=" WHERE config_id = %u";
			$sql = sprintf($format, $this->db->prefix('socialnet_configs'),
			$config_id
			,$config_uid
			,$pictures
            ,$audio
			,$videos
			,$groups
			,$scraps
			,$friends
			,$profile_contact
			,$profile_general
			,$profile_stats
			,$suspension
			,$this->db->quoteString($backup_password)
			,$this->db->quoteString($backup_email)
			,$this->db->quoteString($end_suspension)
			, $config_id);
		}
		if (false != $force) {
			$result = $this->db->queryF($sql);
		} else {
			$result = $this->db->query($sql);
		}
		if (!$result) {
			return false;
		}
		if (empty($config_id)) {
			$config_id = $this->db->getInsertId();
		}
		$socialnet_configs->assignVar('config_id', $config_id);
		return true;
	}

	/**
	 * delete a socialnet_configs from the database
	 * 
	 * @param object $socialnet_configs reference to the socialnet_configs to delete
	 * @param bool $force
	 * @return bool FALSE if failed.
	 */
	function delete(&$socialnet_configs, $force = false)
	{
		if (get_class($socialnet_configs) != 'socialnet_configs') {
			return false;
		}
		$sql = sprintf("DELETE FROM %s WHERE config_id = %u", $this->db->prefix("socialnet_configs"), $socialnet_configs->getVar('config_id'));
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
	* retrieve socialnet_configss from the database
	* 
	* @param object $criteria {@link CriteriaElement} conditions to be met
	* @param bool $id_as_key use the UID as key for the array?
	* @return array array of {@link socialnet_configs} objects
	*/
	function &getObjects($criteria = null, $id_as_key = false)
	{
		$ret = array();
		$limit = $start = 0;
		$sql = 'SELECT * FROM '.$this->db->prefix('socialnet_configs');
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
			$socialnet_configs = new socialnet_configs();
			$socialnet_configs->assignVars($myrow);
			if (!$id_as_key) {
				$ret[] =& $socialnet_configs;
			} else {
				$ret[$myrow['config_id']] =& $socialnet_configs;
			}
			unset($socialnet_configs);
		}
		return $ret;
	}

	/**
	* count socialnet_configss matching a condition
	* 
	* @param object $criteria {@link CriteriaElement} to match
	* @return int count of socialnet_configss
	*/
	function getCount($criteria = null)
	{
		$sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('socialnet_configs');
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
	* delete socialnet_configss matching a set of conditions
	* 
	* @param object $criteria {@link CriteriaElement} 
	* @return bool FALSE if deletion failed
	*/
	function deleteAll($criteria = null)
	{
		$sql = 'DELETE FROM '.$this->db->prefix('socialnet_configs');
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
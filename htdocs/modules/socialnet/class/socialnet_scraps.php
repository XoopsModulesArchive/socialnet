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
include_once XOOPS_ROOT_PATH."/class/module.textsanitizer.php";
/**
* socialnet_scraps class.  
* $this class is responsible for providing data access mechanisms to the data source 
* of XOOPS user class objects.
*/


class socialnet_scraps extends XoopsObject
{ 
	var $db;

// constructor
	function socialnet_scraps ($id=null)
	{
		$this->db =& Database::getInstance();
		$this->initVar("scrap_id",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("scrap_text",XOBJ_DTYPE_TXTAREA, null, false);
		$this->initVar("scrap_from",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("scrap_to",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("private",XOBJ_DTYPE_INT,null,false,10);
		
		
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
		$sql = 'SELECT * FROM '.$this->db->prefix("socialnet_scraps").' WHERE scrap_id='.$id;
		$myrow = $this->db->fetchArray($this->db->query($sql));
		$this->assignVars($myrow);
		if (!$myrow) {
			$this->setNew();
		}
	}

	function getAllsocialnet_scrapss($criteria=array(), $asobject=false, $sort="scrap_id", $order="ASC", $limit=0, $start=0)
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
			$sql = "SELECT scrap_id FROM ".$db->prefix("socialnet_scraps")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = $myrow['socialnet_scraps_id'];
			}
		} else {
			$sql = "SELECT * FROM ".$db->prefix("socialnet_scraps")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = new socialnet_scraps ($myrow);
			}
		}
		return $ret;
	}
}
// -------------------------------------------------------------------------
// ------------------socialnet_scraps user handler class -------------------
// -------------------------------------------------------------------------
/**
* socialnet_scrapshandler class.  
* This class provides simple mecanisme for socialnet_scraps object
*/

class Xoopssocialnet_scrapsHandler extends XoopsObjectHandler
{

	/**
	* create a new socialnet_scraps
	* 
	* @param bool $isNew flag the new objects as "new"?
	* @return object socialnet_scraps
	*/
	function &create($isNew = true)	{
		$socialnet_scraps = new socialnet_scraps();
		if ($isNew) {
			$socialnet_scraps->setNew();
		}
		else{
		$socialnet_scraps->unsetNew();
		}

		
		return $socialnet_scraps;
	}

	/**
	* retrieve a socialnet_scraps
	* 
	* @param int $id of the socialnet_scraps
	* @return mixed reference to the {@link socialnet_scraps} object, FALSE if failed
	*/
	function &get($id)	{
			$sql = 'SELECT * FROM '.$this->db->prefix('socialnet_scraps').' WHERE scrap_id='.$id;
			if (!$result = $this->db->query($sql)) {
				return false;
			}
			$numrows = $this->db->getRowsNum($result);
			if ($numrows == 1) {
				$socialnet_scraps = new socialnet_scraps();
				$socialnet_scraps->assignVars($this->db->fetchArray($result));
				return $socialnet_scraps;
			}
				return false;
	}

/**
* insert a new socialnet_scraps in the database
* 
* @param object $socialnet_scraps reference to the {@link socialnet_scraps} object
* @param bool $force
* @return bool FALSE if failed, TRUE if already present and unchanged or successful
*/
	function insert(&$socialnet_scraps, $force = false) {
		Global $xoopsConfig;
		if (get_class($socialnet_scraps) != 'socialnet_scraps') {
				return false;
		}
		if (!$socialnet_scraps->isDirty()) {
				return true;
		}
		if (!$socialnet_scraps->cleanVars()) {
				return false;
		}
		foreach ($socialnet_scraps->cleanVars as $k => $v) {
				${$k} = $v;
		}
		$now = "date_add(now(), interval ".$xoopsConfig['server_TZ']." hour)";
		if ($socialnet_scraps->isNew()) {
			// ajout/modification d'un socialnet_scraps
			$socialnet_scraps = new socialnet_scraps();
			$format = "INSERT INTO %s (scrap_id, scrap_text, scrap_from, scrap_to, private)";
			$format .= "VALUES (%u, %s, %u, %u, %u)";
			$sql = sprintf($format , 
			$this->db->prefix('socialnet_scraps'), 
			$scrap_id
			,$this->db->quoteString($scrap_text)
			,$scrap_from
			,$scrap_to
			,$private
			
			);
			$force = true;
		} else {
			$format = "UPDATE %s SET ";
			$format .="scrap_id=%u, scrap_text=%s, scrap_from=%u, scrap_to=%u, private=%u";
			$format .=" WHERE scrap_id = %u";
			$sql = sprintf($format, $this->db->prefix('socialnet_scraps'),
			$scrap_id
			,$this->db->quoteString($scrap_text)
			,$scrap_from
			,$scrap_to
			,$private
			
			, $scrap_id);
		}
		if (false != $force) {
			$result = $this->db->queryF($sql);
		} else {
			$result = $this->db->query($sql);
		}
		if (!$result) {
			return false;
		}
		if (empty($scrap_id)) {
			$scrap_id = $this->db->getInsertId();
		}
		$socialnet_scraps->assignVar('scrap_id', $scrap_id);
		return true;
	}

	/**
	 * delete a socialnet_scraps from the database
	 * 
	 * @param object $socialnet_scraps reference to the socialnet_scraps to delete
	 * @param bool $force
	 * @return bool FALSE if failed.
	 */
	function delete(&$socialnet_scraps, $force = false)
	{
		if (get_class($socialnet_scraps) != 'socialnet_scraps') {
			return false;
		}
		$sql = sprintf("DELETE FROM %s WHERE scrap_id = %u", $this->db->prefix("socialnet_scraps"), $socialnet_scraps->getVar('scrap_id'));
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
	* retrieve socialnet_scrapss from the database
	* 
	* @param object $criteria {@link CriteriaElement} conditions to be met
	* @param bool $id_as_key use the UID as key for the array?
	* @return array array of {@link socialnet_scraps} objects
	*/
	function &getObjects($criteria = null, $id_as_key = false)
	{
		$ret = array();
		$limit = $start = 0;
		$sql = 'SELECT * FROM '.$this->db->prefix('socialnet_scraps');
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
			$socialnet_scraps = new socialnet_scraps();
			$socialnet_scraps->assignVars($myrow);
			if (!$id_as_key) {
				$ret[] =& $socialnet_scraps;
			} else {
				$ret[$myrow['scrap_id']] =& $socialnet_scraps;
			}
			unset($socialnet_scraps);
		}
		return $ret;
	}

	/**
	* count socialnet_scrapss matching a condition
	* 
	* @param object $criteria {@link CriteriaElement} to match
	* @return int count of socialnet_scrapss
	*/
	function getCount($criteria = null)
	{
		$sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('socialnet_scraps');
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
	* delete socialnet_scrapss matching a set of conditions
	* 
	* @param object $criteria {@link CriteriaElement} 
	* @return bool FALSE if deletion failed
	*/
	function deleteAll($criteria = null)
	{
		$sql = 'DELETE FROM '.$this->db->prefix('socialnet_scraps');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		if (!$result = $this->db->query($sql)) {
			return false;
		}
		return true;
	}
	
	
	function getScraps($nbscraps, $criteria)
	{
		$myts = new MyTextSanitizer();
		$ret = array();
		$sql = 'SELECT scrap_id, uid, uname, user_avatar, scrap_from, scrap_text FROM '.$this->db->prefix('socialnet_scraps').', '.$this->db->prefix('users');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		//attention here this is kind of a hack
		$sql .= " AND uid = scrap_from" ;
		if ($criteria->getSort() != '') {
			$sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
		}
		$limit = $criteria->getLimit();
		$start = $criteria->getStart();
		
		$result = $this->db->query($sql, $limit, $start);
		$vetor = array();
		$i=0;
		
		while ($myrow = $this->db->fetchArray($result)) {
			
			
			$vetor[$i]['uid']= $myrow['uid'];
			$vetor[$i]['uname']= $myrow['uname'];
			$vetor[$i]['user_avatar']= $myrow['user_avatar'];
            $temptext = $myts->xoopsCodeDecode($myrow['scrap_text'],1);
			$vetor[$i]['text'] = $myts->nl2Br($temptext);
			$vetor[$i]['id']= $myrow['scrap_id'];
			
			$i++;
		}
		
		return $vetor;

		}
	}
}


?>
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
* Includes of form objects and uploader 
*/
include_once XOOPS_ROOT_PATH."/class/uploader.php";
include_once XOOPS_ROOT_PATH."/class/xoopsobject.php";
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
include_once XOOPS_ROOT_PATH."/class/xoopsobject.php";

/**
* socialnet_friendship class.  
* $this class is responsible for providing data access mechanisms to the data source 
* of XOOPS user class objects.
*/


class socialnet_friendship extends XoopsObject
{ 
	var $db;

// constructor
	function socialnet_friendship ($id=null)
	{
		$this->db =& Database::getInstance();
		$this->initVar("friendship_id",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("friend1_uid",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("friend2_uid",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("level",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("hot",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("trust",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("cool",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("fan",XOBJ_DTYPE_INT,null,false,10);
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
		$sql = 'SELECT * FROM '.$this->db->prefix("socialnet_friendship").' WHERE friendship_id='.$id;
		$myrow = $this->db->fetchArray($this->db->query($sql));
		$this->assignVars($myrow);
		if (!$myrow) {
			$this->setNew();
		}
	}

	function getAllsocialnet_friendships($criteria=array(), $asobject=false, $sort="friendship_id", $order="ASC", $limit=0, $start=0)
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
			$sql = "SELECT friendship_id FROM ".$db->prefix("socialnet_friendship")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = $myrow['socialnet_friendship_id'];
			}
		} else {
			$sql = "SELECT * FROM ".$db->prefix("socialnet_friendship")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = new socialnet_friendship ($myrow);
			}
		}
		return $ret;
	}
}
// -------------------------------------------------------------------------
// ------------------socialnet_friendship user handler class -------------------
// -------------------------------------------------------------------------
/**
* socialnet_friendshiphandler class.  
* This class provides simple mecanisme for socialnet_friendship object
*/

class Xoopssocialnet_friendshipHandler extends XoopsObjectHandler
{

	/**
	* create a new socialnet_friendship
	* 
	* @param bool $isNew flag the new objects as "new"?
	* @return object socialnet_friendship
	*/
	function &create($isNew = true)	{
		$socialnet_friendship = new socialnet_friendship();
		if ($isNew) {
			$socialnet_friendship->setNew();
		}
		else{
		$socialnet_friendship->unsetNew();
		}

		
		return $socialnet_friendship;
	}

	/**
	* retrieve a socialnet_friendship
	* 
	* @param int $id of the socialnet_friendship
	* @return mixed reference to the {@link socialnet_friendship} object, FALSE if failed
	*/
	function &get($id)	{
			$sql = 'SELECT * FROM '.$this->db->prefix('socialnet_friendship').' WHERE friendship_id='.$id;
			if (!$result = $this->db->query($sql)) {
				return false;
			}
			$numrows = $this->db->getRowsNum($result);
			if ($numrows == 1) {
				$socialnet_friendship = new socialnet_friendship();
				$socialnet_friendship->assignVars($this->db->fetchArray($result));
				return $socialnet_friendship;
			}
				return false;
	}

/**
* insert a new socialnet_friendship in the database
* 
* @param object $socialnet_friendship reference to the {@link socialnet_friendship} object
* @param bool $force
* @return bool FALSE if failed, TRUE if already present and unchanged or successful
*/
	function insert(&$socialnet_friendship, $force = false) {
		Global $xoopsConfig;
		if (get_class($socialnet_friendship) != 'socialnet_friendship') {
				return false;
		}
		if (!$socialnet_friendship->isDirty()) {
				return true;
		}
		if (!$socialnet_friendship->cleanVars()) {
				return false;
		}
		foreach ($socialnet_friendship->cleanVars as $k => $v) {
				${$k} = $v;
		}
		$now = "date_add(now(), interval ".$xoopsConfig['server_TZ']." hour)";
		if ($socialnet_friendship->isNew()) {
			// ajout/modification d'un socialnet_friendship
			$socialnet_friendship = new socialnet_friendship();
			$format = "INSERT INTO %s (friendship_id, friend1_uid, friend2_uid, level, hot, trust, cool, fan)";
			$format .= "VALUES (%u, %u, %u, %u, %u, %u, %u, %u)";
			$sql = sprintf($format , 
			$this->db->prefix('socialnet_friendship'), 
			$friendship_id
			,$friend1_uid
			,$friend2_uid
			,$level
			,$hot
			,$trust
			,$cool
			,$fan
			);
			$force = true;
		} else {
			$format = "UPDATE %s SET ";
			$format .="friendship_id=%u, friend1_uid=%u, friend2_uid=%u, level=%u, hot=%u, trust=%u, cool=%u, fan=%u";
			$format .=" WHERE friendship_id = %u";
			$sql = sprintf($format, $this->db->prefix('socialnet_friendship'),
			$friendship_id
			,$friend1_uid
			,$friend2_uid
			,$level
			,$hot
			,$trust
			,$cool
			,$fan
			, $friendship_id);
		}
		if (false != $force) {
			$result = $this->db->queryF($sql);
		} else {
			$result = $this->db->query($sql);
		}
		if (!$result) {
			return false;
		}
		if (empty($friendship_id)) {
			$friendship_id = $this->db->getInsertId();
		}
		$socialnet_friendship->assignVar('friendship_id', $friendship_id);
		return true;
	}

	/**
	 * delete a socialnet_friendship from the database
	 * 
	 * @param object $socialnet_friendship reference to the socialnet_friendship to delete
	 * @param bool $force
	 * @return bool FALSE if failed.
	 */
	function delete(&$socialnet_friendship, $force = false)
	{
		if (get_class($socialnet_friendship) != 'socialnet_friendship') {
			return false;
		}
		$sql = sprintf("DELETE FROM %s WHERE friendship_id = %u", $this->db->prefix("socialnet_friendship"), $socialnet_friendship->getVar('friendship_id'));
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
	* retrieve socialnet_friendships from the database
	* 
	* @param object $criteria {@link CriteriaElement} conditions to be met
	* @param bool $id_as_key use the UID as key for the array?
	* @return array array of {@link socialnet_friendship} objects
	*/
	function &getObjects($criteria = null, $id_as_key = false)
	{
		$ret = array();
		$limit = $start = 0;
		$sql = 'SELECT * FROM '.$this->db->prefix('socialnet_friendship');
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
			$socialnet_friendship = new socialnet_friendship();
			$socialnet_friendship->assignVars($myrow);
			if (!$id_as_key) {
				$ret[] =& $socialnet_friendship;
			} else {
				$ret[$myrow['friendship_id']] =& $socialnet_friendship;
			}
			unset($socialnet_friendship);
		}
		return $ret;
	}

	/**
	* count socialnet_friendships matching a condition
	* 
	* @param object $criteria {@link CriteriaElement} to match
	* @return int count of socialnet_friendships
	*/
	function getCount($criteria = null)
	{
		$sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('socialnet_friendship');
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
	* delete socialnet_friendships matching a set of conditions
	* 
	* @param object $criteria {@link CriteriaElement} 
	* @return bool FALSE if deletion failed
	*/
	function deleteAll($criteria = null)
	{
		$sql = 'DELETE FROM '.$this->db->prefix('socialnet_friendship');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		if (!$result = $this->db->query($sql)) {
			return false;
		}
		return true;
	}
	
	
	function getFriends($nbfriends, $criteria = null, $shuffle=1)
	{
		$ret = array();
		$limit = $start = 0;
		$sql = 'SELECT uname, user_avatar, friend2_uid FROM '.$this->db->prefix('socialnet_friendship').', '.$this->db->prefix('users');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		//attention here this is kind of a hack
		$sql .= " AND uid = friend2_uid " ;
		if ($criteria->getSort() != '') {
			$sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
		}
		
		$limit = $criteria->getLimit();
		$start = $criteria->getStart();
		
		$result = $this->db->query($sql, $limit, $start);
		$vetor = array();
		$i=0;
		
		while ($myrow = $this->db->fetchArray($result)) {
			
			$vetor[$i]['uid']= $myrow['friend2_uid'];
			$vetor[$i]['uname']= $myrow['uname'];
			$vetor[$i]['user_avatar']= $myrow['user_avatar'];
			$i++;
		}
		if ($shuffle==1){
		shuffle($vetor);
		$vetor = array_slice($vetor,0,$nbfriends);
		}
		return $vetor;

		}
	}
	
function getFans($nbfriends, $criteria = null, $shuffle=1)
    {
        $ret = array();
        $limit = $start = 0;
        $sql = 'SELECT uname, user_avatar, friend1_uid FROM '.$this->db->prefix('socialnet_friendship').', '.$this->db->prefix('users');
        if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
            $sql .= ' '.$criteria->renderWhere();
        //attention here this is kind of a hack
        $sql .= " AND uid = friend1_uid " ;
        if ($criteria->getSort() != '') {
            $sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
        }
        
        $limit = $criteria->getLimit();
        $start = $criteria->getStart();
        
        $result = $this->db->query($sql, $limit, $start);
        $vetor = array();
        $i=0;
        
        while ($myrow = $this->db->fetchArray($result)) {
            
            $vetor[$i]['uid']= $myrow['friend1_uid'];
            $vetor[$i]['uname']= $myrow['uname'];
            $vetor[$i]['user_avatar']= $myrow['user_avatar'];
            $i++;
        }
        if ($shuffle==1){
        shuffle($vetor);
        $vetor = array_slice($vetor,0,$nbfriends);
        }
        return $vetor;

        }
    }	
	
	
function renderFormSubmit($friend)
	{
		global $xoopsUser;
		/**
 * criteria fetch friendship to be edited  
 */
$criteria_friend1 = new criteria('friend1_uid',$xoopsUser->getVar('uid'));
$criteria_friend2 = new criteria('friend2_uid',$friend->getVar('uid'));
$criteria_friendship = new criteriaCompo($criteria_friend1);
$criteria_friendship->add($criteria_friend2);
$friendships = $this->getObjects($criteria_friendship);
$friendship = $friendships[0];
				
		$form 					= new XoopsThemeForm(_MD_SOCIALNET_EDITFRIENDSHIP, "form_editfriendship", "editfriendship.php", "post", true);
		//$field_friend_avatar 		= new XoopsFormLabel(_MD_SOCIALNET_PHOTO, "<img src=../../uploads/".$friend->getVar('user_avatar')." />");
		if ($friend->getVar('user_avatar')=="blank.gif"){
		$field_friend_avatar 		= new XoopsFormLabel(_MD_SOCIALNET_PHOTO, "<img src=images/profile/noavatar.gif />");
		} else {
		$field_friend_avatar 		= new XoopsFormLabel(_MD_SOCIALNET_PHOTO, "<img src=../../uploads/".$friend->getVar('user_avatar')." />");
	  }
		$field_friend_name 		= new XoopsFormLabel(_MD_SOCIALNET_FRIENDNAME, $friend->getVar('uname'));
		
		$field_friend_fan       = new XoopsFormRadioYN(_MD_SOCIALNET_FAN, "fan", $friendship->getVar('fan'),'<img src="images/fans/fans.gif" alt="'._YES.'" title="'._YES.'" />','<img src="images/fans/fansbw.gif" alt="'._NO.'" title="'._NO.'" />');
		
		$field_friend_level		= new XoopsFormRadio(_MD_SOCIALNET_LEVEL,"level",$friendship->getVar('level'),"<br />");
		
		$field_friend_level->addOption("1", _MD_SOCIALNET_UNKNOWNACCEPTED);
		$field_friend_level->addOption("3", _MD_SOCIALNET_AQUAITANCE);
		$field_friend_level->addOption("5", _MD_SOCIALNET_FRIEND);
		$field_friend_level->addOption("7", _MD_SOCIALNET_BESTFRIEND);
		
		$field_friend_sexy		= new XoopsFormRadio(_MD_SOCIALNET_SEXY,"hot",$friendship->getVar('hot'));
		$field_friend_sexy->addOption("1", '<img src="images/fans/sexya.gif" alt="'._MD_SOCIALNET_SEXYNO.'" title="'._MD_SOCIALNET_SEXYNO.'" />');
		$field_friend_sexy->addOption("2", '<img src="images/fans/sexyb.gif" alt="'._MD_SOCIALNET_SEXYYES.'" title="'._MD_SOCIALNET_SEXYYES.'" />');
		$field_friend_sexy->addOption("3", '<img src="images/fans/sexyc.gif" alt="'._MD_SOCIALNET_SEXYALOT.'" title="'._MD_SOCIALNET_SEXYALOT.'" />');
		
		$field_friend_trusty		= new XoopsFormRadio(_MD_SOCIALNET_TRUSTY,"trust",$friendship->getVar('trust'));
		$field_friend_trusty->addOption("1", '<img src="images/fans/trustya.gif" alt="'._MD_SOCIALNET_TRUSTYNO.'" title="'._MD_SOCIALNET_TRUSTYNO.'" />');
		$field_friend_trusty->addOption("2", '<img src="images/fans/trustyb.gif" alt="'._MD_SOCIALNET_TRUSTYYES.'" title="'._MD_SOCIALNET_TRUSTYYES.'" />');
		$field_friend_trusty->addOption("3", '<img src="images/fans/trustyc.gif" alt="'._MD_SOCIALNET_TRUSTYALOT.'" title="'._MD_SOCIALNET_TRUSTYALOT.'" />');
		
		$field_friend_cool		= new XoopsFormRadio(_MD_SOCIALNET_COOL,"cool",$friendship->getVar('cool'));
		$field_friend_cool->addOption("1", '<img src="images/fans/coola.gif" alt="'._MD_SOCIALNET_COOLNO.'" title="'._MD_SOCIALNET_COOLNO.'" />');
		$field_friend_cool->addOption("2", '<img src="images/fans/coolb.gif" alt="'._MD_SOCIALNET_COOLYES.'" title="'._MD_SOCIALNET_COOLYES.'" />');
		$field_friend_cool->addOption("3", '<img src="images/fans/coolc.gif" alt="'._MD_SOCIALNET_COOLALOT.'" title="'._MD_SOCIALNET_COOLALOT.'" />');
		
			
		$form->setExtra('enctype="multipart/form-data"');
		$button_send 	= new XoopsFormButton("", "submit_button", _MD_SOCIALNET_UPDATEFRIEND, "submit");
		$field_friend_friendid = new XoopsFormHidden("friend_uid",$friend->getVar('uid'));
		$field_friend_marker = new XoopsFormHidden("marker","1");
		$field_friend_friendshio_id = new XoopsFormHidden("friendship_id",$friendship->getVar('friendship_id'));
		$form->addElement($field_friend_friendid);
		$form->addElement($field_friend_friendshio_id);
		$form->addElement($field_friend_marker);
		$form->addElement($field_friend_avatar);
		$form->addElement($field_friend_name);
		$form->addElement($field_friend_level);
		$form->addElement($field_friend_fan);
		$form->addElement($field_friend_sexy);
		$form->addElement($field_friend_trusty);
		$form->addElement($field_friend_cool);
		
		$form->addElement($button_send);
		
		 
		$form->display(); //If your server is php 4.4 
		
	
	}
	/**
	* Get the averages of each evaluation hot trusty etc...
	* 
	* @param int $user_uid
	* @return array $vetor with averages
	*/
	
	function getMoyennes($user_uid){
	
	global $xoopsUser;
	
	$vetor = array();
	$vetor['mediahot']=0;
	$vetor['mediatrust']=0;	
	$vetor['mediacool']=0;		
	$vetor['sumfan']=0;
	
	//Calculating avg(hot)	
	$sql ="SELECT friend2_uid, Avg(hot) AS mediahot FROM ".$this->db->prefix('socialnet_friendship');
	$sql .=" WHERE  (hot>0) GROUP BY friend2_uid HAVING (friend2_uid=".$user_uid.") ";
	$result = $this->db->query($sql);
	while ($myrow = $this->db->fetchArray($result)) {
		$vetor['mediahot']= $myrow['mediahot']*16;
	}
	
	//Calculating avg(trust)
	$sql ="SELECT friend2_uid, Avg(trust) AS mediatrust FROM ".$this->db->prefix('socialnet_friendship');
	$sql .=" WHERE  (trust>0) GROUP BY friend2_uid HAVING (friend2_uid=".$user_uid.") ";
	$result = $this->db->query($sql);
	while ($myrow = $this->db->fetchArray($result)) {
		$vetor['mediatrust']= $myrow['mediatrust']*16;
	}
	//Calculating avg(cool)
	$sql  = "SELECT friend2_uid, Avg(cool) AS mediacool FROM ".$this->db->prefix('socialnet_friendship');
	$sql .= " WHERE  (cool>0) GROUP BY friend2_uid HAVING (friend2_uid=".$user_uid.") ";
	$result = $this->db->query($sql);
	while ($myrow = $this->db->fetchArray($result)) {
		$vetor['mediacool']= $myrow['mediacool']*16;
	}	

	//Calculating sum(fans)
	$sql ="SELECT friend2_uid, Sum(fan) AS sumfan FROM ".$this->db->prefix('socialnet_friendship');
	$sql .=" GROUP BY friend2_uid HAVING (friend2_uid=".$user_uid.") ";
	$result = $this->db->query($sql);
	while ($myrow = $this->db->fetchArray($result)) {
		$vetor['sumfan']= $myrow['sumfan'];
	}
	
	return $vetor;
	}
	
	
	
}


?>
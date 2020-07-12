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
include_once XOOPS_ROOT_PATH."/class/uploader.php";      
/**
* socialnet_audio class.  
* $this class is responsible for providing data access mechanisms to the data source 
* of XOOPS user class objects.
*/


class socialnet_audio extends XoopsObject
{ 
	var $db;

// constructor
	function socialnet_audio ($id=null)
	{
		$this->db =& Database::getInstance();
		$this->initVar("audio_id",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("title",XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar("author",XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar("url",XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar("uid_owner",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("data_creation",XOBJ_DTYPE_TXTBOX,null,false);
		$this->initVar("data_update",XOBJ_DTYPE_TXTBOX,null,false);
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
		$sql = 'SELECT * FROM '.$this->db->prefix("socialnet_audio").' WHERE audio_id='.$id;
		$myrow = $this->db->fetchArray($this->db->query($sql));
		$this->assignVars($myrow);
		if (!$myrow) {
			$this->setNew();
		}
	}

	function getAllsocialnet_audios($criteria=array(), $asobject=false, $sort="audio_id", $order="ASC", $limit=0, $start=0)
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
			$sql = "SELECT audio_id FROM ".$db->prefix("socialnet_audio")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = $myrow['socialnet_audio_id'];
			}
		} else {
			$sql = "SELECT * FROM ".$db->prefix("socialnet_audio")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = new socialnet_audio ($myrow);
			}
		}
		return $ret;
	}
}
// -------------------------------------------------------------------------
// ------------------socialnet_audio user handler class -------------------
// -------------------------------------------------------------------------
/**
* socialnet_audiohandler class.  
* This class provides simple mecanisme for socialnet_audio object
*/

class Xoopssocialnet_audioHandler extends XoopsObjectHandler
{

	/**
	* create a new socialnet_audio
	* 
	* @param bool $isNew flag the new objects as "new"?
	* @return object socialnet_audio
	*/
	function &create($isNew = true)	{
		$socialnet_audio = new socialnet_audio();
		if ($isNew) {
			$socialnet_audio->setNew();
		}
		else{
		$socialnet_audio->unsetNew();
		}

		
		return $socialnet_audio;
	}

	/**
	* retrieve a socialnet_audio
	* 
	* @param int $id of the socialnet_audio
	* @return mixed reference to the {@link socialnet_audio} object, FALSE if failed
	*/
	function &get($id)	{
			$sql = 'SELECT * FROM '.$this->db->prefix('socialnet_audio').' WHERE audio_id='.$id;
			if (!$result = $this->db->query($sql)) {
				return false;
			}
			$numrows = $this->db->getRowsNum($result);
			if ($numrows == 1) {
				$socialnet_audio = new socialnet_audio();
				$socialnet_audio->assignVars($this->db->fetchArray($result));
				return $socialnet_audio;
			}
				return false;
	}

/**
* insert a new socialnet_audio in the database
* 
* @param object $socialnet_audio reference to the {@link socialnet_audio} object
* @param bool $force
* @return bool FALSE if failed, TRUE if already present and unchanged or successful
*/
	function insert(&$socialnet_audio, $force = false) {
		Global $xoopsConfig;
		if (get_class($socialnet_audio) != 'socialnet_audio') {
				return false;
		}
		if (!$socialnet_audio->isDirty()) {
				return true;
		}
		if (!$socialnet_audio->cleanVars()) {
				return false;
		}
		foreach ($socialnet_audio->cleanVars as $k => $v) {
				${$k} = $v;
		}
		$now = "date_add(now(), interval ".$xoopsConfig['server_TZ']." hour)";
		if ($socialnet_audio->isNew()) {
			// ajout/modification d'un socialnet_audio
			$socialnet_audio = new socialnet_audio();
			$format = "INSERT INTO %s (audio_id, title, author, url, uid_owner, data_creation, data_update)";
			$format .= " VALUES (%u, %s, %s, %s, %u, %s, %s)";
			$sql = sprintf($format , 
			$this->db->prefix('socialnet_audio'), 
			$audio_id
			,$this->db->quoteString($title)
			,$this->db->quoteString($author)
			,$this->db->quoteString($url)
			,$uid_owner
			,$now
			,$now
			);
			$force = true;
		} else {
			$format = "UPDATE %s SET ";
			$format .="audio_id=%u, title=%s, author=%s, url=%s, uid_owner=%u, data_creation=%s, data_update=%s";
			$format .=" WHERE audio_id = %u";
			$sql = sprintf($format, $this->db->prefix('socialnet_audio'),
			$audio_id
			,$this->db->quoteString($title)
			,$this->db->quoteString($author)
			,$this->db->quoteString($url)
			,$uid_owner
			,$now
			,$now
			, $audio_id);
		}
		if (false != $force) {
			$result = $this->db->queryF($sql);
		} else {
			$result = $this->db->query($sql);
		}
		if (!$result) {
			return false;
		}
		if (empty($audio_id)) {
			$audio_id = $this->db->getInsertId();
		}
		$socialnet_audio->assignVar('audio_id', $audio_id);
		return true;
	}

	/**
	 * delete a socialnet_audio from the database
	 * 
	 * @param object $socialnet_audio reference to the socialnet_audio to delete
	 * @param bool $force
	 * @return bool FALSE if failed.
	 */
	function delete(&$socialnet_audio, $force = false)
	{
		if (get_class($socialnet_audio) != 'socialnet_audio') {
			return false;
		}
		$sql = sprintf("DELETE FROM %s WHERE audio_id = %u", $this->db->prefix("socialnet_audio"), $socialnet_audio->getVar('audio_id'));
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
	* retrieve socialnet_audios from the database
	* 
	* @param object $criteria {@link CriteriaElement} conditions to be met
	* @param bool $id_as_key use the UID as key for the array?
	* @return array array of {@link socialnet_audio} objects
	*/
	function &getObjects($criteria = null, $id_as_key = false)
	{
		$ret = array();
		$limit = $start = 0;
		$sql = 'SELECT * FROM '.$this->db->prefix('socialnet_audio');
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
			$socialnet_audio = new socialnet_audio();
			$socialnet_audio->assignVars($myrow);
			if (!$id_as_key) {
				$ret[] =& $socialnet_audio;
			} else {
				$ret[$myrow['audio_id']] =& $socialnet_audio;
			}
			unset($socialnet_audio);
		}
		return $ret;
	}

	/**
	* count socialnet_audios matching a condition
	* 
	* @param object $criteria {@link CriteriaElement} to match
	* @return int count of socialnet_audios
	*/
	function getCount($criteria = null)
	{
		$sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('socialnet_audio');
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
	* delete socialnet_audios matching a set of conditions
	* 
	* @param object $criteria {@link CriteriaElement} 
	* @return bool FALSE if deletion failed
	*/
	function deleteAll($criteria = null)
	{
		$sql = 'DELETE FROM '.$this->db->prefix('socialnet_audio');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		if (!$result = $this->db->query($sql)) {
			return false;
		}
		return true;
	}
    
    
    /**
    * Upload the file and Save into database
    * 
    * @param text $title A litle description of the file
    * @param text $path_upload The path to where the file should be uploaded
    * @param text $author the author of the music or audio file
    * @return bool FALSE if upload fails or database fails
    */
    function receiveAudio($title,$path_upload, $author, $maxfilebytes)
    {
        
        global $xoopsUser, $xoopsDB, $_POST, $_FILES;
        //busca id do user logado
        $uid = $xoopsUser->getVar('uid');
        //create a hash so it does not erase another file
        //$hash1 = date();
        //$hash = substr($hash1,0,4);
        
        // mimetypes and settings put this in admin part later
        $allowed_mimetypes = array( "audio/mp3" , "audio/x-mp3", "audio/mpeg", "audio/x-ms-wma");
        $maxfilesize = $maxfilebytes;
        
        // create the object to upload
        $uploader = new XoopsMediaUploader($path_upload, $allowed_mimetypes, $maxfilesize);
        // fetch the media
        if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
            //lets create a name for it
            $uploader->setPrefix('aud_'.$uid.'_');
            //now let s upload the file
            if (!$uploader->upload()) {
            // if there are errors lets return them
              echo "<div style=\"color:#FF0000; background-color:#FFEAF4; border-color:#FF0000; border-width:thick; border-style:solid; text-align:center\"><p>".$uploader->getErrors()."</p></div>";
              return false;
            } else {
            // now let s create a new object audio and set its variables
            //echo "passei aqui";
            $audio = $this->create();
            $url = $uploader->getSavedFileName();
            $audio->setVar("url",$url);
            $audio->setVar("title",$title);
            $audio->setVar("author",$author);
            $uid = $xoopsUser->getVar('uid');
            $audio->setVar("uid_owner",$uid);
            $this->insert($audio);
            $saved_destination = $uploader->getSavedDestination();
            //print_r($_FILES);
            }
        } else {
          echo "<div style=\"color:#FF0000; background-color:#FFEAF4; border-color:#FF0000; border-width:thick; border-style:solid; text-align:center\"><p>".$uploader->getErrors()."</p></div>";
          return false;
        }
        return true;
    }         
}
?>

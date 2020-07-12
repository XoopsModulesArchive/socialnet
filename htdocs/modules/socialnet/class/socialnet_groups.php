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

/**
* Protection against inclusion outside the site 
*/
if (!defined("XOOPS_ROOT_PATH")) {
die("XOOPS root path not defined");
}

/**
* Includes of form objects and uploader 
*/
include_once XOOPS_ROOT_PATH."/class/uploader.php";
include_once XOOPS_ROOT_PATH."/class/xoopsobject.php";
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";
include_once XOOPS_ROOT_PATH."/class/xoopsobject.php";
include_once XOOPS_ROOT_PATH."/class/xoopsobject.php";
/**
* socialnet_groups class.  
* $this class is responsible for providing data access mechanisms to the data source 
* of XOOPS user class objects.
*/


class socialnet_groups extends XoopsObject
{ 
	var $db;

// constructor
	function socialnet_groups ($id=null)
	{
		$this->db =& Database::getInstance();
		$this->initVar("group_id",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("owner_uid",XOBJ_DTYPE_INT,null,false,10);
		$this->initVar("group_title",XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar("group_desc",XOBJ_DTYPE_TXTBOX, null, false);
		$this->initVar("group_img",XOBJ_DTYPE_TXTBOX, null, false);
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
		$sql = 'SELECT * FROM '.$this->db->prefix("socialnet_groups").' WHERE group_id='.$id;
		$myrow = $this->db->fetchArray($this->db->query($sql));
		$this->assignVars($myrow);
		if (!$myrow) {
			$this->setNew();
		}
	}

	function getAllsocialnet_groupss($criteria=array(), $asobject=false, $sort="group_id", $order="ASC", $limit=0, $start=0)
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
			$sql = "SELECT group_id FROM ".$db->prefix("socialnet_groups")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = $myrow['socialnet_groups_id'];
			}
		} else {
			$sql = "SELECT * FROM ".$db->prefix("socialnet_groups")."$where_query ORDER BY $sort $order";
			$result = $db->query($sql,$limit,$start);
			while ( $myrow = $db->fetchArray($result) ) {
				$ret[] = new socialnet_groups ($myrow);
			}
		}
		return $ret;
	}
}
// -------------------------------------------------------------------------
// ------------------socialnet_groups user handler class -------------------
// -------------------------------------------------------------------------
/**
* socialnet_groupshandler class.  
* This class provides simple mecanisme for socialnet_groups object
*/

class Xoopssocialnet_groupsHandler extends XoopsObjectHandler
{

	/**
	* create a new socialnet_groups
	* 
	* @param bool $isNew flag the new objects as "new"?
	* @return object socialnet_groups
	*/
	function &create($isNew = true)	{
		$socialnet_groups = new socialnet_groups();
		if ($isNew) {
			$socialnet_groups->setNew();
		}
		else{
		$socialnet_groups->unsetNew();
		}

		
		return $socialnet_groups;
	}

	/**
	* retrieve a socialnet_groups
	* 
	* @param int $id of the socialnet_groups
	* @return mixed reference to the {@link socialnet_groups} object, FALSE if failed
	*/
	function &get($id)	{
			$sql = 'SELECT * FROM '.$this->db->prefix('socialnet_groups').' WHERE group_id='.$id;
			if (!$result = $this->db->query($sql)) {
				return false;
			}
			$numrows = $this->db->getRowsNum($result);
			if ($numrows == 1) {
				$socialnet_groups = new socialnet_groups();
				$socialnet_groups->assignVars($this->db->fetchArray($result));
				return $socialnet_groups;
			}
				return false;
	}

/**
* insert a new socialnet_groups in the database
* 
* @param object $socialnet_groups reference to the {@link socialnet_groups} object
* @param bool $force
* @return bool FALSE if failed, TRUE if already present and unchanged or successful
*/
	function insert(&$socialnet_groups, $force = false) {
		Global $xoopsConfig;
		if (get_class($socialnet_groups) != 'socialnet_groups') {
				return false;
		}
		if (!$socialnet_groups->isDirty()) {
				return true;
		}
		if (!$socialnet_groups->cleanVars()) {
				return false;
		}
		foreach ($socialnet_groups->cleanVars as $k => $v) {
				${$k} = $v;
		}
		$now = "date_add(now(), interval ".$xoopsConfig['server_TZ']." hour)";
		if ($socialnet_groups->isNew()) {
			// ajout/modification d'un socialnet_groups
			$socialnet_groups = new socialnet_groups();
			$format = "INSERT INTO %s (group_id, owner_uid, group_title, group_desc, group_img)";
			$format .= "VALUES (%u, %u, %s, %s, %s)";
			$sql = sprintf($format , 
			$this->db->prefix('socialnet_groups'), 
			$group_id
			,$owner_uid
			,$this->db->quoteString($group_title)
			,$this->db->quoteString($group_desc)
			,$this->db->quoteString($group_img)
			);
			$force = true;
		} else {
			$format = "UPDATE %s SET ";
			$format .="group_id=%u, owner_uid=%u, group_title=%s, group_desc=%s, group_img=%s";
			$format .=" WHERE group_id = %u";
			$sql = sprintf($format, $this->db->prefix('socialnet_groups'),
			$group_id
			,$owner_uid
			,$this->db->quoteString($group_title)
			,$this->db->quoteString($group_desc)
			,$this->db->quoteString($group_img)
			, $group_id);
		}
		if (false != $force) {
			$result = $this->db->queryF($sql);
		} else {
			$result = $this->db->query($sql);
		}
		if (!$result) {
			return false;
		}
		if (empty($group_id)) {
			$group_id = $this->db->getInsertId();
		}
		$socialnet_groups->assignVar('group_id', $group_id);
		return true;
	}

	/**
	 * delete a socialnet_groups from the database
	 * 
	 * @param object $socialnet_groups reference to the socialnet_groups to delete
	 * @param bool $force
	 * @return bool FALSE if failed.
	 */
	function delete(&$socialnet_groups, $force = false)
	{
		if (get_class($socialnet_groups) != 'socialnet_groups') {
			return false;
		}
		$sql = sprintf("DELETE FROM %s WHERE group_id = %u", $this->db->prefix("socialnet_groups"), $socialnet_groups->getVar('group_id'));
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
	* retrieve socialnet_groupss from the database
	* 
	* @param object $criteria {@link CriteriaElement} conditions to be met
	* @param bool $id_as_key use the UID as key for the array?
	* @return array array of {@link socialnet_groups} objects
	*/
	function &getObjects($criteria = null, $id_as_key = false)
	{
		$ret = array();
		$limit = $start = 0;
		$sql = 'SELECT * FROM '.$this->db->prefix('socialnet_groups');
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
			$socialnet_groups = new socialnet_groups();
			$socialnet_groups->assignVars($myrow);
			if (!$id_as_key) {
				$ret[] =& $socialnet_groups;
			} else {
				$ret[$myrow['group_id']] =& $socialnet_groups;
			}
			unset($socialnet_groups);
		}
		return $ret;
	}
	
		/**
	* retrieve socialnet_groupss from the database
	* 
	* @param object $criteria {@link CriteriaElement} conditions to be met
	* @param bool $id_as_key use the UID as key for the array?
	* @return array array of {@link socialnet_groups} objects
	*/
	function getGroups($criteria = null, $id_as_key = false)
	{
		$ret = array();
		$limit = $start = 0;
		$sql = 'SELECT * FROM '.$this->db->prefix('socialnet_groups');
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
		
		$i =0;
		while ($myrow = $this->db->fetchArray($result)) {
			$ret[$i]['id']		=$myrow['group_id'];
			$ret[$i]['title']	=$myrow['group_title'];
			$ret[$i]['img']		=$myrow['group_img'];
			$ret[$i]['desc']	=$myrow['group_desc'];
			$ret[$i]['uid']	= $myrow['owner_uid'];
			$i++;
		}
		return $ret;
	}

	/**
	* count socialnet_groupss matching a condition
	* 
	* @param object $criteria {@link CriteriaElement} to match
	* @return int count of socialnet_groupss
	*/
	function getCount($criteria = null)
	{
		$sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('socialnet_groups');
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
	* delete socialnet_groupss matching a set of conditions
	* 
	* @param object $criteria {@link CriteriaElement} 
	* @return bool FALSE if deletion failed
	*/
	function deleteAll($criteria = null)
	{
		$sql = 'DELETE FROM '.$this->db->prefix('socialnet_groups');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
		}
		if (!$result = $this->db->query($sql)) {
			return false;
		}
		return true;
	}
	
	

	function renderFormSubmit($maxbytes,$xoopsTpl)
	{

		$form 				= new XoopsThemeForm(_MD_SOCIALNET_SUBMIT_GROUP, "form_group", "submit_group.php", "post", true);
		$form->setExtra('enctype="multipart/form-data"');
		
		$field_url 			= new XoopsFormFile(_MD_SOCIALNET_GROUP_IMAGE, "group_img", $maxbytes);
		$field_title 		= new XoopsFormText(_MD_SOCIALNET_GROUP_TITLE, "group_title", 35, 55);
		$field_desc 		= new XoopsFormText(_MD_SOCIALNET_GROUP_DESC, "group_desc", 35, 55);
		$field_marker 		= new XoopsFormHidden("marker","1");
		$button_send 	    = new XoopsFormButton("", "submit_button", _MD_SOCIALNET_UPLOADGROUP, "submit");
		$field_warning      = new XoopsFormLabel(sprintf(_MD_SOCIALNET_YOUCANUPLOAD,$maxbytes/1024));

		
		
		$form->addElement($field_warning);
		$form->addElement($field_url,true);
		
		$form->addElement($field_title);
		$form->addElement($field_desc);
		$form->addElement($field_marker);
		$form->addElement($button_send);
		$form->display(); 

		return true;
	}
	
	
	
		function renderFormEdit($group,$maxbytes)
	{

		$form 				= new XoopsThemeForm(_MD_SOCIALNET_EDIT_GROUP, "form_editgroup", "editgroup.php", "post", true);
		$form->setExtra('enctype="multipart/form-data"');
		$field_groupid      = new XoopsFormHidden('group_id',$group->getVar('group_id'));
		$field_url 			= new XoopsFormFile(_MD_SOCIALNET_GROUP_IMAGE, "img", $maxbytes);
		$field_url->setExtra("style=\"visibility:hidden;\"");
		$field_title 		= new XoopsFormText(_MD_SOCIALNET_GROUP_TITLE, "title", 35, 55,$group->getVar('group_title'));
		$field_desc 		= new XoopsFormTextArea(_MD_SOCIALNET_GROUP_DESC, "desc", $group->getVar('group_desc'));
		$field_marker 		= new XoopsFormHidden("marker","1");
		$button_send 	    = new XoopsFormButton("", "submit_button", _MD_SOCIALNET_UPLOADGROUP, "submit");
		$field_warning      = new XoopsFormLabel(sprintf(_MD_SOCIALNET_YOUCANUPLOAD,$maxbytes/1024));
		
	    $field_oldpicture   = new XoopsFormLabel(_MD_SOCIALNET_GROUP_IMAGE,'<img src="'.XOOPS_UPLOAD_URL."/".$group->getVar('group_img').'" />');
	    
	    $field_maintainimage = new XoopsFormLabel(_MD_SOCIALNET_MAINTAINOLDIMAGE,"<input type='checkbox' value='1' id='flag_oldimg' name='flag_oldimg' onclick=\"groupImgSwitch(img)\"  checked/>");

		
		
		$form->addElement($field_oldpicture);
		$form->addElement($field_maintainimage);
		$form->addElement($field_warning);
		$form->addElement($field_url);
		$form->addElement($field_groupid); 
		$form->addElement($field_title);
		$form->addElement($field_desc);
		$form->addElement($field_marker);
		$form->addElement($button_send);
		$form->display(); 
		echo "
		<!-- Start Form Validation JavaScript //-->
<script type='text/javascript'>
<!--//
function groupImgSwitch(img) { 

var elestyle = xoopsGetElementById(img).style;

    if (elestyle.visibility == \"hidden\") {
        elestyle.visibility = \"visible\";
    } else {
        elestyle.visibility = \"hidden\";
    }
   

}
//--></script>
<!-- End Form Vaidation JavaScript //-->
		
		
		
		
		
		";
		
		return true;
	}
	
	
	
	
	function receiveGroup($group_title,$group_desc,$group_img,$path_upload, $maxfilebytes,$maxfilewidth, $maxfileheight,$change_img=1,$group="")
	{

		global $xoopsUser, $xoopsDB, $_POST, $_FILES;
		//busca id do user logado
		$uid = $xoopsUser->getVar('uid');
		if (!is_a($group,"socialnet_groups")){
		$group = $this->create();
		}else{
		$group->unsetNew();	
			
		}
		if ($change_img==1){
			// mimetypes and settings put this in admin part later
			$allowed_mimetypes = array( 'image/jpeg', 'image/pjpeg');
			$maxfilesize = $maxfilebytes;

			// create the object to upload
			$uploader = new XoopsMediaUploader($path_upload, $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight);
			// fetch the media
			if ($uploader->fetchMedia($_POST['xoops_upload_file'][0])) {
				//lets create a name for it
				$uploader->setPrefix('group_'.$uid.'_');
				//now let s upload the file
				
				if (!$uploader->upload()) {
					// if there are errors lets return them

					echo "<div style=\"color:#FF0000; background-color:#FFEAF4; border-color:#FF0000; border-width:thick; border-style:solid; text-align:center\"><p>".$uploader->getErrors()."</p></div>";
					return false;

				} else {
					// now let s create a new object picture and set its variables

					$url = $uploader->getSavedFileName();
					$saved_destination = $uploader->getSavedDestination();
					$image_name = $this->resizeImage2($saved_destination, 125, 80,$path_upload);
					$group->setVar("group_img",$image_name);
				
				}

			} else {

				echo "<div style=\"color:#FF0000; background-color:#FFEAF4; border-color:#FF0000; border-width:thick; border-style:solid; text-align:center\"><p>".$uploader->getErrors()."</p></div>";
				return false;}
		}

			$group->setVar("group_title",$group_title);
			$group->setVar("group_desc",$group_desc);
			$group->setVar("owner_uid",$uid);

			$this->insert($group);
		
			return true;
	}
		
		
		

	
	
	/**
	* Resize a picture and save it to $path_upload
	* 
	* @param text $img the path to the file
	* @param text $path_upload The path to where the files should be saved after resizing
	* @param int $thumbwidth the width in pixels that the thumbnail will have
	* @param int $thumbheight the height in pixels that the thumbnail will have
	* @param int $pictwidth the width in pixels that the pic will have
	* @param int $pictheight the height in pixels that the pic will have
	* @return nothing
	*/	
	function resizeImage($img_path, $thumbwidth, $thumbheight, $path_upload) {


		$path = pathinfo($img_path);
		$img=imagecreatefromjpeg($img_path);
		$xratio = $thumbwidth/(imagesx($img));
		$yratio = $thumbheight/(imagesy($img));

		if($xratio < 1 || $yratio < 1) {
			if($xratio < $yratio){
			$resized = imagecreatetruecolor($thumbwidth,floor(imagesy($img)*$xratio));
			}
			else {
			$resized = imagecreatetruecolor(floor(imagesx($img)*$yratio), $thumbheight);
			}
			imagecopyresampled($resized, $img, 0, 0, 0, 0, imagesx($resized)+1,imagesy($resized)+1,imagesx($img),imagesy($img));
			imagejpeg($resized,$path_upload."/thumb_".$path["basename"]);
			imagedestroy($resized);
		}
		else{
			imagejpeg($img,$path_upload."/thumb_".$path["basename"]);
		}

		imagedestroy($img);
	}
	
		/**
	* Resize a picture and save it to $path_upload
	* 
	* @param text $img the path to the file
	* @param text $path_upload The path to where the files should be saved after resizing
	* @param int $thumbwidth the width in pixels that the thumbnail will have
	* @param int $thumbheight the height in pixels that the thumbnail will have
	* @param int $pictwidth the width in pixels that the pic will have
	* @param int $pictheight the height in pixels that the pic will have
	* @return nothing
	*/	
	function resizeImage2($img_path, $thumbwidth, $thumbheight, $path_upload) {

		global $xoopsUser, $xoopsModule ;

		$path = pathinfo($img_path);
		$img=imagecreatefromjpeg($img_path);
		if (imagesx($img)<128){
			$x1 = (128-imagesx($img))/2;
			$x2 = 0;
			$w = imagesx($img);
		} else{
			$x1=0;
			$x2 = (imagesx($img)	-128)/2;
			$w=125;
		}

		if (imagesy($img)<80){
			$y1 = (80-imagesy($img))/2;
			$y2 = 0;
			$h = imagesy($img);
		} else{
			$y1=0;
			$y2 = (imagesy($img)	-80)/2;
			$h=80;
		}
		
		
		$xratio = $thumbwidth/(imagesx($img));
		$yratio = $thumbheight/(imagesy($img));
		
		$resized = imagecreatefromgif("images/profile/grouptemplate.gif");
		
		$image = imagecopymerge($resized,$img,$x1,$y1,$x2,$y2,$w,$h,90);
		$gif_name = "group_".$xoopsUser->getVar('uid').rand(1000000,9999999).".gif";
		imagegif($resized,$path_upload."/".$gif_name);
		imagedestroy($resized);
		imagedestroy($img);
		return $gif_name;
	}

}


?>
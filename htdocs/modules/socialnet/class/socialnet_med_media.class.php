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

include_once XOOPS_ROOT_PATH."/modules/socialnet/class/socialnet_geraltree.class.php";
class socialnet_med_media extends socialnet_geral {
	function socialnet_med_media($id=null){
		$this->db =& Database::getInstance();
		$this->tabela = $this->db->prefix(_MI_SOCIALNET_TABLEMEDIA);
		$this->id = "med_10_id";
		$this->initVar("med_10_id", XOBJ_DTYPE_INT);
		$this->initVar("med_30_name", XOBJ_DTYPE_TXTBOX);
		$this->initVar("med_30_file", XOBJ_DTYPE_TXTBOX);
		$this->initVar("med_10_height", XOBJ_DTYPE_INT, 0);
		$this->initVar("med_10_width", XOBJ_DTYPE_INT, 0);
		$this->initVar("med_10_size", XOBJ_DTYPE_INT, 0);
		$this->initVar("med_10_type", XOBJ_DTYPE_INT, 1);
		$this->initVar("med_12_show", XOBJ_DTYPE_INT, 1);
		$this->initVar("med_22_data", XOBJ_DTYPE_INT, 0);
		if ( !empty($id) ) {
			if ( is_array($id) ) {
				$this->assignVars($id);
			} else {
				$this->load(intval($id));
			}
		}

	}
	function deletaArquivo(){
		if (file_exists(SOCIALNET_MEDIA_PATH."/".$this->getVar("med_30_file"))) {
			@unlink(SOCIALNET_MEDIA_PATH."/".$this->getVar("med_30_file"));
			return true;
		}
		return false;
	}
}
?>
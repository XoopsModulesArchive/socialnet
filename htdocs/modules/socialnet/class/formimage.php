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

if (!defined('XOOPS_ROOT_PATH')) {
	die("Oooops!!");
}
include_once XOOPS_ROOT_PATH."/class/xoopsform/formselect.php";
class SocialnetFormSelectImage extends XoopsFormSelect
{
	/**
     * OptGroup
	 * @var array
	 * @access	private
	 */
	var $_optgroups = array();
	var $_optgroupsID = array();
	/**
	 * Construtor
	 *
	 * @param	string	$caption
	 * @param	string	$name
	 * @param	mixed	$value	Valor pré-selecionado (ou array de valores).
	 * @param	int		$size	Número de Linhas. "1" dá um Select List normal de 1 opção.
	 * @param	string	$cat	Nome da Categoria da biblioteca. Se vazio ou não definido, retorna todas as bibliotecas que o cara pode acessar.
	 */
	function SocialnetFormSelectImage($caption, $name, $value=null, $cat = null)
	{
		$this->XoopsFormSelect($caption, $name, $value);
		$this->addOptGroupArray($this->getImageList($cat));
	}

	/**
	 * Adiciona um Optgroup
     *
	 * @param	string  $value  opções do Grupo
     * @param	string  $name   Nome do Grupo de Opções
	 */
	function addOptGroup($value=array(), $name="&nbsp;"){
		$this->_optgroups[$name] = $value;
	}

	/**
	 * Adiciona múltiplos Optgroups
	 *
     * @param	array   $options    Array com name->opções
	 */
	function addOptGroupArray($options){
		if ( is_array($options) ) {
			foreach ( $options as $k=>$v ) {
				$this->addOptGroup($v,$k);
			}
		}
	}

	function getImageList($cat = null)
	{
		global $xoopsUser;
		$ret = array();
		if (!is_object($xoopsUser)) {
			$group = array(XOOPS_GROUP_ANONYMOUS);
		} else {
			$group =& $xoopsUser->getGroups();
		}
		$imgcat_handler =& xoops_gethandler('imagecategory');
		$catlist =& $imgcat_handler->getList($group, 'imgcat_read', 1);
		if (is_array($cat) && count($catlist) > 0) {
			foreach ($catlist as $k=>$v) {
				if (!in_array($k, $cat)) {
					unset($catlist[$k]);
				}
			}
		}elseif (is_int($cat)){
			$catlist = array_key_exists($cat, $catlist) ? array($cat=>$catlist[$cat]) : array();
		}
			$image_handler = xoops_gethandler('image');
			foreach ($catlist as $k=>$v) {
				$this->_optgroupsID[$v] = $k;
				$criteria = new CriteriaCompo(new Criteria('imgcat_id', $k));
				$criteria->add(new Criteria('image_display', 1));
				$total = $image_handler->getCount($criteria);
				if ($total > 0) {
					$imgcat =& $imgcat_handler->get($k);
					$storetype = $imgcat->getVar('imgcat_storetype');
					if ($storetype == 'db') {
						$images =& $image_handler->getObjects($criteria, false, true);
					} else {
						$images =& $image_handler->getObjects($criteria, false, false);
					}
					foreach ($images as $i) {
						if($storetype == "db"){
							$ret[$v]["/image.php?id=".$i->getVar('image_id')] = $i->getVar('image_nicename');
						}else{
							$ret[$v]["/uploads/".$i->getVar('image_name')] =  $i->getVar('image_nicename');
						}
					}
				}else{
					$ret[$v] = "";
				}
			}
		return $ret;
	}

	/**
	 * Pega todos os Optgroups
	 *
     * @return	array   Array com name->opções
	 */
	function getOptGroups(){
		return $this->_optgroups;
	}

	/**
	 * Pega todos os IDs dos Optgroups
	 *
     * @return	array   Array com name->ids
	 */
	function getOptGroupsID(){
		return $this->_optgroupsID;
	}

	function render(){
		global $xoopsUser;
		if (!is_object($xoopsUser)) {
			$group = array(XOOPS_GROUP_ANONYMOUS);
		} else {
			$group =& $xoopsUser->getGroups();
		}
		$imgcat_handler =& xoops_gethandler('imagecategory');
		$catlist =& $imgcat_handler->getList($group, 'imgcat_write', 1);
		$catlist_total = count($catlist);
		$optIds = $this->getOptGroupsID();
		$ret = "<select onchange='if(this.options[this.selectedIndex].value != \"\"){ document.getElementById(\"".$this->getName()."_img\").src=\"".XOOPS_URL."\"+this.options[this.selectedIndex].value;}else{document.getElementById(\"".$this->getName()."_img\").src=\"".XOOPS_URL."/modules/socialnet/images/spager.gif\";}'  size='".$this->getSize()."'".$this->getExtra()."";
		if ($this->isMultiple() != false) {
			$ret .= " name='".$this->getName()."[]' id='".$this->getName()."[]' multiple='multiple'>\n";
		} else {
			$ret .= " name='".$this->getName()."' id='".$this->getName()."'>\n";
		}
		$ret .= "<option value=''>"._SELECT."</option>\n";
		foreach ( $this->getOptGroups() as $name => $valores ){
			$ret .= '\n<optgroup id="img_cat_'.$optIds[$name].'" label="'.$name.'">';
			if (is_array($valores)) {
				foreach ( $valores as $value => $name ) {
					$ret .= "<option value='".htmlspecialchars($value, ENT_QUOTES)."'";
					if (count($this->getValue()) > 0 && in_array($value, $this->getValue())) {
						$ret .= " selected='selected'";
						$image = $value;
					}
					$ret .= ">".$name."</option>\n";
				}
			}
			$ret .= '</optgroup>\n';
		}
		$browse_url = dirname(__FILE__)."/formimage_browse.php";
		$browse_url = str_replace(XOOPS_ROOT_PATH, XOOPS_URL, $browse_url);
		$ret .= "</select>";
		$ret .= ($catlist_total > 0) ? " <input type='button' value='"._ADDIMAGE."' onclick=\"window.open('$browse_url?target=".$this->getName()."','SocialnetFormImage','resizable=yes,width=500,height=470,left='+(screen.availWidth/2-200)+',top='+(screen.availHeight/2-200)+'');return false;\">" : "";
		$ret .= "<br /><img id='".$this->getName()."_img' src='".((!empty($image)) ? XOOPS_URL.$image : XOOPS_URL."/modules/socialnet/images/icons/spacer.gif")."'>";
		return $ret;
	}
}
?>
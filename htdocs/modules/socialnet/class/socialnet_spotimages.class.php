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

include_once XOOPS_ROOT_PATH."/modules/socialnet/class/socialnet_geral.class.php";
class socialnet_spotimages extends socialnet_geral {
    function socialnet_spotimages($id=null){
        $this->db =& Database::getInstance();
        $this->tabela = $this->db->prefix(_MI_SOCIALNET_TABLESPOTIMAGES);
        $this->id = "spot_10_id";
        $this->initVar("spot_10_id", XOBJ_DTYPE_INT);
        $this->initVar("sec_10_id", XOBJ_DTYPE_INT);
        $this->initVar("spot_30_name", XOBJ_DTYPE_TXTBOX);
        $this->initVar("spot_30_link", XOBJ_DTYPE_URL);
        $this->initVar("spot_11_target", XOBJ_DTYPE_INT, 0);
        $this->initVar("spot_30_image", XOBJ_DTYPE_TXTBOX);
        $this->initVar("spot_10_access", XOBJ_DTYPE_INT);
        $this->initVar("spot_12_ative", XOBJ_DTYPE_INT, 1);
        if ( !empty($id) ) {
            if ( is_array($id) ) {
                $this->assignVars($id);
            } else {
                $this->load(intval($id));
            }
        }

    }
    function ativar(){
        $sql = 'UPDATE '.$this->tabela.' SET spot_12_ative=1 WHERE '.$this->id.'='.$this->getVar($this->id);
        if (!$result = $this->db->queryF($sql)) {
            return false;
        }
        return true;
    }

    function desativar(){
        $sql = 'UPDATE '.$this->tabela.' SET spot_12_ative=0 WHERE '.$this->id.'='.$this->getVar($this->id);
        if (!$result = $this->db->queryF($sql)) {
            return false;
        }
        return true;
    }
    function pegaImagem($html = false) {
        return (!$html) ? XOOPS_URL.$this->getVar("spot_30_image") : "<img src='".XOOPS_URL.$this->getVar("spot_30_image")."' alt='".$this->getVar("spot_30_name")."' class='full'>";
    }
    function pegaLink($image = false, $html = true){
        if (!$html) {
            return XOOPS_URL."/modules/socialnet/spot.php?tac=".$this->getVar($this->id);
        }else{
            if (!$image) {
                if ($this->getVar("spot_11_target") == 0) {
                    return "<a href='".XOOPS_URL."/modules/socialnet/spot.php?tac=".$this->getVar($this->id)."' title='".$this->getVar("spot_30_name")."'>".$this->getVar("spot_30_link")."</a>";
                }else{
                    return "<a href='".XOOPS_URL."/modules/socialnet/spot.php?tac=".$this->getVar($this->id)."' title='".$this->getVar("spot_30_name")."' target='_blank'>".$this->getVar("spot_30_link")."</a>";
                }
            }else{
                if ($this->getVar("spot_11_target") == 0) {
                    return "<a href='".XOOPS_URL."/modules/socialnet/spot.php?tac=".$this->getVar($this->id)."' title='".$this->getVar("spot_30_name")."'>".$this->pegaImagem(true)."</a>";
                }else{
                    return "<a href='".XOOPS_URL."/modules/socialnet/spot.php?tac=".$this->getVar($this->id)."' title='".$this->getVar("spot_30_name")."' target='_blank'>".$this->pegaImagem(true)."</a>";
                }
            }
        }

    }
    function atualizaCount(){
        $sql = 'UPDATE '.$this->tabela.' SET spot_10_access=spot_10_access+1 WHERE '.$this->id.'='.$this->getVar($this->id);
        if (!$result = $this->db->queryF($sql)) {
            return false;
        }
        return true;
    }
}
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
class socialnet_cfi_contentfiles extends socialnet_geral {
	function socialnet_cfi_contentfiles($id=null){
		$this->db =& Database::getInstance();
		$this->tabela = $this->db->prefix(_MI_SOCIALNET_TABLECONTENTS);
		$this->id = "cfi_10_id";
		$this->initVar("cfi_10_id", XOBJ_DTYPE_INT);
		$this->initVar("cfi_30_name", XOBJ_DTYPE_TXTBOX);
		$this->initVar("cfi_30_file", XOBJ_DTYPE_TXTBOX);
		$this->initVar("cfi_30_mime", XOBJ_DTYPE_TXTBOX);
		$this->initVar("cfi_10_size", XOBJ_DTYPE_INT, 0);
		$this->initVar("cfi_12_show", XOBJ_DTYPE_INT, 1);
		$this->initVar("cfi_22_data", XOBJ_DTYPE_INT, 0);
		if ( !empty($id) ) {
			if ( is_array($id) ) {
				$this->assignVars($id);
			} else {
				$this->load(intval($id));
			}
		}

	}
	function deletaArquivo(){
		if (file_exists(SOCIALNET_HTML_PATH."/".$this->getVar("cfi_30_file"))) {
			@unlink(SOCIALNET_HTML_PATH."/".$this->getVar("cfi_30_file"));
			return true;
		}
		return false;
	}
	function pegaMimes(){
		$sql = 'SELECT cfi_30_file, cfi_30_mime FROM '.$this->tabela.' GROUP BY cfi_30_mime';
		$resultado = $this->db->query($sql);
		$this->total = $this->db->getRowsNum($resultado);
		if ($this->total > 0){
			while ( $linha = $this->db->fetchArray($resultado) ) {
				$ext = (substr($linha['cfi_30_file'], -4,1) == ".") ? substr($linha['cfi_30_file'], -4) : substr($linha['cfi_30_file'], -5);
				$ret[$linha['cfi_30_mime']] = $linha['cfi_30_mime']." (".$ext.")";
			}
			return $ret;
		}else{
			return array();
		}
	}
	function listPages(){
		$ret = array(0=>_AM_SOCIALNET_SELECT);
		$sql = 'SELECT cfi_30_name, cfi_30_file FROM '.$this->tabela;
		$resultado = $this->db->query($sql);
		$this->total = $this->db->getRowsNum($resultado);
		if ($this->total > 0){
			while ( $linha = $this->db->fetchArray($resultado) ) {
				$ext = (substr($linha['cfi_30_file'], -4,1) == ".") ? substr($linha['cfi_30_file'], -4) : substr($linha['cfi_30_file'], -5);
				$ret[$linha['cfi_30_file']] = $linha['cfi_30_name']." (".$ext.")";
			}
		}
		return $ret;
	}
	function delete()
	{
		include_once XOOPS_ROOT_PATH."/modules/socialnet/class/socialnet_mpb_mpublish.class.php";
		$socialnet_classe = new socialnet_mpb_mpublish();
		$criterio = new Criteria("mpb_30_file", $this->getVar("cfi_30_file"));
		$mpb_todos = $socialnet_classe->PegaTudo($criterio);
		if ($mpb_todos) {
			foreach ($mpb_todos as $v){
				$mpb_10_id = $v->getVar("mpb_10_id");
				socialnet_apagaPermissoes($mpb_10_id);
				$v->delete();
				if($v->tem_subcategorias($mpb_10_id)){
					socialnet_apagaPermissoesPai($mpb_10_id);
					$socialnet_classe->deletaTodos(new Criteria("mpb_10_idpai", $mpb_10_id));
				}
				$v->delete();
			}
		}
		$sql = sprintf("DELETE FROM %s WHERE ".$this->id." = %u", $this->tabela, $this->getVar($this->id));
		if ( !$this->db->query($sql) ) {
			return false;
		}
		$this->afetadas = $this->db->getAffectedRows();
		return true;
	}
}
?>
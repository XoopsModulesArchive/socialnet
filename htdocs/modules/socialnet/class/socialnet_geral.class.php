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
if (!class_exists('socialnet_geral')) {
    class socialnet_geral extends XoopsObject
    {
        var $db;
        var $tabela;
        var $id;
        var $total=0;
        var $afetadas=0;
        // construtor da classe
        function socialnet_geral()
        {
            // Não usado diretamente
        }

        function store()
        {
            if ( !$this->cleanVars() ) {
                return false;
            }
            $myts =& MyTextSanitizer::getInstance();
            foreach ( $this->cleanVars as $k=>$v ) {
                $indices[] = $k;
                $valores[] = $v;
                //$$k = $v;
            }
            if (is_null($this->getVar($this->id)) || $this->getVar($this->id) == 0) {
                $sql = "INSERT INTO ".$this->tabela." (";
                $sql .= implode(",", $indices);
                $sql .= ") VALUES (";
                for ($i = 0; $i<count($valores); $i++){
                    if(!is_int($valores[$i])){
                        $sql .= $this->db->quoteString($valores[$i]);
                    }else{
                        $sql .= $valores[$i];
                    }
                    if ($i != (count($valores)-1)) {
                        $sql .= ",";
                    }
                }
                $sql .= ")";
            }else {
                $sql ="UPDATE ".$this->tabela." SET ";
                for ($i = 1; $i<count($valores); $i++){
                    $sql .= $indices[$i]."=";
                    if(!is_int($valores[$i])){
                        $sql .= $this->db->quoteString($valores[$i]);
                    }else{
                        $sql .= $valores[$i];
                    }
                    if ($i != (count($valores)-1)) {
                        $sql .= ",";
                    }
                }
                $sql .= " WHERE ".$this->id." = ".$this->getVar($this->id);
            }
            //echo $sql;
            $result = $this->db->query($sql);
            $this->afetadas = $this->db->getAffectedRows();
            if (!$result) {
                $this->setErrors("Erro ao gravar dados na Base de Dados. <br />".$this->db->error());
                return false;
            }
            if (is_null($this->getVar($this->id)) || $this->getVar($this->id) == 0) {
                $this->setVar($this->id, $this->db->getInsertId());
                return $this->db->getInsertId();
            }
            return $this->getVar($this->id);
        }

        function atualizaTodos($field, $valor, $criterio = null)
        {
            $set_clause = is_numeric($valor) ? $field.' = '.$valor : $field.' = '.$this->db->quoteString($valor);
            $sql = 'UPDATE '.$this->tabela.' SET '.$set_clause;
            if (isset($criterio) && is_subclass_of($criterio, 'criteriaelement')) {
                $sql .= ' '.$criterio->renderWhere();
            }
            if (!$result = $this->db->query($sql)) {
                return false;
            }
            return true;
        }

        function delete()
        {
            $sql = sprintf("DELETE FROM %s WHERE ".$this->id." = %u", $this->tabela, $this->getVar($this->id));
            if ( !$this->db->query($sql) ) {
                return false;
            }
            $this->afetadas = $this->db->getAffectedRows();
            return true;
        }

        function deletaTodos($criterio = null)
        {
            $sql = 'DELETE FROM '.$this->tabela;
            if (isset($criterio) && is_subclass_of($criterio, 'criteriaelement')) {
                $sql .= ' '.$criterio->renderWhere();
            }
            if (!$result = $this->db->query($sql)) {
                return false;
            }
            $this->afetadas = $this->db->getAffectedRows();
            return true;
        }

        function load($id)
        {
            $sql = "SELECT * FROM ".$this->tabela." WHERE ".$this->id."=".$id." LIMIT 1";
            $myrow = $this->db->fetchArray($this->db->query($sql));
            if (is_array($myrow) && count($myrow) > 0) {
                $this->assignVars($myrow);
                return true;
            }else{
                return false;
            }
        }

        function PegaTudo($criterio=null, $objeto=true, $join = null)
        {
            $ret = array();
            $limit = $start = 0;
            $classe = get_class($this);
            if ( !$objeto ) {
                $sql = 'SELECT '.$this->id.' FROM '.$this->tabela;
                if (isset($criterio) && is_subclass_of($criterio, 'criteriaelement')) {
                    $sql .= ' '.$criterio->renderWhere();
                    if ($criterio->getSort() != '') {
                        $sql .= ' ORDER BY '.$criterio->getSort().' '.$criterio->getOrder();
                    }
                    $limit = $criterio->getLimit();
                    $start = $criterio->getStart();
                }
                $result = $this->db->query($sql, $limit, $start);
                $this->total = $this->db->getRowsNum($result);
                if ($this->total > 0){
                    while ( $myrow = $this->db->fetchArray($result) ) {
                        $ret[] = $myrow[$this->id];
                    }
                    return $ret;
                }else{
                    return false;
                }
            } else {
                $sql = 'SELECT '.$this->tabela.'.* FROM '.$this->tabela.((!empty($join))? " ".$join : "");
                if (isset($criterio) && is_subclass_of($criterio, 'criteriaelement')) {
                    $sql .= ' '.$criterio->renderWhere();
                    if ($criterio->getSort() != '') {
                        $sql .= ' ORDER BY '.$criterio->getSort().' '.$criterio->getOrder();
                    }
                    $limit = $criterio->getLimit();
                    $start = $criterio->getStart();
                }
                $result = $this->db->query($sql, $limit, $start);
                $this->total = $this->db->getRowsNum($result);
                if ($this->total > 0){
                    while ( $myrow = $this->db->fetchArray($result) ) {
                        $ret[] = new $classe($myrow);
                    }
                    return $ret;
                }else{
                    return false;
                }
            }
        }
        function administration($url, $fields) {
            $criterio = new CriteriaCompo();
            if(!empty($fields['precrit']['field']) && !empty($fields['precrit']['valor'])){
                $precrit_hidden = "";
                $precrit_url = "";
                foreach ($fields['precrit']['field'] as $k=>$v) {
                    $hiddens[$v] = $fields['precrit']['valor'][$k];
                    $criterio->add(new Criteria($v, $fields['precrit']['valor'][$k], "=", $this->tabela));
                    $precrit_hidden .= "<input type='hidden' name='".$v."' value='".$fields['precrit']['valor'][$k]."'>";
                    $precrit_url .= "&".$v."=".$fields['precrit']['valor'][$k];
                }
            }else{
                $precrit_hidden = "";
                $precrit_url = "";
            }
            if(!empty($fields['checks']) && !empty($_POST['group_action']) && is_array($_POST['checks']) && $_POST['group_action'] == "group_del_ok"){
                $chks = $_POST['checks'];
                $classe = get_class($this);
                foreach ($chks as $k=>$v) {
                    $nova = new $classe($k);
                    if (!empty($fields['group_del_function']) && is_array($fields['group_del_function'])) {
                        foreach ($fields['group_del_function'] as $k=>$v)
                        $nova->$v();
                    }
                    $nova->delete();
                }
            }
            if (!empty($fields['checks']) && !empty($_POST['group_action']) && $_POST['group_action'] == "group_del" && is_array($_POST['checks'])) {
                $chks = $_POST['checks'];
                foreach ($chks as $k=>$v) {
                    $hiddens['checks['.$k.']'] = 1;
                }
                $hiddens['op'] = $fields['op'];
                $hiddens['group_action'] = 'group_del_ok';
                return xoops_confirm($hiddens, $url, $fields['lang']['group_del_sure'], _SUBMIT)."<br />";
            }
            $busca_url = '';
            if (!empty($_GET['busca'])) {
                foreach ($_GET['busca'] as $k => $v) {
                    if($v != '' && $v != '-1' && in_array($k, $fields['name'])){
                        if(is_numeric($v)){
                            $criterio->add(new Criteria($k, $v, "=", $this->tabela));
                        }elseif (is_array($v)){
                            if (!empty($v['dday']) || !empty($v['dmonth']) || !empty($v['dyear']) || !empty($v['aday']) || !empty($v['amonth']) || !empty($v['ayear'])) {
                                $dday = (!empty($v['dday'])) ? $v['dday'] : 1;
                                $dmonth = (!empty($v['dmonth'])) ? $v['dmonth'] : 1;
                                $dyear = (!empty($v['dyear'])) ? $v['dyear'] : 1;
                                $aday = (!empty($v['aday'])) ? $v['aday'] : 1;
                                $amonth = (!empty($v['amonth'])) ? $v['dmonth'] : 1;
                                $ayear = (!empty($v['ayear'])) ? $v['ayear'] : date("Y");
                                $ddate = mktime(0,0,0,$v['dmonth'], $v['dday'], $v['dyear']);
                                $adate = mktime(0,0,0,$v['amonth'], $v['aday'], $v['ayear']);
                                $criterio->add(new Criteria($k, $ddate, ">=", $this->tabela));
                                $criterio->add(new Criteria($k, $adate, "<=", $this->tabela));
                            }
                        }else{
                            $criterio->add(new Criteria($k, "%$v%",'LIKE', $this->tabela));
                        }
                        $busca_url .= (!is_array($v)) ? '&busca['.$k.']='.$v : '&busca['.$k.'][dday]='.$v['dday'].'&busca['.$k.'][dmonth]='.$v['dmonth'].'&busca['.$k.'][dyear]='.$v['dyear'].'&busca['.$k.'][aday]='.$v['aday'].'&busca['.$k.'][amonth]='.$v['amonth'].'&busca['.$k.'][ayear]='.$v['ayear'];
                    }
                }
            }
            $limit = (!empty($_GET['limit']) && $_GET['limit'] <= 100) ? $_GET['limit'] : 15;
            $criterio->setLimit($limit);
            $start = (empty($_GET['start'])) ? 0 : $_GET['start'];
            $criterio->setStart($start);
            $order = (empty($_GET['order'])) ? 'DESC' : $_GET['order'];
            $criterio->setOrder($order);
            $sort = (!empty($_GET['sort']) && in_array($_GET['sort'], $fields['name'])) ? $_GET['sort'] : ((empty($fields['sort'])) ? $fields['name'][1] : $fields['sort']);
            $criterio->setSort($sort);
            $form = (!empty($fields['form'])) ? 1 : 0;
            $checks = (!empty($fields['checks'])) ? 1 : 0;
            $op = (!empty($fields['op'])) ? $fields['op'] : '';
            $norder = ($order == "ASC") ? "DESC" : "ASC";
            $colunas = count($fields['label']);
            $colunas = (!empty($fields['checks'])) ? $colunas + 1 : $colunas;
            $colunas = (!empty($fields['buttons'])) ? $colunas + 1 : $colunas;
            $url_colunas = $url."?op=".$op."&limit=".$limit."&start=".$start.$busca_url.$precrit_url;
            $url_full_pg = $url."?op=".$op."&limit=".$limit."&sort=".$sort."&order=".$order.$busca_url.$precrit_url;
            $contar = $this->contar($criterio);
            $ret = '
		<style type="text/css">
		.hd {background-color: #c2cdd6; padding: 5px; font-weight: bold;}
		tr.bx td {background-color: #DFDFDF; padding: 5px; font-weight: bold; color: #000000}
		tr.hd td {background-image:url("images/bg.gif"); padding: 5px; font-weight: bold; border:1px solid #C0C0C0; color: #000000}
		tr.hd td.hds {background-image:url("images/bgs.gif"); padding: 5px; font-weight: bolder; border:1px solid #C0C0C0; border-top: 1px solid #000000; color: #000000}
		tr.hd td a{color: #1D5F9F}
		.fundo1 {background-color: #DFDFDF; padding: 4px;}
		tr.fundo1 td {background-color: #DFDFDF; padding: 4px; border:1px solid #C0C0C0;}
		.fundo2 {background-color: #E0E8EF; padding: 4px;}
		tr.fundo2 td {background-color: #E0E8EF; padding: 4px; border:1px solid #C0C0C0;}
		.neutro {background-color: #FFFFFF; padding: 4px;}
		tr.neutro td {background-color: #FFFFFF; padding: 4px; border:1px solid #9FD4FF;}
		</style>
		<script language="javascript" type="text/javascript">
	function exibe_esconde(tipo){
    var coisinha = document.getElementById(tipo);
   	if (coisinha.style.display == ""){
	     coisinha.style.display = "none";
   }
   else {
      coisinha.style.display = "";
   }
}
function esconde_menus(){
var els = document.getElementsByTagName("TD");
var elsLen = els.length;
var pattern = new RegExp("(^|\\s)bg5(\\s|$)");
	for (i = 0, j = 0; i < elsLen; i++) {
		if (pattern.test(els[i].className) && els[i].colSpan != 3 && els[i].colSpan != 4) {
			if(els[i].style.display==""){
			els[i].style.display="none";
			}else{
			els[i].style.display="";
			}
		}
	}
}
function changecheck(){
	var f = document.getElementById("update_form");
	var inputs = document.getElementsByTagName("input");
	for(var t = 0;t < inputs.length;t++){
		if(inputs[t].type == "checkbox" && inputs[t].id != "checkAll"){
		inputs[t].checked = !inputs[t].checked;
		inputs[t].onclick();
		}
	}
	return true;
}'.(($checks) ? '
function verificaChecks(){
var grp_sel = document.getElementById("group_action");
if(grp_sel.options[grp_sel.selectedIndex].value == 0) return true;
var inputs = document.getElementsByTagName("input");
	for(var t = 0;t < inputs.length;t++){
		if(inputs[t].type == "checkbox" && inputs[t].checked == true) return true;
	}
	alert("'.$fields['lang']['group_error_sel'].'");
	return false;
}
function marcaCheck(linha, ckbx, classe){
var tr = document.getElementById(linha);
var valor = document.getElementById(ckbx).checked;
//alert(tr.onmouseout);
if(valor == true){
tr.className = "neutro";
tr.onmouseout = function(){};
return true;
}else{
tr.className = classe;
tr.onmouseout = function(){this.className=classe};
return true;
}
}
</script>' : "</script>");
            $ret .= (!empty($fields['noadminmenu'])) ? '
		<script language="javascript" type="text/javascript">
if (window.addEventListener)
window.addEventListener("load", esconde_menus, false)
else if (window.attachEvent)
window.attachEvent("onload", esconde_menus)
</script>' : '';
            $ret .= '
<table width="100%" border="0" cellspacing="0" class="outer">
<tr><td style="padding:5px; font-size:16px; border: 1px solid #C0C0C0; border-bottom:0px"><div style="font-size:12px; text-align:right; float:right">'.((empty($fields['nofilters']))? ' <img border="0" src="../images/profile/occ2.gif" width="18" height="18"><a href="javascript:void(0);"  onclick="exibe_esconde(\'busca\');">'.$fields['lang']['filters'].'</a> &nbsp;&nbsp;<img border="0" src="../images/profile/occ2.gif" width="18" height="18"><a href="javascript:void(0);"  onclick="esconde_menus();">'.$fields['lang']['showhidemenu'].'</a>' : "").'</div><b>'.$fields['lang']['title'].'</b></td></tr>
<tr><td class="outer" style="background-color: #F3F2F2;"><div style="text-align: center;">';
            $ret .= "<form action='".$url."' method='GET' name='form_npag'>".$precrit_hidden."<b>".$fields['lang']['show']."&nbsp;&nbsp;<input type='text' name='limit' value='".$limit."' size='4' maxlength='3' style='text-align:center'>&nbsp;&nbsp;".$fields['lang']['perpage']."</b>";
            if (!empty($_GET['busca'])) {
                foreach ($_GET['busca'] as $k => $v) {
                    if($v != '' && $v != '-1' && !is_array($v)){
                        $ret .= "<input type='hidden' name='busca[".$k."]' value='".$v."'>";
                    }elseif (is_array($v)){
                        $ret .= "<input type='hidden' name='busca[".$k."][dday]' value='".$v['dday']."'>";
                        $ret .= "<input type='hidden' name='busca[".$k."][dmonth]' value='".$v['dmonth']."'>";
                        $ret .= "<input type='hidden' name='busca[".$k."][dyear]' value='".$v['dyear']."'>";
                        $ret .= "<input type='hidden' name='busca[".$k."][aday]' value='".$v['aday']."'>";
                        $ret .= "<input type='hidden' name='busca[".$k."][amonth]' value='".$v['amonth']."'>";
                        $ret .= "<input type='hidden' name='busca[".$k."][ayear]' value='".$v['ayear']."'>";
                    }
                }
            }
            $ret .= "<input type='hidden' name='op' value='".$op."'><input type='hidden' name='sort' value='".$sort."'><input type='hidden' name='order' value='".$order."'>";
            $ret .= "&nbsp;&nbsp;&nbsp;<input type='image' src='../images/icons/send.gif' style='border:0px; background-color:none' align='absmiddle'></form>";
            $ret .= "<table width='100%' border='0' cellspacing='0'>";
            $ret.= "<tbody><tr><td colspan='".$colunas."' align='right'>".sprintf($fields['lang']['showing'], $start+1, ((($start+$limit) < $contar) ? $start+$limit : $contar), $contar)."</td></tr></tbody>";
            $ret .= "<tbody><tr class='hd'>";
            $ret.= ($checks) ? "<td align='center'><input type='checkbox' name='checkAll' id='checkAll' onclick='changecheck();'></td>" : "" ;
            foreach ($fields['label'] as $k => $v) {
                $ret .= "<td nowrap='nowrap' align='center' ".(($sort == $fields['name'][$k] && empty($fields['nosort'][$k])) ? "class='hds'" : '').">".((empty($fields['nosort'][$k])) ? "<A HREF='".$url_colunas."&sort=".$fields['name'][$k]."&order=".$norder."'>".$v." ".(($sort == $fields['name'][$k]) ? "<img src='images/".$order.".gif' align='absmiddle'>" : '')."</a></td>" : $v."</td>");
            }
            $ret.= (!empty($fields['buttons'])) ? "<td align='center'>".$fields['lang']['action']."</td>" : "";
            $ret .="</tr></tbody>";
            if(empty($fields['nofilters'])){
                $ret.="<form action='".$url."' method='GET' name='form_busca'><tbody><tr id='busca' ".((!empty($_GET['busca'])) ? '' : "style='display:none'")." class='neutro'>";
                $ret.= ($checks) ? "<td>&nbsp;</td>" : "";
                foreach ($fields['label'] as $k => $v) {
                    $ret .= "<td align='center' nowrap='nowrap'>";
                    switch ($fields['type'][$k]){
                        case "none":
                            break;
                        case "date":
                            $ret.= "<input type='text' name='busca[".$fields['name'][$k]."][dday]' size='2' maxlength='2' value=".((!empty($_GET['busca'][$fields['name'][$k]]['dday'])) ? $_GET['busca'][$fields['name'][$k]]['dday'] : "")."> <input type='text' name='busca[".$fields['name'][$k]."][dmonth]' size='2' maxlength='2' value=".((!empty($_GET['busca'][$fields['name'][$k]]['dmonth'])) ? $_GET['busca'][$fields['name'][$k]]['dmonth'] : "")."> <input type='text' name='busca[".$fields['name'][$k]."][dyear]' size='2' maxlength='4' value=".((!empty($_GET['busca'][$fields['name'][$k]]['dyear'])) ? $_GET['busca'][$fields['name'][$k]]['dyear'] : "")."><br />";
                            $ret.= "<input type='text' name='busca[".$fields['name'][$k]."][aday]' size='2' maxlength='2' value=".((!empty($_GET['busca'][$fields['name'][$k]]['aday'])) ? $_GET['busca'][$fields['name'][$k]]['aday'] : "")."> <input type='text' name='busca[".$fields['name'][$k]."][amonth]' size='2' maxlength='2' value=".((!empty($_GET['busca'][$fields['name'][$k]]['amonth'])) ? $_GET['busca'][$fields['name'][$k]]['amonth'] : "")."> <input type='text' name='busca[".$fields['name'][$k]."][ayear]' size='2' maxlength='4' value=".((!empty($_GET['busca'][$fields['name'][$k]]['ayear'])) ? $_GET['busca'][$fields['name'][$k]]['ayear'] : "").">";
                            break;
                        case "select":
                            $ret.="<select name='busca[".$fields['name'][$k]."]'><option value='-1'>"._SELECT."</option>";
                            foreach ($fields['options'][$k] as $x => $y){
                                $ret.="< option value='".$x."'";
                                $ret.= (isset($_GET['busca'][$fields['name'][$k]]) && $_GET['busca'][$fields['name'][$k]] == $x) ? ' selected="selected"' : '';
                                $ret.=">".$y."</option>";
                            }
                            $ret.="</select>";
                            break;
                        case "simnao":
                            $ret.="<select name='busca[".$fields['name'][$k]."]'><option value='-1'>"._SELECT."</option>";
                            $ret.="< option value='1'";
                            $ret.= (isset($_GET['busca'][$fields['name'][$k]]) && $_GET['busca'][$fields['name'][$k]] == 1) ? ' selected="selected"' : '';
                            $ret.=">"._YES."</option>";
                            $ret.="< option value='0'";
                            $ret.= (isset($_GET['busca'][$fields['name'][$k]]) && $_GET['busca'][$fields['name'][$k]] == 0) ? ' selected="selected"' : '';
                            $ret.=">"._NO."</option>";
                            $ret.="</select>";
                            break;
                        case "text":
                        default:
                            $ret.="<input type='text' name='busca[".$fields['name'][$k]."]' value='".(isset($_GET['busca'][$fields['name'][$k]]) ? $_GET['busca'][$fields['name'][$k]] : '')."' size='".((isset($fields['size'][$k])) ? $fields['size'][$k]: 20)."'/>";
                    }
                    if (empty($fields['buttons']) && $k == count($fields['label'])) {
                        $ret .= " <input type='image' src='../images/icons/send.gif' style='border:0px; background-color:none' align='absmiddle'>";
                    }
                    $ret .= "</td>";
                }
                $ret.= (!empty($fields['buttons'])) ? "<td align='center'><input type='image' src='../images/icons/send.gif' style='border:0px; background-color:none'></td>" : "";
                $ret.="</tr></tbody>";
                $ret.= $precrit_hidden."<input type='hidden' name='op' value='".$op."'><input type='hidden' name='sort' value='".$sort."'><input type='hidden' name='order' value='".$order."'><input type='hidden' name='limit' value='".$limit."'></form>";
            }
            $registros = (empty($fields['join'])) ? $this->PegaTudo($criterio) : $this->PegaTudo($criterio, true, $fields['join']);
            if (!$registros || count($registros) == 0) {
                $ret.= "<tbody><tr><td colspan='".$colunas."'><h2>".$fields['lang']['semresult']."</h2></td></tr></tbody>";
                $ret.="<tbody><tr class='bx'><td colspan='".$colunas."' align='left'>".$this->pager($url_full_pg,$criterio, $precrit_url)."</td></tr></tbody>";
            }else{
                $ret.= ($form || $checks) ? "<form action='".$url."' method='POST' name='update_form' id='update_form' ".(($checks) ? "onsubmit='return verificaChecks()'" : "").">" : '';
                foreach ($registros as $reg) {
                    $eod = (!isset($eod) || $eod == "fundo1") ? "fundo2" : "fundo1";
                    $ret.= "<tbody><tr id='tr_reg_".$reg->getVar($reg->id)."' class='".$eod."' onmouseover='this.className=\"neutro\";' onmouseout='this.className=\"".$eod."\"'>";
                    $ret.= ($checks) ? "<td align='center'><input type='checkbox' name='checks[".$reg->getVar($reg->id)."]' id='checks[".$reg->getVar($reg->id)."]' value='1' onclick='marcaCheck(\"tr_reg_".$reg->getVar($reg->id)."\", \"checks[".$reg->getVar($reg->id)."]\", \"".$eod."\");'></td>" : "" ;
                    foreach ($fields['label'] as $l => $f){
                        $ret.= "<td>";
                        switch ($fields['type'][$l]){
                            case "none":
                                $ret.= (empty($fields['show'][$l])) ? $reg->getVar($fields['name'][$l]) : eval('return '.$fields["show"][$l].';');
                                break;
                            case "date":
                                $ret.= (!empty($fields['show'][$l]) ? eval('return '.$fields["show"][$l].';') : (($reg->getVar($fields['name'][$l]) != 0 && $reg->getVar($fields['name'][$l]) != "") ? date(_SHORTDATESTRING, $reg->getVar($fields['name'][$l])) : ""));
                                break;
                            case "select":
                                if($form && empty($fields['show'][$l])){
                                    $ret.="<select name='fields[".$reg->getVar($reg->id)."][".$fields['name'][$l]."]'>";
                                    foreach ($fields['options'][$l] as $x => $y){
                                        $ret.="<option value='".$x."'";
                                        $ret.= ($reg->getVar($fields['name'][$l]) == $x) ? ' selected="selected"' : '';
                                        $ret.=">".$y."</option>";
                                    }
                                    $ret.="</select>";
                                }elseif (!empty($fields['show'][$l])){
                                    $ret.= eval('return '.$fields["show"][$l].';');
                                }else{
                                    $ret.= 	(isset($fields['options'][$l][$reg->getVar($fields['name'][$l])])) ? $fields['options'][$l][$reg->getVar($fields['name'][$l])]:$reg->getVar($fields['name'][$l]) ;
                                }
                                break;
                            case "simnao":
                                if($form && empty($fields['show'][$l])){
                                    $ret.="<select name='fields[".$reg->getVar($reg->id)."][".$fields['name'][$l]."]'>";
                                    $ret.="<option value='1'";
                                    $ret.= ($reg->getVar($fields['name'][$l]) == 1) ? ' selected="selected"' : '';
                                    $ret.=">"._YES."</option>";
                                    $ret.="<option value='0'";
                                    $ret.= ($reg->getVar($fields['name'][$l]) == 0) ? ' selected="selected"' : '';
                                    $ret.=">"._NO."</option>";
                                    $ret.="</select>";
                                }elseif (!empty($fields['show'][$l])){
                                    $ret.= eval('return '.$fields["show"][$l].';');
                                }else{
                                    $ret.= ($reg->getVar($fields['name'][$l]) == 1) ? _YES : (($reg->getVar($fields['name'][$l]) == 0) ? _NO : $reg->getVar($fields['name'][$l]));
                                }
                                break;
                            case "text":
                            default:
                                $ret.= ($form && empty($fields['show'][$l])) ? "<input type='text' name='fields[".$reg->getVar($reg->id)."][".$fields['name'][$l]."]' value='".$reg->getVar($fields['name'][$l])."' size='".((isset($fields['size'][$l])) ? $fields['size'][$l]: 20)."'/>" : (!empty($fields['show'][$l]) ? eval('return '.$fields["show"][$l].';'): $reg->getVar($fields['name'][$l]));
                        }

                        $ret.="</td>";
                    }
                    //$ret.= "<td nowrap='nowrap'><a href='".$url."?op=".$op."_editar&".$reg->id."=".$reg->getVar($reg->id)."'><img src='../images/icons/edit.gif'></a> <a href='".$url."?op=".$op."_delete&".$reg->id."=".$reg->getVar($reg->id)."'><img src='../images/icons/dele.gif'></a> ".((!empty($fields['print'])) ? "<a href='".$url."?op=".$op."_imprime&".$reg->id."=".$reg->getVar($reg->id)."' target='_blank'><img src='../images/icons/imprime.gif'></a>" : '');
                    if(!empty($fields['buttons'])){
                        $ret.= "<td nowrap='nowrap'>";
                        if (is_array($fields['buttons'])) {
                            foreach ($fields['buttons'] as $b) {
                                $ret .= "<a href='".$b['link']."&".$reg->id."=".$reg->getVar($reg->id)."' title='".$b['text']."'><img src='".$b['image']."' alt='".$b['text']."'></a> ";
                            }
                        }
                        $ret.="</td>";
                    }
                    $ret.="</tr></tbody>";
                }
                if($form || $checks){
                    $ret.= "<tbody><tr><td colspan='".$colunas."'>";
                    $ret.= $precrit_hidden."<input type='hidden' name='sort' value='".$sort."'><input type='hidden' name='order' value='".$order."'><input type='hidden' name='limit' value='".$limit."'><input type='hidden' name='start' value='".$start."'>";
                    if (!empty($_GET['busca'])) {
                        foreach ($_GET['busca'] as $k => $v) {
                            if($v != '' && $v != '-1' && !is_array($v)){
                                $ret .= "<input type='hidden' name='busca[".$k."]' value='".$v."'>";
                            }elseif (is_array($v)){
                                $ret .= "<input type='hidden' name='busca[".$k."][dday]' value='".$v['dday']."'>";
                                $ret .= "<input type='hidden' name='busca[".$k."][dmonth]' value='".$v['dmonth']."'>";
                                $ret .= "<input type='hidden' name='busca[".$k."][dyear]' value='".$v['dyear']."'>";
                                $ret .= "<input type='hidden' name='busca[".$k."][aday]' value='".$v['aday']."'>";
                                $ret .= "<input type='hidden' name='busca[".$k."][amonth]' value='".$v['amonth']."'>";
                                $ret .= "<input type='hidden' name='busca[".$k."][ayear]' value='".$v['ayear']."'>";
                            }
                        }
                    }
                    $ret.="<input type='hidden' name='op' value='".$op."'>&nbsp;<br />";
                    if($checks){
                        $ret .= $fields['lang']['group_action'] . " <select name='group_action' id='group_action'><option value='0'>"._SELECT."</option>";
                        $ret .= (!empty($fields['group_del'])) ? "<option value='group_del'>".$fields['lang']['group_del']."</option>" : "";
                        if(!empty($fields['group_action'])){
                            foreach ($fields['group_action'] as $grp) {
                                $ret .= "<option value='".$grp['valor']."'>".$grp['text']."</option>";
                            }
                        }
                        $ret .= "</select> ";
                    }
                    $ret.="<input type='submit' value='"._SUBMIT."'><br />&nbsp;</td></tr></tbody></form>";
                }
                $ret.= (!empty($fields['soma'])) ? "<tbody><tr class='bx'><td colspan='".$colunas."' align='right'>Total: R$ ".number_format($this->soma($criterio, $fields['soma']), 2, ",", ".")."</td></tr></tbody>" : "";
                $ret.="<tbody><tr class='bx'><td colspan='".$colunas."' align='left'>".$this->pager($url_full_pg, $criterio, $precrit_url)."</td></tr></tbody>";
            }
            $ret.="</table></div></td></tr></table><br />";
            return $ret;
        }

        function contar($criterio=null){
            $sql = 'SELECT COUNT(*) FROM '.$this->tabela;
            if (isset($criterio) && is_subclass_of($criterio, 'criteriaelement')) {
                $sql .= ' '.$criterio->renderWhere();
            }
            $result = $this->db->query($sql);
            if (!$result) {
                return 0;
            }
            list($count) = $this->db->fetchRow($result);
            return $count;
        }

        function soma($criterio=null, $field){
            $sql = 'SELECT SUM('.$field.') FROM '.$this->tabela;
            if (isset($criterio) && is_subclass_of($criterio, 'criteriaelement')) {
                $sql .= ' '.$criterio->renderWhere();
            }
            $result = $this->db->query($sql);
            if (!$result) {
                return 0;
            }
            list($soma) = $this->db->fetchRow($result);
            return $soma;
        }

        // Retorna a pageção pronta
        function pager($link, $criterio=null, $precrit_url=null){
            $ret = '';
            $order = 'ASC';
            $sort = $this->id;
            if (isset($criterio) && is_subclass_of($criterio, 'criteriaelement')) {
                $limit = $criterio->getLimit();
                $start = $criterio->getStart();
                if ($criterio->getSort() != '') {
                    $order = $criterio->getOrder();
                    $sort = $criterio->getSort();
                }
            }else{
                $limit = 15;
                $start = 0;
            }
            $todos = $this->contar($criterio);
            $total = ($todos % $limit == 0) ? ($todos/$limit) : intval($todos/$limit)+1;
            $pg = ($start) ? intval($start/$limit)+1 : 1;
            $ret.= (!empty($_GET['busca'])) ? "<input type=button value='"._ALL."' onclick=\"document.location= '".$_SERVER['PHP_SELF']."?limit=".$limit."&order=".$order."&sort=".$sort."&op=".$GLOBALS["op"].$precrit_url."'\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            for($i=1;$i<=($total);$i++ )
            {
                $start = $limit * ($i-1);
                if($i == $pg){
                    $ret .=  "<span style='font-weight: bold; color: #CF0000; font-size: 15px;'> $i </span>";
                }elseif(($pg - 10) > $i){
                    if (!isset($pg1)) {
                        $ret .= ("<A HREF='".$link."&start=".$start."'>1</a>. . .");
                        $pg1 = true;
                    }
                    continue;
                }elseif ($i < ($pg + 10)){
                    $ret .= (" <A HREF='".$link."&start=".$start."'>".$i."</a> ");
                }else{
                    $ret .= (". . . <A HREF='".$link."&start=".(($todos % $limit == 0) ? $todos - $limit : $todos-($todos % $limit))."'>".$total."</a>");
                    break;
                }
                if( $i!=$total ){
                    $ret .= ("|");
                }
            }
            return $ret;
        }
    }
}
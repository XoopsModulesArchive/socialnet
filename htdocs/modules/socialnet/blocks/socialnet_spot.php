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

if (!defined('_MI_SOCIALNET_DIR')) {
    if ( file_exists(XOOPS_ROOT_PATH."/modules/socialnet/language/".$xoopsConfig['language']."/modinfo.php") ) {
        include_once(XOOPS_ROOT_PATH."/modules/socialnet/language/".$xoopsConfig['language']."/modinfo.php");
    } else {
        include_once(XOOPS_ROOT_PATH."/modules/socialnet/language/english/modinfo.php");
    }
}
include_once XOOPS_ROOT_PATH."/modules/socialnet/include/functionspot.inc.php";
function socialnet_spot_show($options){
    $sec_classe =& spot_getClass(_MI_SOCIALNET_TABLESECSECTION);
    $dstacs = $sec_classe->montaGaleria($options[1], $options[0], $options[2], $options[3], $options[4], $options[7]);
    if ($dstacs) {
        $block = array();
        $block['dstac'] = $dstacs;
        $block['spot_blo_bgcolor'] = $options[5];
        $block['spot_blo_txtcolor'] = $options[6];
        $block['spot_blo_section'] = $options[0];
    }else{
        return false;
    }
    return $block;
}
function socialnet_spot_edit($options){
    $picker_url = XOOPS_URL.'/modules/socialnet/admin/color_picker';
    $form = '
	<style type="text/css">
<!--
#plugin { BACKGROUND: #0d0d0d; COLOR: #AAA; CURSOR: move; DISPLAY: none; FONT-FAMILY: arial; FONT-SIZE: 11px; PADDING: 7px 10px 11px 10px; _PADDING-RIGHT: 0; Z-INDEX: 1;  POSITION: absolute; WIDTH: 199px; _width: 210px; _padding-right: 0px; }
#plugin br { CLEAR: both; MARGIN: 0; PADDING: 0;  }
#plugin select { BORDER: 1px solid #333; BACKGROUND: #FFF; POSITION: relative; TOP: 4px; }

#plugHEX { FLOAT: left; }
#plugCLOSE { CURSOR: pointer; FLOAT: right; MARGIN: 0 8px 3px; _MARGIN-RIGHT: 10px; COLOR: #FFF; -moz-user-select: none; -khtml-user-select: none; user-select: none; }
#plugHEX:hover,#plugCLOSE:hover { COLOR: #FFD000;  }

#SV { background: #FF0000 url("'.$picker_url.'/SatVal.png"); _BACKGROUND: #FF0000; POSITION: relative; CURSOR: crosshair; FLOAT: left; HEIGHT: 166px; WIDTH: 167px; _WIDTH: 165px; MARGIN-RIGHT: 10px; filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src="'.$picker_url.'/SatVal.png", sizingMethod="scale"); -moz-user-select: none; -khtml-user-select: none; user-select: none; }
#SVslide { BACKGROUND: url("'.$picker_url.'/slide.gif"); HEIGHT: 9px; WIDTH: 9px; POSITION: absolute; _font-size: 1px; line-height: 1px; }

#H { BORDER: 1px solid #000; CURSOR: crosshair; FLOAT: left; HEIGHT: 154px; POSITION: relative; WIDTH: 19px; PADDING: 0; TOP: 4px; -moz-user-select: none; -khtml-user-select: none; user-select: none; }
#Hslide { BACKGROUND: url("'.$picker_url.'/slideHue.gif"); HEIGHT: 5px; WIDTH: 33px; POSITION: absolute; _font-size: 1px; line-height: 1px; }
#Hmodel { POSITION: relative; TOP: -5px; }
#Hmodel div { HEIGHT: 1px; WIDTH: 19px; font-size: 1px; line-height: 1px; MARGIN: 0; PADDING: 0; }
-->
</style>
 <script src="'.$picker_url.'/plugin.js" type="text/JavaScript"></script>
 <script type="text/javascript">
var atual_color = "field_img";
var atual_field = "field";
function pegaPicker(field, e){
atual_color = field.name+"_img";
atual_field = field.name;
$S("plugin").left= (XY(e)-10)+"px";
$S("plugin").top= (XY(e,1)+10)+"px";
toggle("plugin");
updateH(field.value);
$("plugHEX").innerHTML=field.value
loadSV();
}

function mkColor(v) {
$S(atual_color).background="#"+v;
$(atual_field).value=v;
}
function troca(field, name){
if(field.checked){
$(name).value = 1;
}else{
$(name).value = 0;
}
}
</script>
	';
    $form .=
    <<< PICKER
	<div id="plugin" onmousedown="HSVslide('drag','plugin',event)" style="Z-INDEX: 20; display:none">
 <div id="plugHEX" onmousedown="stop=0; setTimeout('stop=1',100); toggle('plugin');">&nbsp</div><div id="plugCLOSE" onmousedown="toggle('plugin')">X</div><br>
 <div id="SV" onmousedown="HSVslide('SVslide','plugin',event)" title="Saturation + Value">
  <div id="SVslide" style="TOP: -4px; LEFT: -4px;"><br /></div>
 </div>
 <div id="H" onmousedown="HSVslide('Hslide','plugin',event)" title="Hue">
  <div id="Hslide" style="TOP: -7px; LEFT: -8px;"><br /></div>
  <div id="Hmodel"></div>
 </div>
</div>
PICKER;
    $sec_classe =& spot_getClass(_MI_SOCIALNET_TABLESECSECTION);
    $sec_todos = $sec_classe->pegaTudo();
    $sec_select = "<option value='0' ".(($options[0] == 0) ? "selected='selected'" : "").">"._ALL."</option>";
    if ($sec_todos) {
        foreach ($sec_todos as $v) {
            $sec_select .= "<option value='".$v->getVar($v->id)."' ".(($options[0] == $v->getVar($v->id)) ? "selected='selected'" : "").">".$v->getVar("sec_30_name")."</option>";
        }
    }
    $form .= _MB_SOCIALNET_SHOW_SECTION." <select name='options[0]'>".$sec_select."</select><br />";
    $form .= _MB_SOCIALNET_HEIGHTSPOTIMAGE." <input type='text' name='options[1]' value='".$options[1]."' /><br />";
    $form .= _MB_SOCIALNET_ARROWS."&nbsp;<input type='radio' name='options[2]' value='1'";
    if ( $options[2] == 1 ) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;"._YES."<input type='radio' name='options[2]' value='0'";
    if ( $options[2] == 0 ) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;"._NO."<br />";
    $form .= _MB_SOCIALNET_BAR."&nbsp;<input type='radio' name='options[3]' value='1'";
    if ( $options[3] == 1 ) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;"._YES."<input type='radio' name='options[3]' value='0'";
    if ( $options[3] == 0 ) {
        $form .= " checked='checked'";
    }
    $form .= " />&nbsp;"._NO."<br />";
    $form .= _MB_SOCIALNET_DELAY." <input type='text' name='options[4]' value='".$options[4]."' /><br />";
    $form .= _MB_SOCIALNET_BGCOLOR. ' #<input size="6" type="text" name="options[5]" id="options[5]" value="'.$options[5].'" onblur=\'$S(this.name+"_img").background="#"+this.value;\'><img id="options[5]_img" align="absmiddle" src="'.$picker_url.'/color.gif" onmouseover="this.style.border=\'2px solid black\'"  onmouseout="this.style.border=\'2px solid #DEE3E7\'" onclick=\'pegaPicker($("options[5]"), event)\' style="border: 2px solid #DEE3E7; background: #'.$options[5].'"><br />';
    $form .= _MB_SOCIALNET_TXTCOLOR. ' #<input size="6" type="text" name="options[6]" id="options[6]" value="'.$options[6].'" onblur=\'$S(this.name+"_img").background="#"+this.value;\'><img id="options[6]_img" align="absmiddle" src="'.$picker_url.'/color.gif" onmouseover="this.style.border=\'2px solid black\'"  onmouseout="this.style.border=\'2px solid #DEE3E7\'" onclick=\'pegaPicker($("options[6]"), event)\' style="border: 2px solid #DEE3E7; background: #'.$options[6].'"><br />';
    $form .= _MB_SOCIALNET_TRANSP." <input type='text' size='3' name='options[7]' value='".$options[7]."' />%<br />";
    return $form;
}
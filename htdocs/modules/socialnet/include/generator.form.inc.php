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

include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';
$picker_url = XOOPS_URL.'/modules/socialnet/admin/color_picker';


echo '
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

echo <<< PICKER
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
$sec_select = array();
if ($sec_todos) {
    foreach ($sec_todos as $v) {
        $sec_select[$v->getVar($v->id)] = $v->getVar("sec_30_name");
    }
}
$dstac_form = new XoopsThemeForm(_MD_SOCIALNET_FORM_TITLE, 'dstacform', $_SERVER['PHP_SELF'], 'post');
$section_select = new XoopsFormSelect(_MD_SOCIALNET_SECTION, "sec_10_id", ((!empty($sec_10_id)) ? $sec_10_id : null));
$section_select->addOptionArray($sec_select);
$dstac_form->addElement($section_select);
$dstac_form->addElement(new XoopsFormText(_MD_SOCIALNET_SPOTWIDTH, "spot_w", 5, 5, ((!empty($spot_w)) ? $spot_w : "100%")));
$dstac_form->addElement(new XoopsFormText(_MD_SOCIALNET_SPOTHEIGHT, "spot_h", 5, 5, ((!empty($spot_h)) ? $spot_h : 200)));
$dstac_form->addElement(new XoopsFormRadioYN(_MD_SOCIALNET_ARROWS, "arrows", ((isset($arrows)) ? $arrows : 1)));
$dstac_form->addElement(new XoopsFormRadioYN(_MD_SOCIALNET_BAR, "bar", ((isset($bar)) ? $bar : 1)));
$dstac_form->addElement(new XoopsFormText(_MD_SOCIALNET_DELAY, "delay", 5, 5, ((!empty($delay)) ? $delay : 6)));
$color_bar_tray = new XoopsFormElementTray(_MD_SOCIALNET_BARCOLOR);
$color_bar = new XoopsFormText("", "barcolor", 7, 6, ((!empty($barcolor)) ? $barcolor : "326801"));
$color_bar->setExtra('onblur=\'$S(this.name+"_img").background="#"+this.value;\'');
$color_bar_tray->addElement($color_bar);
$color_bar_tray->addElement(new XoopsFormLabel("", '<img id="barcolor_img" align="absmiddle" src="'.$picker_url.'/color.gif" onmouseover="this.style.border=\'2px solid black\'"  onmouseout="this.style.border=\'2px solid #DEE3E7\'" onclick=\'pegaPicker($("barcolor"), event)\' style="border: 2px solid #DEE3E7; background: #'.((!empty($barcolor)) ? $barcolor : "326801").'">'));
$dstac_form->addElement($color_bar_tray);

$color_text_tray = new XoopsFormElementTray(_MD_SOCIALNET_TEXTCOLOR);
$color_text = new XoopsFormText("", "textcolor", 7, 6, ((!empty($textcolor)) ? $textcolor : "FFFFFF"));
$color_text->setExtra('onblur=\'$S(this.name+"_img").background="#"+this.value;\'');
$color_text_tray->addElement($color_text);
$color_text_tray->addElement(new XoopsFormLabel("", '<img id="textcolor_img" align="absmiddle" src="'.$picker_url.'/color.gif" onmouseover="this.style.border=\'2px solid black\'"  onmouseout="this.style.border=\'2px solid #DEE3E7\'" onclick=\'pegaPicker($("textcolor"), event)\' style="border: 2px solid #DEE3E7; background: #'.((!empty($textcolor)) ? $textcolor : "FFFFFF").'">'));
$dstac_form->addElement($color_text_tray);
$transp_tray = new XoopsFormElementTray(_MD_SOCIALNET_TRANSP);
$transp_tray->addElement(new XoopsFormText("", "transp", 3, 3, ((!empty($transp)) ? $transp : 50)));
$transp_tray->addElement(new XoopsFormLabel("", "%"));
$dstac_form->addElement($transp_tray);
$align_select = new XoopsFormSelect(_MD_SOCIALNET_ALIGN, "align", ((!empty($align)) ? $align : "middle"));
$align_select->addOptionArray(array("middle"=>_MD_SOCIALNET_ALIGN_MIDDLE, "left"=>_MD_SOCIALNET_ALIGN_LEFT, "right"=>_MD_SOCIALNET_ALIGN_RIGHT));
$dstac_form->addElement($align_select);
$dstac_form->addElement(new XoopsFormButton("", "submit", _MD_SOCIALNET_GENERATE, "submit"));




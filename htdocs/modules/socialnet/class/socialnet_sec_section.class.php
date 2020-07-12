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
class socialnet_sec_section extends socialnet_geral {
    function socialnet_sec_section($id=null){
        $this->db =& Database::getInstance();
        $this->tabela = $this->db->prefix(_MI_SOCIALNET_TABLESECSECTION);
        $this->id = "sec_10_id";
        $this->initVar("sec_10_id", XOBJ_DTYPE_INT);
        $this->initVar("sec_30_name", XOBJ_DTYPE_TXTBOX);
        if ( !empty($id) ) {
            if ( is_array($id) ) {
                $this->assignVars($id);
            } else {
                $this->load(intval($id));
            }
        }

    }

    function contaDestaques($sec_10_id=null) {
        $id = (empty($sec_10_id)) ? $this->getVar($this->id) : $sec_10_id;
        $sec_dstac_query = $this->db->query("select count(*) as count from " . $this->db->prefix(_MI_SOCIALNET_TABLESPOTIMAGES) . " where sec_10_id = " . $id);
        $sec_query = $this->db->fetchArray($sec_dstac_query);
        return intval($sec_query['count']);
    }
    function montaGaleria($altura, $section = 0, $arrows = 1, $bar = 1, $delay = 6, $transp = 50, $largura="100%"){
        if ($section == 0) {
            $criterio = new CriteriaCompo(new Criteria("spot_12_ative", 1));
        }else{
            $criterio = new CriteriaCompo(new Criteria("sec_10_id", $section));
            $criterio->add(new Criteria("spot_12_ative", 1));
        }
        $go2_classe =& spot_getClass(_MI_SOCIALNET_TABLESPOTIMAGES);
        $dstacs = $go2_classe->PegaTudo($criterio);
        if (is_int($largura)) {
        	$largura = $largura."px";
        }
        if ($dstacs) {
            $ret = '
<script src="'.XOOPS_URL.'/modules/socialnet/js/mootools.js" type="text/javascript"></script>
<script src="'.XOOPS_URL.'/modules/socialnet/js/spotimages.js" type="text/javascript"></script>
<link rel="stylesheet" href="'.XOOPS_URL.'/modules/socialnet/css/spotimages.css" type="text/css" media="screen" />
<style type="text/css">
#dstacs_'.$section.'
{
width: '.$largura.' !important;
height: '.$altura.'px !important;
z-index:5;
display: none;
border: 0px;
}
</style>
<script type="text/javascript">
function start_dstacs_'.$section.'() {
var dstacs_'.$section.' = new gallery($("dstacs_'.$section.'"), {
timed: '.((count($dstacs) > 1) ? 'true' : 'false').',
showArrows: '.(($arrows == 1) ? 'true' : 'false').',
showInfopane: '.(($bar == 1) ? 'true' : 'false').',
delay: '.($delay*1000).',
slideInfoZoneOpacity: '.(($transp > 0) ? '0.'.intval(((100 - $transp) / 10)) : '1').',
embedLinks: true,
randomize: true
});
}
window.onDomReady(start_dstacs_'.$section.');
</script>
<!-- SocialNet - http://www.ipwgc.com/socialnet/ -->
			';
            $ret .= '<div align="center"><div id="dstacs_'.$section.'">';
            foreach ($dstacs as $v) {
                if ($v->getVar("spot_11_target") == 0) {
                	$target = "";
                }else{
                    $target = "target='_blank'";
                }
                $ret .= '<div class="imageElement">';
                $ret .= ($v->getVar('spot_30_name') != '') ? '<h3><a href="'.$v->pegaLink(false, false).'" title="'.$v->getVar("spot_30_name").'" '.$target.' class="open">'.$v->getVar('spot_30_name').'</a></h3>' : '<h3>&nbsp;</h3>';
                $ret .= '<p></p>';
                $ret .= $v->pegaLink(true);
                $ret .= '</div>';
            }
            $ret .= '</div></div>';
            return $ret;
        }else{
            return false;
        }
    }

}
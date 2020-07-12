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

if (!defined("XOOPS_ROOT_PATH")) {
    die("XOOPS root path not defined");
}

class SocialnetAddTo {

	var $_layout;
	var $_method;

	/**
	 * Constructor of SocialnetAddTo
	 *
	 * @param int $layout 0=Horizontal 1 row, 1=Horizontal 2 rows, 2=Vertical with icons, 3=Vertical no icons
	 * @param int $method 0=directpage, 1=popup
	 */
	function SocialnetAddTo($layout=0, $method=1) {
		$layout = intval($layout);
		if ($layout < 0 || $layout > 3) {
			$layout = 0;
		}
		$this->_layout = $layout;

		$method = intval($method);
		if ($method < 0 || $method > 1) {
			$method = 1;
		}
		$this->_method = $method;
	}

	function render($fetchOnly=false)
	{
		global $xoTheme, $xoopsTpl;

		$xoTheme->addStylesheet(SOCIALNET_URL . 'include/addto/addto.css');

		$xoopsTpl->assign('socialnet_addto_method', $this->_method);
		$xoopsTpl->assign('socialnet_addto_layout', $this->_layout);

		$xoopsTpl->assign('socialnet_addto_url', SOCIALNET_URL . 'include/addto/');

		if ($fetchOnly) {
			return $xoopsTpl->fetch('db:socialnet_addto.html' );
		} else {
			$xoopsTpl->display( 'db:socialnet_addto.html' );
		}
	}

	function renderForBlock()
	{
		global $xoTheme;

		$xoTheme->addStylesheet(SOCIALNET_URL . 'include/addto/addto.css');

		$block = array();
		$block['socialnet_addto_method'] = $this->_method;
		$block['socialnet_addto_layout'] = $this->_layout;
		$block['socialnet_addto_url'] = SOCIALNET_URL . 'include/addto/';

		return $block;
	}
}
?>
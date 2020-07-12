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
* This file contains the keyhighlighter class that highlight the chosen keyword in the current output buffer.
*
* @package keyhighlighter
*/

/**
* keyhighlighter class
*
* This class highlight the chosen keywords in the current output buffer
*
* @package keyhighlighter
* @author Setec Astronomy
* @version 1.0
* @abstract Highlight specific keywords.
* @copyright 2004
* @example sample.php A sample code.
* @link http://setecastronomy.stufftoread.com
*/

class keyhighlighter {

	/**
	* @access private
	*/
	var $preg_keywords = '';
	/**
	* @access private
	*/
	var $keywords = '';
	/**
	* @access private
	*/
	var $singlewords = false;
	/**
	* @access private
	*/
	var $replace_callback = null;

	var $content;

	/**
	* Main constructor
	*
	* This is the main constructor of keyhighlighter class. <br />
	* It's the only public method of the class.
	* @param string $keywords the keywords you want to highlight
	* @param boolean $singlewords specify if it has to highlight also the single words.
	* @param callback $replace_callback a custom callback for keyword highlight.
	* <code>
	* <?php
	* require ('socialnet_forumkeyhighlighter.class.php');
	*
	* function my_highlighter ($matches) {
	* 	return '<span style="font-weight: bolder; color: #FF0000;">' . $matches[0] . '</span>';
	* }
	*
	* new keyhighlighter ('W3C', false, 'my_highlighter');
	* readfile ('http://www.w3c.org/');
	* ?>
	* </code>
	*/
	// public function __construct ()
	function keyhighlighter ($keywords, $singlewords = false, $replace_callback = null ) {
		$this->keywords = $keywords;
		$this->singlewords = $singlewords;
		$this->replace_callback = $replace_callback;
	}

	/**
	* @access private
	*/
	function replace ($replace_matches) {

		$patterns = array ();
		if ($this->singlewords) {
			$keywords = explode (' ', $this->preg_keywords);
			foreach ($keywords as $keyword) {
				$patterns[] = '/(?' . '>' . $keyword . '+)/si';
			}
		} else {
			$patterns[] = '/(?' . '>' . $this->preg_keywords . '+)/si';
		}

		$result = $replace_matches[0];

		foreach ($patterns as $pattern) {
			if (!is_null ($this->replace_callback)) {
				$result = preg_replace_callback ($pattern, $this->replace_callback, $result);
			} else {
				$result = preg_replace ($pattern, '<span class="highlightedkey">\\0</span>', $result);
			}
		}

		return $result;
	}

	/**
	* @access private
	*/
	function highlight ($buffer) {
		$buffer = '>' . $buffer . '<';
		$this->preg_keywords = preg_replace ('/[^\w ]/si', '', $this->keywords);
		$buffer = preg_replace_callback ("/(\>(((?" . ">[^><]+)|(?R))*)\<)/is", array (&$this, 'replace'), $buffer);
		$buffer = xoops_substr($buffer, 1, -1);
		return $buffer;
	}
}

?>
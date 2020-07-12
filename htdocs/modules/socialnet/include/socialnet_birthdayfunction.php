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

function listday($name,$select=1) {
	$select--; // to have index in the picture
	$j = array ("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
	$stop = count ($j);
	$list="<select name='$name'>";
	for ($i=0; $i< $stop; $i++) {
		if ($select==$i)
			$list.="<option value='$j[$i]' selected>$j[$i]</option>";		
		else
			$list.="<option value='$j[$i]'>$j[$i]</option>";
	}
    $list.="</select>";
	return $list;
}

function listmonth($name,$select=1) {
	$select--; // to have indication in the picture
	$nom = array ("January","February","March","April","May","June","July","August","September","October","November","December");
	$m = array ("01","02","03","04","05","06","07","08","09","10","11","12");
	$list="<select name=\"$name\">";
	for ($i=0; $i< count($m); $i++) {
		if ($select==$i)
			$list.="<option value=\"$m[$i]\" selected>$nom[$i]</option>";
		else
			$list.="<option value=\"$m[$i]\">$nom[$i]</option>";
	}
    $list.="</select>";
	return $list;
}

function listyear ($name, $fin, $select="1930") {
	$list = "<select name=\"$name\">";
	for ($i=1930; $i<=$fin; $i++) {
		if ($select==$i) {
			$list.="<option value=\"$i\" selected>$i</option>";
		} else {
			$list.="<option value=\"$i\">$i</option>";
		}
	}
	$list.="</select>";
	return $list;
}
?>
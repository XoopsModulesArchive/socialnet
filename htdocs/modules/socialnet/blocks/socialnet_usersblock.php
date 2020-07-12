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

if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

function user_block($options) {

    global $xoopsConfig, $xoopsUser, $xoopsModule, $xoopsDB, $_SERVER;

	$online_handler =& xoops_gethandler('online');
	mt_srand((double)microtime()*1000000);
	$block = array();
	if (mt_rand(1, 100) < 11) {
		$online_handler->gc(300);
	}


	if (is_object($xoopsUser)) {
		$uid = $xoopsUser->getVar('uid');
		$uname = $xoopsUser->getVar('uname');
		$user = $xoopsUser->getVar('uname');

		$pm_handler =& xoops_gethandler('privmessage');
		$criteria = new CriteriaCompo(new Criteria('read_msg', 0));
		$criteria->add(new Criteria('to_userid', $xoopsUser->getVar('uid')));
		$messagesnumber = $pm_handler->getCount($criteria);
		$rankclase=$xoopsUser->rank();

		$block['rankimagen']=$rankclase['image'];
		$block['ranktitle']=$rankclase['title'];
		$block['avatar_user']=$xoopsUser->getVar('user_avatar');
		$block['messagesnumber']=$messagesnumber;
		$block['lang_changeavatar']= _MB_CHANGE_AVATAR;
		$block['lang_profileuser']= _MB_PROFILE;
		$block['img_profileuser']= XOOPS_URL . '/modules/socialnet/images/users/profile.gif';
		$block['lang_editaccount']= _MB_EDITACCOUNT;
		$block['img_edit']= XOOPS_URL . '/modules/socialnet/images/icons/edit.gif';
		$block['lang_messages']= _MB_PRIVATEMESSAGES;
		$block['img_messages']= XOOPS_URL . '/modules/socialnet/images/users/messages.gif';
		$block['lang_messagesnew']= _MB_MESSAGESNEW;
		$block['img_messagesnew']= XOOPS_URL . '/modules/socialnet/images/users/newemail.gif';
		$block['lang_notifications']= _MB_NOTIFICATIONS;
		$block['img_notifications']= XOOPS_URL . '/modules/socialnet/images/users/notifications.gif';
		$block['lang_administration']= _MB_ADMINISTRATION;
		$block['img_administration']= XOOPS_URL . '/modules/socialnet/images/users/administration.gif';
		$block['lang_disconnect']= _MB_DISCONNECT;		
		$block['img_disconnect']= XOOPS_URL . '/modules/socialnet/images/users/disconnect.gif';		
		$block['lang_languagetool']= _MB_LANGUAGETOOL;
		$block['img_languagetool']= XOOPS_URL . '/modules/socialnet/images/profile/occ2.gif';
		$block['lang_whocansee']= _MB_WHOCANSEE;
		$block['img_whocansee']= XOOPS_URL . '/modules/socialnet/images/menu/good.gif';
		$block['lang_mybirthday']= _MB_MYBIRTHDAY;
		$block['img_mybirthday']= XOOPS_URL . '/modules/socialnet/images/users/yesterday.gif';
		$block['lang_buddyfriends']= _MB_BUDDYFRIENDS;
		$block['img_buddyfriends']= XOOPS_URL . '/modules/socialnet/images/menu/friends.gif';

	} else {
		$uid = 0;
		$uname = '';
		$user=_MB_GUESTS;
		$block['lang_login'] = _MB_LOGIN;
		$block['lang_user'] = _MB_USER;
		$block['lang_enter'] = _MB_ENTER;
		//$block['lang_rememberme'] = _MB_REMEMBERME;
        if ($xoopsConfig['use_ssl'] == 1 && $xoopsConfig['sslloginlink'] != '') {
            $block['sslloginlink'] = "<a href=\"javascript:openWithSelfMain('".$xoopsConfig['sslloginlink']."', 'ssllogin', 300, 200);\">"._MB_SYSTEM_SECURE."</a>";
        } elseif ($xoopsConfig['usercookie']) {
            $block['lang_rememberme'] = _MB_REMEMBERME;
        }
		$block['lang_registratedsc'] = _MB_REGISTERDSC;
		$block['lang_register'] = '<a href=\"'.XOOPS_URL.'/register.php" title="'._MB_REGISTERDSC.'">'._MB_REGISTER.'</a>';
		$block['forgotpass']= '<a href="'.XOOPS_URL.'/user.php#lost" title="'._TIP_FORGOT_PASS.'">'._MB_FORGOT_PASS.'</a>';
			}
	
	if (is_object($xoopsModule)) {
		$online_handler->write($uid, $uname, time(), $xoopsModule->getVar('mid'), $_SERVER['REMOTE_ADDR']);
	} else {
		$online_handler->write($uid, $uname, time(), 0, $_SERVER['REMOTE_ADDR']);
	}
	$onlines =& $online_handler->getAll();
	$module_handler =& xoops_gethandler('module');
	$modules =& $module_handler->getList(new Criteria('isactive', 1));
	if (false != $onlines) {
		$total = count($onlines);
		$guests = 0;
		$members = '';
		$guestsip='';
		$bots = 0;
		$findbot  = 'crawl';
		$findsearch = 'search';

		include_once XOOPS_ROOT_PATH . '/modules/socialnet/include/geoip.inc';
		$gi = geoip_open(XOOPS_ROOT_PATH . "/modules/socialnet/include/GeoIP.dat",GEOIP_STANDARD);
		for ($i = 0; $i < $total; $i++) {
			if ($onlines[$i]['online_uid'] > 0) {
				$flag = strtolower(geoip_country_code_by_addr($gi, $onlines[$i]['online_ip']));

				if (!$flag) {$flag="online";}
				$onlineUsers[$i]['module'] = ($onlines[$i]['online_module'] > 0) ? $modules[$onlines[$i]['online_module']] : '';
				$members .= '<tr><td><img src="'.XOOPS_URL.'/modules/socialnet/images/flags/'.$flag.'.gif" alt="'.$flag.'" title="'.$flag.'" /></td><td><a href="'.XOOPS_URL.'/userinfo.php?uid='.$onlines[$i]['online_uid'].'"><small>'.$onlines[$i]['online_uname'].'</small></a></td><td><small>'.$onlineUsers[$i]['module'].'</small></td></tr>';
			
			} else {
				$flag = strtolower(geoip_country_code_by_addr($gi, $onlines[$i]['online_ip']));
				$hostname = strtolower(gethostbyaddr($onlines[$i]['online_ip']));
				
				if (!$flag) {$flag="online";}

				$pos1 = strpos($hostname, $findbot);
                $pos2 = strpos($hostname, $findsearch);

				if ($xoopsUser)	{ 
					if ($xoopsUser->isAdmin(-1)) {$direccionip=$onlines[$i]['online_ip'];}
					else {$direccionip= _MB_GUEST;}
				} else {
					$direccionip= _MB_GUEST;
				}

				//if is bot
				if ($pos1 !== false || $pos2 !== false) {
					$guestsip .= '<tr><td><img src="'.XOOPS_URL.'/modules/socialnet/images/flags/bots.gif" alt="bot" title="bot" /></td><td><small>'.$direccionip.'</small></td><td><small>'.$onlineUsers[$i]['module'].'</small</td></tr>';
					$bots++;
                } else {
					$onlineUsers[$i]['module'] = ($onlines[$i]['online_module'] > 0) ? $modules[$onlines[$i]['online_module']] : '';
					$guestsip .= '<tr><td><img src="'.XOOPS_URL.'/modules/socialnet/images/flags/'.$flag.'.gif" alt="'.$flag.'" title="'.$flag.'"/></td><td><small>'.$direccionip.'</small></td><td><small>'.$onlineUsers[$i]['module'].'</small></td></tr>';
				}

				$guests++;
			}
			
		}
		geoip_close($gi);
		
	$member_handler =& xoops_gethandler('member');
	$hari_ini = formatTimestamp(time());
	$users_registered = $member_handler->getUserCount(new Criteria('level', 0, '>'));
	$registered_today = $member_handler->getUserCount(new Criteria('user_regdate', mktime(0,0,0), '>='));
	$registered_desdeyesterday = $member_handler->getUserCount(new Criteria('user_regdate', (mktime(0,0,0)-(24*3600)), '>='));
	$criteria = new CriteriaCompo(new Criteria('level', 0, '>'));
	$criteria->setOrder('DESC');
	$criteria->setSort('user_regdate');
	$criteria->setLimit($options['5']);
	$newmiemb =& $member_handler->getUsers($criteria);
	$last_registered = $newmiemb[0]->getVar('uname');
	$count = count($newmiemb);
	$newmembers='<b>'._MB_NEWMEMBERS.':</b> ';
	for ($i = 0; $i < $count; $i++)
	{
			$newmembers.='<small>[<span style="text-transform: uppercase">'.$newmiemb[$i]->getVar('uname').'</span>-<i>'.formatTimestamp($newmiemb[$i]->getVar('user_regdate'), 's').'</i></small>] ';
	}
	
		$members.=$guestsip;
		if ($xoopsConfig['use_ssl'] == 1 && $xoopsConfig['sslloginlink'] != '')
			{
			$block['sslloginlink'] = "<a href=\"javascript:openWithSelfMain('".$xoopsConfig['sslloginlink']."', 'ssllogin', 300, 200);\">"._MB_SYSTEM_SECURE."</a>";
			}
		$block['lang_welcome']=_MB_WELCOME;
		$block['lang_conected']=_MB_CONECTED;
		$block['lang_members']=_MB_MEMBERS;
		$block['lang_guests']=_MB_GUESTS;
		$block['lang_bots']=_MB_BOTS;
		$block['lang_menuuser'] = _MB_MENUUSER;
		$block['lang_online'] = _MB_ONLINE;
		$block['lang_messagepop']=_MB_MESSAGEPOP;
		$block['lang_stats']=_MB_STATS;
		$block['lang_registered']=_MB_REGISTERED;
		$block['lang_today']=_MB_TODAY;
		$block['lang_yesterday']=_MB_YESTERDAY;
		$block['online_total'] = $total;
		$block['online_names'] = $members;
		$block['online_members'] = $total - $guests;
		$block['online_guests'] = $guests - $bots;
		$block['online_bots'] = $bots;
		$block['user']=$user;
		$block['newmembers']=$newmembers;
		$block['seeavatar'] = $options[0];
		$block['seeconected'] = $options[1];
		$block['seepopup'] = $options[2];
		$block['statsreg'] = $options[3];
		$block['lastuser'] = $options[4];
		$block['usersregistered']=$users_registered;
		$block['registeredtoday']=$registered_today;
		$block['registeredyesterday']=$registered_desdeyesterday - $registered_today;
		$block['last']=$last_registered;
		$block['lang_homepage']= _MB_HOMEPAGE;
		$block['img_homepage']= XOOPS_URL . '/modules/socialnet/images/users/homepage.gif';
		$block['lang_favorite']= _MB_FAVORITE;
		$block['img_favorite']= XOOPS_URL . '/modules/socialnet/images/users/favorite.gif';

return $block;
	} else {
		return false;
	}
}

function user_options($options) {

    if (!$options[5] || (isset($_GET['op']) && $_GET['op'] == 'clone')) $options[5] = time();

	//See Avatar
	$form = _MB_SEEAVATAR."&nbsp;";
	if ( $options[0] == 1 ) {
		$chk = " checked='checked'";
	}
	$form .= "<input type='radio' name='options[0]' value='1'".$chk." />&nbsp;"._YES."";
	$chk = "";
	if ( $options[0] == 0 ) {
		$chk = " checked='checked'";
	}
	$form .= "&nbsp;<input type='radio' name='options[0]' value='0'".$chk." />"._NO."<br />";

	//See conected
	$form .= _MB_SEECONNECTED."&nbsp;";
	if ( $options[1] == 1 ) {
		$chk = " checked='checked'";
	}
	$form .= "<input type='radio' name='options[1]' value='1'".$chk." />&nbsp;"._YES."";
	$chk = "";
	if ( $options[1] == 0 ) {
		$chk = " checked='checked'";
	}
	$form .= "&nbsp;<input type='radio' name='options[1]' value='0'".$chk." />"._NO."<br />";

	//Ver PopUp
	$form .= _MB_POPUP."&nbsp;";
	if ( $options[2] == 1 ) {
		$chk = " checked='checked'";
	}
	$form .= "<input type='radio' name='options[2]' value='1'".$chk." />&nbsp;"._YES."";
	$chk = "";
	if ( $options[2] == 0 ) {
		$chk = " checked='checked'";
	}
	$form .= "&nbsp;<input type='radio' name='options[2]' value='0'".$chk." />"._NO."<br />";

	//See Stats
	$form .= _MB_SHOWSTATS."&nbsp;";
	if ( $options[3] == 1 ) {
		$chk = " checked='checked'";
	}
	$form .= "<input type='radio' name='options[3]' value='1'".$chk." />&nbsp;"._YES."";
	$chk = "";
	if ( $options[3] == 0 ) {
		$chk = " checked='checked'";
	}
	$form .= "&nbsp;<input type='radio' name='options[3]' value='0'".$chk." />"._NO."<br />";

	//See Last users registered
	$form .= _MB_LASTUSERS."&nbsp;";
	if ( $options[4] == 1 ) {
		$chk = " checked='checked'";
	}
	$form .= "<input type='radio' name='options[4]' value='1'".$chk." />&nbsp;"._YES."";
	$chk = "";
	if ( $options[4] == 0 ) { 
		$chk = " checked='checked'";
	}
	$form .= "&nbsp;<input type='radio' name='options[4]' value='0'".$chk." />"._NO."<br />";

	//See Last users registered (quantity)
	
	$form .= _MB_QUANTITY."&nbsp;";
	$form .= "<input type='text' name='options[5]' value='".$options[5]."'/>";

	return $form;
}

?>
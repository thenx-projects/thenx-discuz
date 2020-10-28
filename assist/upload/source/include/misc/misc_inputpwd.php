<?php
/*
 *
 *  * Copyright 2012-2020 the original author or authors.
 *  *
 *  * Licensed under the Apache License, Version 2.0 (the "License");
 *  * you may not use this file except in compliance with the License.
 *  * You may obtain a copy of the License at
 *  *
 *  *      https://www.apache.org/licenses/LICENSE-2.0
 *  *
 *  * Unless required by applicable law or agreed to in writing, software
 *  * distributed under the License is distributed on an "AS IS" BASIS,
 *  * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  * See the License for the specific language governing permissions and
 *  * limitations under the License.
 *
 */

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: misc_inputpwd.php 24741 2011-10-10 03:41:51Z chenmengshu $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if(submitcheck('pwdsubmit')) {

	$blogid = empty($_POST['blogid'])?0:intval($_POST['blogid']);
	$albumid = empty($_POST['albumid'])?0:intval($_POST['albumid']);

	$itemarr = array();
	if($blogid) {
		if (!$_G['setting']['blogstatus']) {
			showmessage('blog_status_off');
		}
		$itemarr = C::t('home_blog')->fetch($blogid);
		$itemurl = "home.php?mod=space&uid=$itemarr[uid]&do=blog&id=$itemarr[blogid]";
		$cookiename = 'view_pwd_blog_'.$blogid;
	} elseif($albumid) {
		if (!$_G['setting']['albumstatus']) {
			showmessage('album_status_off');
		}
		$itemarr = C::t('home_album')->fetch($albumid);
		$itemurl = "home.php?mod=space&uid=$itemarr[uid]&do=album&id=$itemarr[albumid]";
		$cookiename = 'view_pwd_album_'.$albumid;
	}

	if(empty($itemarr)) {
		showmessage('news_does_not_exist');
	}

	if($itemarr['password'] && $_POST['viewpwd'] == $itemarr['password']) {
		dsetcookie($cookiename, md5(md5($itemarr['password'])));
		showmessage('proved_to_be_successful', $itemurl, array('succeed'=>1), array('showmsg'=>1, 'timeout'=>1));
	} else {
		showmessage('password_is_not_passed', $itemurl, array('succeed'=>0), array('showmsg'=>1));
	}
}

?>
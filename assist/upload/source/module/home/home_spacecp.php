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
 *      $Id: home_spacecp.php 33660 2013-07-29 07:51:05Z nemohou $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once libfile('function/spacecp');
require_once libfile('function/magic');

$acs = array('doing', 'upload', 'comment', 'blog', 'album', 'common', 'class',
	'swfupload', 'poke', 'friend', 'eccredit', 'favorite', 'follow',
	'avatar', 'profile', 'theme', 'feed', 'privacy', 'pm', 'share', 'invite','sendmail',
	'credit', 'usergroup', 'domain', 'click','magic', 'top', 'videophoto', 'index', 'plugin', 'search', 'promotion');

$_GET['ac'] = $ac = (empty($_GET['ac']) || !in_array($_GET['ac'], $acs))?'profile':$_GET['ac'];
$op = empty($_GET['op'])?'':$_GET['op'];
if(!in_array($ac, array('doing', 'upload', 'blog', 'album'))) {
	$_G['mnid'] = 'mn_common';
}


if($ac != 'comment' || !$_G['group']['allowcomment']) {
	if(empty($_G['uid'])) {
		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			dsetcookie('_refer', rawurlencode($_SERVER['REQUEST_URI']));
		} else {
			dsetcookie('_refer', rawurlencode('home.php?mod=spacecp&ac='.$ac));
		}
		showmessage('to_login', '', array(), array('showmsg' => true, 'login' => 1));
	}

	$space = getuserbyuid($_G['uid']);
	if(empty($space)) {
		showmessage('space_does_not_exist');
	}
	space_merge($space, 'field_home');

	if(($space['status'] == -1 || in_array($space['groupid'], array(4, 5, 6))) && $ac != 'usergroup') {
		showmessage('space_has_been_locked');
	}
}
$actives = array($ac => ' class="a"');

list($seccodecheck, $secqaacheck) = seccheck('publish');

$navtitle = lang('core', 'title_setup');
if(lang('core', 'title_memcp_'.$ac)) {
	$navtitle = lang('core', 'title_memcp_'.$ac);
}

$_G['disabledwidthauto'] = 0;

require_once libfile('spacecp/'.$ac, 'include');

?>
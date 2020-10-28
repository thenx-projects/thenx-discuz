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
 *      $Id: search.php 34131 2013-10-17 03:54:09Z andyzheng $
 */

define('APPTYPEID', 0);
define('CURSCRIPT', 'search');

require './source/class/class_core.php';

$discuz = C::app();

$modarray = array('user', 'curforum', 'newthread');

$cachelist = $slist = array();
$mod = '';
$discuz->cachelist = $cachelist;
$discuz->init();

if(in_array($discuz->var['mod'], $modarray) || !empty($_G['setting']['search'][$discuz->var['mod']]['status'])) {
	$mod = $discuz->var['mod'];
} else {
	foreach($_G['setting']['search'] as $mod => $value) {
		if(!empty($value['status'])) {
			break;
		}
	}
}
if(empty($mod)) {
	showmessage('search_closed');
}
define('CURMODULE', $mod);


runhooks();

if (!$_G['setting'][($mod == 'curforum' ? 'forum' : ($mod == 'user' ? 'friend' : $mod)).'status']) {
	showmessage(($mod == 'curforum' ? 'forum' : ($mod == 'user' ? 'friend' : ($mod == 'group' ? 'group_module' : $mod))).'_status_off');
}

require_once libfile('function/search');


$navtitle = lang('core', 'title_search');

if($mod == 'curforum') {
	$mod = 'forum';
	$_GET['srchfid'] = array($_GET['srhfid']);
} elseif($mod == 'forum') {
	$_GET['srhfid'] = 0;
}

require DISCUZ_ROOT.'./source/module/search/search_'.$mod.'.php';

?>
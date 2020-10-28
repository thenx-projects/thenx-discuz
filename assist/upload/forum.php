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
 *      $Id: forum.php 33828 2013-08-20 02:29:32Z nemohou $
 */


define('APPTYPEID', 2);
define('CURSCRIPT', 'forum');


require './source/class/class_core.php';


require './source/function/function_forum.php';


$modarray = array('ajax','announcement','attachment','forumdisplay',
	'group','image','index','misc','modcp','post','redirect',
	'rss','topicadmin','trade','viewthread','tag','collection','guide'
);

$modcachelist = array(
	'index'		=> array('announcements', 'onlinelist', 'forumlinks',
			'heats', 'historyposts', 'onlinerecord', 'userstats', 'diytemplatenameforum'),
	'forumdisplay'	=> array('smilies', 'announcements_forum', 'globalstick', 'forums',
			'onlinelist', 'forumstick', 'threadtable_info', 'threadtableids', 'stamps', 'diytemplatenameforum'),
	'viewthread'	=> array('smilies', 'smileytypes', 'forums', 'usergroups',
			'stamps', 'bbcodes', 'smilies',	'custominfo', 'groupicon', 'stamps',
			'threadtableids', 'threadtable_info', 'posttable_info', 'diytemplatenameforum'),
	'redirect'	=> array('threadtableids', 'threadtable_info', 'posttable_info'),
	'post'		=> array('bbcodes_display', 'bbcodes', 'smileycodes', 'smilies', 'smileytypes',
			'domainwhitelist', 'albumcategory'),
	'space'		=> array('fields_required', 'fields_optional', 'custominfo'),
	'group'		=> array('grouptype', 'diytemplatenamegroup'),
	'topicadmin'	=> array('usergroups'),
);

$mod = !in_array(C::app()->var['mod'], $modarray) ? 'index' : C::app()->var['mod'];

define('CURMODULE', $mod);
$cachelist = array();
if(isset($modcachelist[CURMODULE])) {
	$cachelist = $modcachelist[CURMODULE];

	$cachelist[] = 'plugin';
	$cachelist[] = 'pluginlanguage_system';
}
if(C::app()->var['mod'] == 'group') {
	$_G['basescript'] = 'group';
}

C::app()->cachelist = $cachelist;
C::app()->init();

if(!$_G['setting']['forumstatus'] && !in_array($mod, array('ajax', 'misc', 'modcp'))) {
	showmessage('forum_status_off');
}

loadforum();

set_rssauth();

runhooks();

$navtitle = str_replace('{bbname}', $_G['setting']['bbname'], $_G['setting']['seotitle']['forum']);
$_G['setting']['threadhidethreshold'] = 1;
require DISCUZ_ROOT.'./source/module/forum/forum_'.$mod.'.php';

?>
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
 *      $Id: space_wall.php 29522 2012-04-17 09:39:32Z chenmengshu $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if (!$_G['setting']['wallstatus']) {
	showmessage('wall_status_off');
}

$perpage = 20;
$perpage = mob_perpage($perpage);

$page = empty($_GET['page'])?1:intval($_GET['page']);
if($page<1) $page=1;
$start = ($page-1)*$perpage;

ckstart($start, $perpage);

$theurl = "home.php?mod=space&uid=$space[uid]&do=$do";

$diymode = 1;

$cid = empty($_GET['cid'])?0:intval($_GET['cid']);

$list = array();
$count = C::t('home_comment')->count_by_id_idtype($space['uid'], 'uid', $cid);
if($count) {
	$query = C::t('home_comment')->fetch_all_by_id_idtype($space['uid'], 'uid', $start, $perpage, $cid, 'DESC');
	foreach($query as $value) {
		$list[] = $value;
	}
}

$multi = multi($count, $perpage, $page, $theurl);

$navtitle = lang('space', 'sb_wall', array('who' => $space['username']));
$metakeywords = lang('space', 'sb_wall', array('who' => $space['username']));
$metadescription = lang('space', 'sb_wall', array('who' => $space['username']));

dsetcookie('home_diymode', 1);

include_once template("home/space_wall");

?>
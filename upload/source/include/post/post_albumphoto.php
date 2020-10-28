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
 *      $Id: post_albumphoto.php 25246 2011-11-02 03:34:53Z zhangguosheng $
 */
if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

include_once libfile('function/home');
$perpage = 8;
$page = max(1, $_GET['page']);
$start_limit = ($page - 1) * $perpage;
$aid = intval($_GET['aid']);
$photolist = array();
$query = C::t('home_album')->fetch_all_by_uid($_G['uid'], false, 0, 0, $aid);
$count = $query[0]['picnum'];
$query = C::t('home_pic')->fetch_all_by_albumid($aid, $start_limit, $perpage, 0, 0, 1);
foreach($query as $value) {
	$value['bigpic'] = pic_get($value['filepath'], 'album', $value['thumb'], $value['remote'], 0);
	$value['pic'] = pic_get($value['filepath'], 'album', $value['thumb'], $value['remote']);
	$value['count'] = $count;
	$value['url'] = (preg_match('/^https?:\/\//is', $value['bigpic']) ? '' : $_G['siteurl']) . $value['bigpic'];
	$value['thumburl'] = (preg_match('/^https?:\/\//is', $value['pic']) ? '' : $_G['siteurl']) . $value['pic'];
	$photolist[] = $value;
}
$_GET['ajaxtarget'] = 'albumphoto';
$multi = multi($count, $perpage, $page, "forum.php?mod=post&action=albumphoto&aid=$aid");
include template('forum/ajax_albumlist');
exit;
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
 *      $Id: cron_todayviews_daily.php 26812 2011-12-23 08:21:29Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$updateviews = array();
$deltids = array();
foreach(C::t('forum_threadaddviews')->fetch_all_order_by_tid(500) as $tid => $addview) {
	$deltids[$tid] = $updateviews[$addview['addviews']][] = $tid;
}
if($deltids) {
	C::t('forum_threadaddviews')->delete($deltids);
}
foreach($updateviews as $views => $tids) {
	C::t('forum_thread')->increase($tids, array('views' => $views), true);
}

?>
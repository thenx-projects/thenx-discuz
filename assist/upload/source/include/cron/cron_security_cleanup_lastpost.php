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
 *      $Id: cron_security_daily.php 29568 2012-04-19 03:39:25Z songlixin $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$queryf = C::t('forum_forum')->fetch_all_fids();
foreach($queryf as $forum) {
	$thread = C::t('forum_thread')->fetch_by_fid_displayorder($forum['fid']);
	$lastpost = "$thread[tid]\t$thread[subject]\t$thread[lastpost]\t$thread[lastposter]";

	C::t('forum_forum')->update($forum['fid'], array('lastpost' => $lastpost));
}
?>
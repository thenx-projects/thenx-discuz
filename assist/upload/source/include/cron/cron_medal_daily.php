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
 *      $Id: cron_medal_daily.php 24698 2011-10-08 08:36:47Z monkey $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$medalnewarray = $medalsnew = $uids = array();


foreach(C::t('forum_medallog')->fetch_all_by_expiration(TIMESTAMP) as $medalnew) {
	$uids[] = $medalnew['uid'];
	$medalnews[] = $medalnew;
}

$membermedals = array();
foreach(C::t('common_member_field_forum')->fetch_all($uids) as $member) {
	$membermedals[$member['uid']] = $member['medals'];
}

foreach($medalnews as $medalnew) {
	$medalnew['medals'] = empty($medalnewarray[$medalnew['uid']]) ? explode("\t", $membermedals[$medalnew['uid']]) : explode("\t", $medalnewarray[$medalnew['uid']]);

	foreach($medalnew['medals'] as $key => $medalnewid) {
		list($medalid, $medalexpiration) = explode("|", $medalnewid);
		if($medalnew['medalid'] == $medalid) {
			unset($medalnew['medals'][$key]);
		}
	}

	$medalnewarray[$medalnew['uid']] = implode("\t", $medalnew['medals']);
	C::t('forum_medallog')->update($medalnew['id'], array('status' => 0));
	C::t('common_member_field_forum')->update($medalnew['uid'], array('medals' => $medalnewarray[$medalnew['uid']]), 'UNBUFFERED');
	C::t('common_member_medal')->delete_by_uid_medalid($medalnew['uid'], $medalnew['medalid']);
}
?>
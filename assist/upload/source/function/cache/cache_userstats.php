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
 *      $Id: cache_userstats.php 26680 2011-12-20 01:05:48Z monkey $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function build_cache_userstats() {
	global $_G;
	$totalmembers = C::t('common_member')->count();
	$member = C::t('common_member')->range(0, 1, 'DESC');
	$member = current($member);
	$newsetuser = $member['username'];
	$data = array('totalmembers' => $totalmembers, 'newsetuser' => $newsetuser);
	if($_G['setting']['plugins']['func'][HOOKTYPE]['cacheuserstats']) {
		$_G['userstatdata'] = & $data;
		hookscript('cacheuserstats', 'global', 'funcs', array(), 'cacheuserstats');
	}
	savecache('userstats', $data);
}

?>
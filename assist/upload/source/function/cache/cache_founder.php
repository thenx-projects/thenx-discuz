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
 *      $Id: cache_founder.php 25782 2011-11-22 05:29:19Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function build_cache_founder() {
	global $_G;

	$allowadmincp = $status0 = $status1 = array();
	$founders = explode(',', str_replace(' ', '', $_G['config']['admincp']['founder']));
	if($founders) {
		foreach($founders as $founder) {
			if(is_numeric($founder)) {
				$fuid[] = $founder;
			} else {
				$fuser[] = $founder;
			}
		}
		if($fuid) {
			$allowadmincp = C::t('common_member')->fetch_all($fuid, false, 0);
		}
		if($fuser) {
			$allowadmincp = $allowadmincp + C::t('common_member')->fetch_all_by_username($fuser);
		}
	}
	$allowadmincp = $allowadmincp + C::t('common_admincp_member')->range();

	$allallowadmincp = C::t('common_member')->fetch_all_by_allowadmincp('0', '>') + C::t('common_member')->fetch_all(array_keys($allowadmincp), false, 0);
	foreach($allallowadmincp as $uid => $user) {
		if(isset($allowadmincp[$uid]) && !getstatus($user['allowadmincp'], 1)) {
			$status1[$uid] = $uid;
		} elseif(!isset($allowadmincp[$uid]) && getstatus($user['allowadmincp'], 1)) {
			$status0[$uid] = $uid;
		}
	}
	if(!empty($status0)) {
		C::t('common_member')->clean_admincp_manage($status0);
	}
	if(!empty($status1)) {
		C::t('common_member')->update_admincp_manage($status1);
	}

}

?>
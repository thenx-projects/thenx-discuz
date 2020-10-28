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
 *      $Id: table_common_member_security.php 27449 2012-02-01 05:32:35Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_member_forum_buylog extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_member_forum_buylog';
		$this->_pk    = 'uid';
		$this->_pre_cache_key = 'common_member';
		$this->_allowmem = memory('check');
		$this->_cache_ttl = 86400;

		parent::__construct();
	}

	public function get_credits($uid, $fid) {
		$credits = $this->fetch_cache($uid.'_'.$fid, 'common_member_forum_buylog_');
		if(!$credits) {
			$credits = DB::result_first('SELECT credits FROM %t WHERE uid=%d AND fid=%d', array($this->_table, $uid, $fid));
			$this->store_cache($uid.'_'.$fid, $credits, $this->_cache_ttl, 'common_member_forum_buylog_');
			return $credits;
		} else {
			return $credits;
		}
	}

	public function update_credits($uid, $fid, $credits) {
		C::t('common_member_forum_buylog')->insert(array('uid' => $uid, 'fid' => $fid, 'credits' => $credits), false, true);
		$this->store_cache($uid.'_'.$fid, $credits, $this->_cache_ttl, 'common_member_forum_buylog_');
	}

	public function delete_by_uid($uids) {
		DB::delete($this->_table, DB::field('uid', $uids));
	}

	public function delete_by_fid($fids) {
		DB::delete($this->_table, DB::field('fid', $fids));
	}
}

?>
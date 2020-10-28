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
 *      $Id: table_forum_debate.php 27738 2012-02-13 10:02:53Z monkey $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_forum_debate extends discuz_table
{
	public function __construct() {

		$this->_table = 'forum_debate';
		$this->_pk    = 'tid';

		parent::__construct();
	}

	public function update_voters($tid, $uid, $stand) {
		if($stand == 1) {
			DB::query("UPDATE %t SET affirmvotes=affirmvotes+1, affirmvoterids=CONCAT(affirmvoterids, '%d\t') WHERE tid=%d", array($this->_table, $uid, $tid));
		} elseif($stand == 2) {
			DB::query("UPDATE %t SET negavotes=negavotes+1, negavoterids=CONCAT(negavoterids, '%d\t') WHERE tid=%d", array($this->_table, $uid, $tid));
		}
	}

	public function update_debaters($tid, $stand) {
		if($stand == 1) {
			DB::query("UPDATE %t SET affirmdebaters=affirmdebaters+1 WHERE tid=%d", array($this->_table, $tid));
		} elseif($stand == 2) {
			DB::query("UPDATE %t SET negadebaters=negadebaters+1 WHERE tid=%d", array($this->_table, $tid));
		}
	}

	public function update_replies($tid, $stand) {
		if($stand == 1) {
			DB::query("UPDATE %t SET affirmreplies=affirmreplies+1 WHERE tid=%d", array($this->_table, $tid));
		} elseif($stand == 2) {
			DB::query("UPDATE %t SET negareplies=negareplies+1 WHERE tid=%d", array($this->_table, $tid));
		}
	}
	public function delete_by_tid($tids) {
		if(!$tids) {
			return;
		}
		return DB::delete($this->_table, DB::field('tid', $tids));
	}

}

?>
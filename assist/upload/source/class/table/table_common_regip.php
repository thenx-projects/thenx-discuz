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
 *      $Id: table_common_regip.php 28771 2012-03-12 09:13:43Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_regip extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_regip';
		$this->_pk    = '';

		parent::__construct();
	}

	public function fetch_by_ip_dateline($clientip, $dateline) {
		return DB::fetch_first('SELECT count FROM %t WHERE ip=%s AND count>0 AND dateline>%d', array($this->_table, $clientip, $dateline));
	}

	public function count_by_ip_dateline($ctrlip, $dateline) {
		if(!empty($ctrlip)) {
			return DB::result_first('SELECT COUNT(*) FROM %t WHERE '.DB::field('ip', $ctrlip, 'like').' AND count=-1 AND dateline>%d  LIMIT 1', array($this->_table, $dateline));
		}
		return 0;
	}

	public function update_count_by_ip($clientip) {
		return DB::query('UPDATE %t SET count=count+1 WHERE ip=%s AND count>0', array($this->_table, $clientip));
	}

	public function delete_by_dateline($dateline) {
		return DB::query('DELETE FROM %t WHERE dateline<=%d', array($this->_table, $dateline), false, true);
	}

}

?>
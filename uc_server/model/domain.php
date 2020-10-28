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

/*
	[UCenter] (C)2001-2099 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: domain.php 1059 2011-03-01 07:25:09Z monkey $
*/

!defined('IN_UC') && exit('Access Denied');

class domainmodel {

	var $db;
	var $base;

	function __construct(&$base) {
		$this->domainmodel($base);
	}

	function domainmodel(&$base) {
		$this->base = $base;
		$this->db = $base->db;
	}

	function add_domain($domain, $ip) {
		if($domain) {
			$this->db->query("INSERT INTO ".UC_DBTABLEPRE."domains SET domain='$domain', ip='$ip'");
		}
		return $this->db->insert_id();
	}

	function get_total_num() {
		$data = $this->db->result_first("SELECT COUNT(*) FROM ".UC_DBTABLEPRE."domains");
		return $data;
	}

	function get_list($page, $ppp, $totalnum) {
		$start = $this->base->page_get_start($page, $ppp, $totalnum);
		$data = $this->db->fetch_all("SELECT * FROM ".UC_DBTABLEPRE."domains LIMIT $start, $ppp");
		return $data;
	}

	function delete_domain($arr) {
		$domainids = $this->base->implode($arr);
		$this->db->query("DELETE FROM ".UC_DBTABLEPRE."domains WHERE id IN ($domainids)");
		return $this->db->affected_rows();
	}

	function update_domain($domain, $ip, $id) {
		$this->db->query("UPDATE ".UC_DBTABLEPRE."domains SET domain='$domain', ip='$ip' WHERE id='$id'");
		return $this->db->affected_rows();
	}
}
?>
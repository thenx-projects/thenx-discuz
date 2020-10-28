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

	$Id: badword.php 1059 2011-03-01 07:25:09Z monkey $
*/

!defined('IN_UC') && exit('Access Denied');

class badwordmodel {

	var $db;
	var $base;

	function __construct(&$base) {
		$this->badwordmodel($base);
	}

	function badwordmodel(&$base) {
		$this->base = $base;
		$this->db = $base->db;
	}

	function add_badword($find, $replacement, $admin, $type = 1) {
		if($find) {
			$find = trim($find);
			$replacement = trim($replacement);
			$findpattern = $this->pattern_find($find);
			if($type == 1) {
				$this->db->query("REPLACE INTO ".UC_DBTABLEPRE."badwords SET find='$find', replacement='$replacement', admin='$admin', findpattern='$findpattern'");
			} elseif($type == 2) {
				$this->db->query("INSERT INTO ".UC_DBTABLEPRE."badwords SET find='$find', replacement='$replacement', admin='$admin', findpattern='$findpattern'", 'SILENT');
			}
		}
		return $this->db->insert_id();
	}

	function get_total_num() {
		$data = $this->db->result_first("SELECT COUNT(*) FROM ".UC_DBTABLEPRE."badwords");
		return $data;
	}

	function get_list($page, $ppp, $totalnum) {
		$start = $this->base->page_get_start($page, $ppp, $totalnum);
		$data = $this->db->fetch_all("SELECT * FROM ".UC_DBTABLEPRE."badwords LIMIT $start, $ppp");
		return $data;
	}

	function delete_badword($arr) {
		$badwordids = $this->base->implode($arr);
		$this->db->query("DELETE FROM ".UC_DBTABLEPRE."badwords WHERE id IN ($badwordids)");
		return $this->db->affected_rows();
	}

	function truncate_badword() {
		$this->db->query("TRUNCATE ".UC_DBTABLEPRE."badwords");
	}

	function update_badword($find, $replacement, $id) {
		$findpattern = $this->pattern_find($find);
		$this->db->query("UPDATE ".UC_DBTABLEPRE."badwords SET find='$find', replacement='$replacement', findpattern='$findpattern' WHERE id='$id'");
		return $this->db->affected_rows();
	}

	function pattern_find($find) {
		$find = preg_quote($find, "/'");
		$find = str_replace("\\", "\\\\", $find);
		$find = str_replace("'", "\\'", $find);
		return '/'.preg_replace("/\\\{(\d+)\\\}/", ".{0,\\1}", $find).'/is';
	}
}

?>
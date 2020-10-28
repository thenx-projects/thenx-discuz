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
 * DiscuzX Convert
 *
 * $Id: uc_friends.php 10469 2010-05-11 09:12:14Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'uc_friends';
$table_target = $db_target->tablepre.'ucenter_friends';
$table_sourcemember = $db_source->tablepre.'uc_members';
$table_targetfriend = $db_target->tablepre.'home_friend';
$table_tfriendrequest = $db_target->tablepre.'home_friend_request';
$limit = 2000;
$nextid = 0;
$nexttable = 0;
$start = getgpc('start');
if(empty($start)) {
	$source_exist = $db_source->result_first("SHOW TABLES LIKE '".substr($table_source, strpos($table_source, '.') + 1)."'");
	$target_exist = $db_target->result_first("SHOW TABLES LIKE '".substr($table_target, strpos($table_target, '.') + 1)."'");
	if(empty($source_exist) || empty($target_exist)) {
		$nexttable = 1;
	} else {
		$start = 0;
		$db_target->query("TRUNCATE $table_target");
		$db_target->query("TRUNCATE $table_targetfriend");
		$db_target->query("TRUNCATE $table_tfriendrequest");
	}
}

$fusername = array();
if(empty($nexttable)) {
	$query = $db_source->query("SELECT * FROM $table_source WHERE version>'$start' ORDER BY version LIMIT $limit");
	while ($row = $db_source->fetch_array($query)) {
		$nextid = $row['version'];

		$row  = daddslashes($row, 1);
		$fusername[$row['friendid']] = $row['direction'];

		$data = implode_field_value($row, ',', db_table_fields($db_target, $table_target));

		$db_target->query("INSERT INTO $table_target SET $data");
		if($row['direction'] == 3) {
			$db_target->query("REPLACE INTO $table_targetfriend SET uid='$row[uid]', fuid='$row[friendid]', dateline='".time()."'");
		} else {
			$db_target->query("REPLACE INTO $table_tfriendrequest SET uid='$row[uid]', fuid='$row[friendid]', dateline='".time()."'");
		}
		if(count($fusername) == 200) {
			$fquery = $db_source->query("SELECT uid, username FROM $table_sourcemember WHERE uid IN('".implode("','", array_keys($fusername))."')");
			while($frow = $db_source->fetch_array($fquery)) {
				$frow  = daddslashes($frow, 1);
				if($fusername[$frow['uid']] == 3) {
					$db_target->query("UPDATE $table_targetfriend SET fusername='$frow[username]' WHERE fuid='$frow[uid]'");
				} else {
					$db_target->query("UPDATE $table_tfriendrequest SET fusername='$frow[username]' WHERE fuid='$frow[uid]'");
				}
			}
			$fusername = array();
		}
	}
	if(count($fusername)) {
		$fquery = $db_source->query("SELECT uid, username FROM $table_sourcemember WHERE uid IN('".implode("','", array_keys($fusername))."')");
		while($frow = $db_source->fetch_array($fquery)) {
			$frow  = daddslashes($frow, 1);
			if($fusername[$frow['uid']] == 3) {
				$db_target->query("UPDATE $table_targetfriend SET fusername='$frow[username]' WHERE fuid='$frow[uid]'");
			} else {
				$db_target->query("UPDATE $table_tfriendrequest SET fusername='$frow[username]' WHERE fuid='$frow[uid]'");
			}
		}
	}
}


if($nextid) {
	showmessage("继续转换数据表 ".$table_source." version > $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>
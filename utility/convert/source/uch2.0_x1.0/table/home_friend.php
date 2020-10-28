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
 * $Id: home_friend.php 13173 2010-07-22 06:03:26Z zhengqingpeng $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'friend';

$limit = $setting['limit']['friend'] ? $setting['limit']['friend'] : 10000;

$nextid = 0;

$start = getgpc('start');
$start = empty($start) ? 0 : $start;

if($start == 0) {
	$db_target->query("TRUNCATE ".$db_target->tablepre.'home_friend_request');
}

$nextid = $start + $limit;
$done = true;

$query = $db_source->query("SELECT * FROM $table_source ORDER BY uid LIMIT $start, $limit");
while ($rs = $db_source->fetch_array($query)) {

	$done = false;

	$rs  = daddslashes($rs, 1);

	if($rs['status']) {
		$table_target = $db_target->tablepre.'home_friend';
		if(empty($rs['fusername'])) {
			$subquery = $db_source->query("SELECT username FROM ".$db_source->tablepre.'space'." WHERE uid='$rs[fuid]]'");
			$rs['fusername'] = $db_source->result($subquery, 0);
			$rs['fusername'] = addslashes($rs['fusername']);
		}
		$rs['note'] = '';
	} else {
		$_uid = $rs['uid'];
		$_fuid = $rs['fuid'];
		$rs['uid'] = $_fuid;
		$rs['fuid'] = $_uid;

		$subquery = $db_source->query("SELECT username FROM ".$db_source->tablepre.'space'." WHERE uid='$_uid'");
		$rs['fusername'] = $db_source->result($subquery, 0);
		$rs['fusername'] = addslashes($rs['fusername']);

		$table_target = $db_target->tablepre.'home_friend_request';
	}


	$data = implode_field_value($rs, ',', db_table_fields($db_target, $table_target));

	$db_target->query("REPLACE INTO $table_target SET $data");

}

if($done == false) {
	showmessage("继续转换数据表 ".$table_source." start> $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>
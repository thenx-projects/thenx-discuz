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
 * $Id: membermagics.php 11245 2010-05-27 05:16:54Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'membermagics';
$table_sourcemarket = $db_source->tablepre.'magicmarket';
$table_target = $db_target->tablepre.'common_member_magic';

$limit = 1000;
$nextid = 0;

$start = getgpc('start');
if(empty($start)) {
	$start = 0;
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT * FROM $table_source LIMIT $start, $limit");
while ($row = $db_source->fetch_array($query)) {

	$nextid = 1;

	$row  = daddslashes($row, 1);

	$data = implode_field_value($row, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	$query = $db_source->query("SELECT * FROM $table_sourcemarket");
	while ($row = $db_source->fetch_array($query)) {
		$row = daddslashes($row, 1);
		$mm = $db_target->fetch_first("SELECT * FROM $table_target WHERE uid='$row[uid]' AND magicid='$row[magicid]'");
		if($mm) {
			$db_target->query("UPDATE $table_target SET num=num+'$row[num]' WHERE uid='$row[uid]' AND magicid='$row[magicid]'");
		} else {
			$db_target->query("INSERT INTO $table_target SET uid='$row[uid]', magicid='$row[magicid]', num='$row[num]'");
		}
	}
	showmessage("继续转换数据表 ".$table_source." $start 至 ".($start+$limit)." 行", "index.php?a=$action&source=$source&prg=$curprg&start=".($start+$limit));
}

?>
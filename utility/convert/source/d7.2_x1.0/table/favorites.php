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
 * $Id: favorites.php 9572 2010-04-29 10:11:30Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'favorites';
$table_target = $db_target->tablepre.'home_favorite';

$limit = 100;
$nextid = 0;

$start = getgpc('start');
$nextstep = intval(getgpc('nextstep'));
if(empty($start)) {
	$start = 0;
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT * FROM $table_source LIMIT $start, $limit");
while ($row = $db_source->fetch_array($query)) {

	$nextid = 1;

	$row['id'] = 0;
	$row['idtype'] = '';

	if($row['tid']) {
		$row['title'] = $db_source->result_first("SELECT subject FROM ".$db_source->tablepre."threads WHERE tid='".$row['tid']."'");
		$row['id'] = $row['tid'];
		$row['idtype'] = 'tid';
	} elseif($row['fid']) {
		$row['title'] = $db_source->result_first("SELECT name FROM ".$db_source->tablepre."forums WHERE fid='".$row['fid']."'");
		$row['id'] = $row['fid'];
		$row['idtype'] = 'fid';
	}
	$row  = daddslashes($row, 1);

	if($row['id']) {
		unset($row['tid'], $row['fid']);
		$row['dateline'] = time();
		$data = implode_field_value($row, ',', db_table_fields($db_target, $table_target));
		$db_target->query("INSERT INTO $table_target SET $data");
	}

}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." $start 至 ".($start+$limit)." 行", "index.php?a=$action&source=$source&prg=$curprg&start=".($start+$limit));
}

?>
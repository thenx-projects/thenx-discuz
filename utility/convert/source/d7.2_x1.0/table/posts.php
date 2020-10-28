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
 * $Id: posts.php 9237 2010-04-27 11:02:25Z wangjinbo $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre . 'posts';
$table_target = $db_target->tablepre . 'forum_post';

$limit = $setting['limit']['posts'] ? $setting['limit']['posts'] : 5000;
$start = getgpc('start');
$start = intval($start);
$nextid = 0;

if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT * FROM $table_source WHERE pid>'$start' LIMIT $limit");
while($row = $db_source->fetch_array($query)) {
	$nextid = $row['pid'];
	$row = daddslashes($row, 1);
	$data = implode_field_value($row, ',', db_table_fields($db_target, $table_target));
	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." pid > $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
} else {
	$maxpid = $db_target->result_first("SELECT MAX(pid) FROM $table_target");
	$maxpid = intval($maxpid) + 1;
	$db_target->query("ALTER TABLE ".$db_target->tablepre.'forum_post_tableid'." AUTO_INCREMENT=$maxpid");
}
?>
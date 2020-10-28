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
 * $Id: home_friendlog.php 10469 2010-05-11 09:12:14Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'friendlog';
$table_target = $db_target->tablepre.'home_friendlog';

$start = getgpc('start');
$start = empty($start) ? 0 : intval($start);
$limit = 2000;
$nextid = $limit + $start;
$done = true;

if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT * FROM $table_source ORDER BY uid LIMIT $start, $limit");
while ($value = $db_source->fetch_array($query)) {

	$done = false;

	$value  = daddslashes($value, 1);

	$data = implode_field_value($value, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($done == false) {
	showmessage("继续转换数据表 ".$table_source." uid> $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>
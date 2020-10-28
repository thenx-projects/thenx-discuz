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
 * $Id: common_myapp.php 18808 2010-12-06 08:18:37Z zhengqingpeng $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'myapp';
$table_target = $db_target->tablepre.'common_myapp';

$limit = $setting['limit']['myapp'] ? $setting['limit']['myapp'] : 500;
$nextid = 0;

$start = getgpc('start');
if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT  * FROM $table_source WHERE appid>'$start' ORDER BY appid LIMIT $limit");
while ($app = $db_source->fetch_array($query)) {

	$nextid = $app['appid'];

	$app  = daddslashes($app, 1);

	$data = implode_field_value($app, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." appid> $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
} else {
	$db_target->query("TRUNCATE ".$db_target->table('common_myapp_count'));
	$db_target->query('INSERT INTO '.$db_target->table('common_myapp_count').' (appid) SELECT appid FROM '.$db_target->table('common_myapp'));
}

?>
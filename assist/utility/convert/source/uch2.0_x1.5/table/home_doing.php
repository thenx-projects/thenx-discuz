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
 * $Id: home_doing.php 15720 2010-08-25 23:56:08Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'doing';
$table_target = $db_target->tablepre.'home_doing';

$limit = $setting['limit']['doing'] ? $setting['limit']['doing'] : 1000;
$nextid = 0;

$start = getgpc('start');
if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT doid,uid,username,`from`,dateline,message,ip,replynum FROM $table_source WHERE doid>'$start' ORDER BY doid LIMIT $limit");
while ($doing = $db_source->fetch_array($query)) {

	$str = 'class="face"';
	$doing['message'] = str_replace($str, '', $doing[message]);
	$nextid = $doing['doid'];

	$doing  = daddslashes($doing, 1);

	$data = implode_field_value($doing, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." doid> $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>
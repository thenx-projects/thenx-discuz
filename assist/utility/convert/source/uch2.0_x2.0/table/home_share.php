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
 * $Id: home_share.php 15720 2010-08-25 23:56:08Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'share';
$table_target = $db_target->tablepre.'home_share';

$limit = $setting['limit']['share'] ? $setting['limit']['share'] : 1000;
$nextid = 0;

$start = getgpc('start');
if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT sid, type, uid, username, dateline, title_template, body_template, body_data, body_general, image,
							image_link, hot, hotuser FROM $table_source WHERE sid>'$start' ORDER BY sid LIMIT $limit");
while ($share = $db_source->fetch_array($query)) {

	$nextid = intval($share['sid']);

	$share  = daddslashes($share, 1);

	$data = implode_field_value($share, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." sid> $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>
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
 * $Id: categories.php 15777 2010-08-26 04:00:58Z zhengqingpeng $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'categories';
$table_target = $db_target->tablepre.'portal_category';

$table_source_items =  $db_source->tablepre.'spaceitems';

$limit = 1000;
$nextid = 0;

$start = getgpc('start') ? getgpc('start') : 0;

if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$arr = $catids = $count_num = array();

$query = $db_source->query("SELECT * FROM $table_source WHERE catid>'$start' ORDER BY catid LIMIT $limit");
while ($value = $db_source->fetch_array($query)) {
	$arr[] = $value;
	$catids[] = $value['catid'];
}

$query = $db_source->query("SELECT catid, COUNT(*) AS num FROM $table_source_items WHERE catid IN (".dimplode($catids).") GROUP BY catid");
while ($value = $db_source->fetch_array($query)) {
	$count_num[$value['catid']] = $value['num'];
}

foreach ($arr as $rs) {
	$nextid = $rs['aid'];

	$setarr = array();
	$setarr['catid'] = $rs['catid'];
	$setarr['upid'] = $rs['upid'];
	$setarr['catname'] = $rs['name'];
	$setarr['displayorder'] = $rs['displayorder'];
	$setarr['description'] = $rs['note'];

	$setarr['articles'] = empty($count_num[$rs['catid']]) ? 0 : $count_num[$rs['catid']];

	$setarr  = daddslashes($setarr, 1);

	$data = implode_field_value($setarr, ',', db_table_fields($db_target, $table_target));
	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." catid> $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>
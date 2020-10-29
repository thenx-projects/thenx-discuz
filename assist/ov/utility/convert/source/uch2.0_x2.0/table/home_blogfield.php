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
 * $Id: home_blogfield.php 15720 2010-08-25 23:56:08Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'blogfield';
$table_target = $db_target->tablepre.'home_blogfield';

$limit = $setting['limit']['blog'] ? $setting['limit']['blog'] : 1000;
$nextid = 0;

$start = getgpc('start');
if($start == 0) {
	$db_target->query("TRUNCATE $table_target");
}

$query = $db_source->query("SELECT bf.blogid, bf.uid, bf.tag, bf.message, bf.postip, bf.related, bf.relatedtime, bf.target_ids, bf.hotuser, b.pic FROM $table_source bf LEFT JOIN ".$db_source->table_name('blog')." b ON b.blogid = bf.blogid WHERE bf.blogid>'$start' ORDER BY bf.blogid LIMIT $limit");
while ($blog = $db_source->fetch_array($query)) {

	if(!empty($blog['tag'])) {
		$tag = unserialize($blog['tag']);
		if(is_array($tag)) {
			foreach($tag as $k => $v) {
				$blog['tag'] = implode(' ', $tag);
			}
		}
	}

	$nextid = $blog['blogid'];

	$blog  = daddslashes($blog, 1);

	$data = implode_field_value($blog, ',', db_table_fields($db_target, $table_target));

	$db_target->query("INSERT INTO $table_target SET $data");
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." blogid> $nextid", "index.php?a=$action&source=$source&prg=$curprg&start=$nextid");
}

?>
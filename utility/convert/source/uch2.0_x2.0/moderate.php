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
 * $Id: stamp.php 15786 2010-08-27 00:27:21Z monkey $
 */

$table_target = $db_target->tablepre.'common_moderate';
$table_target_home_blog = $db_target->tablepre.'home_blog';
$table_target_home_doing = $db_target->tablepre.'home_doing';
$table_target_home_pic = $db_target->tablepre.'home_pic';
$table_target_home_share = $db_target->tablepre.'home_share';
$table_target_home_comment = $db_target->tablepre.'home_comment';

$query = $db_target->query("SELECT blogid FROM $table_target_home_blog WHERE status='1'");
while($row = $db_target->fetch_array($query)) {
	updatemoderate('blogid', $row['blogid']);
}

$query = $db_target->query("SELECT doid FROM $table_target_home_doing WHERE status='1'");
while($row = $db_target->fetch_array($query)) {
	updatemoderate('doid', $row['doid']);
}

$query = $db_target->query("SELECT picid FROM $table_target_home_pic WHERE status='1'");
while($row = $db_target->fetch_array($query)) {
	updatemoderate('picid', $row['picid']);
}

$query = $db_target->query("SELECT sid FROM $table_target_home_share WHERE status='1'");
while($row = $db_target->fetch_array($query)) {
	updatemoderate('sid', $row['sid']);
}

$query = $db_target->query("SELECT idtype, cid FROM $table_target_home_comment WHERE status='1'");
while($row = $db_target->fetch_array($query)) {
	updatemoderate($row['idtype'].'_cid', $row['cid']);
}

function updatemoderate($idtype, $ids) {
	global $table_target, $db_target;
	$ids = is_array($ids) ? $ids : array($ids);
	if(!$ids) {
		return;
	}
	$time = time();
	foreach($ids as $id) {
		$db_target->query("INSERT INTO $table_target (id,idtype,status,dateline) VALUES ('$id','$idtype','0','$time')");
	}
}
?>
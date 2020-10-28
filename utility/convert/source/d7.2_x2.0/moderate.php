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
$table_target_thread = $db_target->tablepre.'forum_thread';
$table_target_post = $db_target->tablepre.'forum_post';

$db_target->query("TRUNCATE $table_target");

$query = $db_target->query("SELECT tid FROM $table_target_thread WHERE displayorder='-2'");
while($row = $db_target->fetch_array($query)) {
	updatemoderate('tid', $row['tid']);
}

$query = $db_target->query("SELECT pid FROM $table_target_post WHERE invisible='-2' AND first='0'");
while($row = $db_target->fetch_array($query)) {
	updatemoderate('pid', $row['pid']);
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
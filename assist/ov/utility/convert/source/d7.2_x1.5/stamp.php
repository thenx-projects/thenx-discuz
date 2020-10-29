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

$curprg = basename(__FILE__);
$table_source = $db_source->tablepre . 'threads';
$tablemod_source = $db_source->tablepre . 'threadsmod';
$table_target = $db_target->tablepre . 'forum_thread';

$stampnew = $db_target->result_first("SELECT COUNT(*) FROM $table_target WHERE stamp>'0'");
if(!$stampnew) {
	$query = $db_source->query("SELECT t.tid, tm.stamp FROM $table_source t
		INNER JOIN $tablemod_source tm ON t.tid=tm.tid AND tm.action='SPA'
		WHERE t.status|16=t.status");
	$total = $db_source->num_rows($total);
	while($row = $db_source->fetch_array($query)) {
		$db_target->query("UPDATE $table_target SET stamp='$row[stamp]' WHERE tid='$row[tid]'");
	}
}

?>
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
 * $Id: settings.php 11117 2010-05-24 08:30:29Z zhengqingpeng $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'settings';
$table_target = $db_target->tablepre.'common_setting';

$newsetting = array();
$query = $db_target->query("SELECT * FROM $table_target");
while($row = $db_source->fetch_array($query)) {
	$newsetting[$row['skey']] = $row['skey'];
}

$skips = array('attachdir', 'attachurl', 'cachethreaddir', 'jspath', 'my_status');

$query = $db_source->query("SELECT  * FROM $table_source");
while ($row = $db_source->fetch_array($query)) {
	if(in_array($row['variable'], $skips)) continue;
	if(isset($newsetting[$row['variable']])) {
		$rownew = array();
		if($row['variable'] == 'my_search_status' && $row['value'] != -1) {
			$row['value'] = 0;
		}
		$rownew['skey'] = $row['variable'];
		$rownew['svalue'] = $row['value'];
		$rownew  = daddslashes($rownew, 1);

		$data = implode_field_value($rownew, ',', db_table_fields($db_target, $table_target));

		$db_target->query("REPLACE INTO $table_target SET $data");
	}
}

?>
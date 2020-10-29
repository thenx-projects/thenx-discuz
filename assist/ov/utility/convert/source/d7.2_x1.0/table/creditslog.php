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
 * $Id: creditslog.php 10469 2010-05-11 09:12:14Z monkey $
 */

$curprg = basename(__FILE__);

$table_source = $db_source->tablepre.'creditslog';
$table_target = $db_target->tablepre.'common_credit_log';

$limit = 2000;
$nextid = 0;

$start = intval(getgpc('start'));
if(empty($start) && !$process['truncate_credit_log']) {
	$start = 0;
	$process['truncate_credit_log'] = 1;
	save_process('main', $process);
	$db_target->query("TRUNCATE $table_target");
}

$rowlist = $userarr = array();
$query = $db_source->query("SELECT * FROM $table_source LIMIT $start, $limit");
while ($row = $db_source->fetch_array($query)) {
	$nextid = 1;
	$rowlist[] = $row;
	$userarr[$row['fromto']] = $row['fromto'];
}

if($nextid) {
	$userarr = daddslashes($userarr, 1);
	$usernames = implode("', '", $userarr);
	$query = $db_source->query("SELECT * FROM ".$db_source->tablepre."members WHERE username IN('$usernames')");
	while($row = $db_source->fetch_array($query)) {
		$userarr[$row['username']] = $row['uid'];
	}

	foreach($rowlist as $row) {
		$rownew = array();
		if(in_array($row['operation'], array('AFD', 'TFR', 'RCV'))) {
			$rownew['uid'] = $row['uid'];
			if($row['operation'] == 'RCV' && $row['fromto'] == 'TASK REWARD') {
				$rownew['operation'] = 'TRC';
				$rownew['relatedid'] = 0;
			} else {
				$rownew['operation'] = $row['operation'];
				$rownew['relatedid'] = $userarr[$row['fromto']];
			}

			$rownew['dateline'] = $row['dateline'];
			if($row['receive']) {
				$rownew['extcredits'.$row['receivecredits']] = $row['receive'];
			}
			if($row['send']) {
				$rownew['extcredits'.$row['sendcredits']] = -$row['send'];
			}
		} elseif($row['operation'] == 'UGP') {
			$rownew['uid'] = $row['uid'];
			$rownew['operation'] = $row['operation'];
			$rownew['relatedid'] = 0;
			$rownew['dateline'] = $row['dateline'];
			if($row['receive']) {
				$rownew['extcredits'.$row['receivecredits']] = $row['receive'];
			}
			if($row['send']) {
				$rownew['extcredits'.$row['sendcredits']] = -$row['send'];
			}
		} elseif($row['operation'] == 'EXC') {
			$rownew['uid'] = $row['uid'];
			$rownew['operation'] = 'ECU';
			$rownew['relatedid'] = $row['uid'];
			$rownew['dateline'] = $row['dateline'];
			if($row['receive']) {
				$rownew['extcredits'.$row['receivecredits']] = $row['receive'];
			}
			if($row['send']) {
				$rownew['extcredits'.$row['sendcredits']] = -$row['send'];
			}
		}
		if($rownew) {
			$rownew  = daddslashes($rownew, 1);

			$data = implode_field_value($rownew, ',', db_table_fields($db_target, $table_target));

			$db_target->query("INSERT INTO $table_target SET $data");
		}
	}
}

if($nextid) {
	showmessage("继续转换数据表 ".$table_source." $start 至 ".($start+$limit)." 行", "index.php?a=$action&source=$source&prg=$curprg&start=".($start+$limit));
}

?>
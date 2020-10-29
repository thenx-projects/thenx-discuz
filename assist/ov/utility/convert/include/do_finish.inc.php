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

$config = loadconfig();
$db_target = new db_mysql($config['target']);
$db_target->connect();

$readme = DISCUZ_ROOT.'./source/'.$source.'/readme.txt';
if(file_exists($readme)) {
	$txt = file_get_contents($readme);
} else {
	$txt = lang('finish');
}

$txt = nl2br(htmlspecialchars($txt));
$txt = str_replace('  ', '&nbsp;&nbsp;', $txt);
$txt = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $txt);

$process = load_process('main');
list($rday, $rhour, $rmin, $rsec) = remaintime(time() - $process['timestart']);
$stime = gmdate('Y-m-d H:i:s', $process['timestart'] + 3600* 8);
$etime = gmdate('Y-m-d H:i:s',time() + 3600* 8);
$timetodo = "您已经顺利的完成了数据转换!";
$timetodo .= "<br><br>本次升级开始时间: <strong>$stime</strong><br>本次升级结束时间: <strong>$etime</strong>";
$timetodo .= "<br>升级累计执行时间: <strong>$rday</strong>天 <strong>$rhour</strong>小时 <strong>$rmin</strong>分 <strong>$rsec</strong>秒";
$timetodo .= "<br><br>通常情况下，您可能还需要按照以下提示继续进行升级，从而使您的新程序正常运行";

showtips($timetodo);

show_table_header();
show_table_row(array('最后的说明(readme)'), 'title');
show_table_row(array($txt));
show_table_footer();

?>
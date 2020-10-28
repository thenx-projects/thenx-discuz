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
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: lang_checkonline.php 27449 2012-02-01 05:32:35Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$lang = array
(
	'checkonline_name' => '雷达卡',
	'checkonline_desc' => '查看某个用户是否在线',
	'checkonline_targetuser' => '您要查看谁是否在线',
	'checkonline_info_nonexistence' => '请输入用户名',
	'checkonline_hidden_message' => '{username} 当前隐身，最后活动时间是 {time}',
	'checkonline_online_message' => '{username} 当前在线，最后活动时间是 {time}',
	'checkonline_offline_message' => '{username} 当前离线',
	'checkonline_info_noperm' => '对不起，您无权查看此人的 IP',

	'checkonline_notification' => '有人使用了{magicname}检查您是否在线',
);

?>
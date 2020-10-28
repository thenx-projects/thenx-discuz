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
 *      $Id: lang_anonymouspost.php 27449 2012-02-01 05:32:35Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$lang = array
(
	'anonymouspost_name' => '匿名卡',
	'anonymouspost_desc' => '在指定的地方，让自己的名字显示为匿名。',
	'anonymouspost_num' => '拥有个数: {magicnum}',
	'anonymouspost_forum' => '允许使用本道具的版块',
	'anonymouspost_info' => '将自己的帖子设置为匿名身份，请输入帖子的 ID',
	'anonymouspost_info_nonexistence' => '请指定要匿名的帖子',
	'anonymouspost_succeed' => '成功设置为匿名',
	'anonymouspost_use_error' => '参数错误，不能在此处使用本道具。',
	'anonymouspost_info_noperm' => '对不起，主题所在版块不允许使用本道具',
	'anonymouspost_info_user_noperm' => '对不起，您不能对此人使用本道具',
	'anonymouspost_once_limit' => '已经是匿名状态了，不能重复使用本道具。',
);

?>
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
 *      $Id: lang_email.php 27449 2012-02-01 05:32:35Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$lang = array
(
	'email_name' => '验证邮箱任务',
	'email_desc' => '验证邮箱获得相应的奖励。',
	'email_view' => '<strong>请按照以下的说明来参与本任务：</strong>
		<ul>
		<li><a href="home.php?mod=spacecp&ac=profile&op=password" target="_blank">新窗口打开账号设置页面</a></li>
		<li>在新打开的设置页面中，将自己的邮箱真实填写(新填写的邮箱需要先保存)，并点击“重新接收验证邮件”链接</li>
		<li>几分钟后，系统会给您发送一封邮件，收到邮件后，请按照邮件的说明，访问邮件中的验证链接就可以了</li>
		</ul>',
);

?>
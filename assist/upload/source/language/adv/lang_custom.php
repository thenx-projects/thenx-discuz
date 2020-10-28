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
 *      $Id: lang_custom.php 27449 2012-02-01 05:32:35Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$lang = array
(
	'custom_name' => '自定义广告',
	'custom_desc' => '通过在模版、HTML 文件中添加广告代码，可以在站点的任意页面添加广告。适用于懂得简单 HTML 知识的站长。<br /><br />
		<a href="javascript:;" onclick="prompt(\'请复制(CTRL+C)以下内容并添加到模板中，添加此广告位\', \'<!--{ad/custom_'.$_GET['customid'].'}-->\')" />内部调用</a>&nbsp;
		<a href="javascript:;" onclick="prompt(\'请复制(CTRL+C)以下内容并添加到 HTML 文件中，添加此广告位\', \'&lt;script type=\\\'text/javascript\\\' src=\\\''.$_G['siteurl'].'api.php?mod=ad&adid=custom_'.$_GET['customid'].'\\\'&gt;&lt;/script&gt;\')" />外部调用</a>',
	'custom_id_notfound' => '自定义广告不存在',
	'custom_codelink' => '内部调用',
	'custom_text' => '自定义广告',
);

?>
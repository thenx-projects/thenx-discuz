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
 *      $Id: wechat.php 34480 2014-05-07 01:18:15Z nemohou $
 */
if (!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

define('DISABLEXSSCHECK', true);

require './source/class/class_core.php';

$discuz = C::app();

$cachelist = array('plugin');

$discuz->cachelist = $cachelist;
$discuz->init();

$_G['siteurl'] = str_replace('api/mobile/', '', $_G['siteurl']);
$_G['wechat']['setting'] = unserialize($_G['setting']['mobilewechat']);

require_once DISCUZ_ROOT . './source/plugin/wechat/wechat.lib.class.php';

$svr = new WeChatServer($_G['wechat']['setting']['wechat_token'], WeChatHook::getResponse($_GET['id']));
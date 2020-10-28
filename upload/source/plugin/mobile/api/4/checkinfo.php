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
 *      $Id: checkinfo.php 34424 2014-04-24 05:17:08Z nemohou $
 */
if (!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

require './source/class/class_core.php';

$discuz = C::app();

$cachelist = array();

$discuz->cachelist = $cachelist;
$discuz->init();

$_G['wechat']['setting'] = unserialize($_G['setting']['mobilewechat']);

require_once DISCUZ_ROOT.'./source/plugin/wechat/wsq.class.php';

$result = wsq::check($_GET);

if($result) {
	$setting = C::t('common_setting')->fetch_all(array('mobilewechat'));
	$setting = unserialize($setting['mobilewechat']);
	$setting['wsq_status'] = 1;
	$settings = array('mobilewechat' => serialize($setting));
	C::t('common_setting')->update_batch($settings);
}

echo $result;
exit;
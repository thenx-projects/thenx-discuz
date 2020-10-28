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
 *      $Id: admincp_perm.php 22528 2011-05-11 05:43:55Z monkey $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

array_splice($menu['global'], 4, 0, array(
	array('setting_memory', 'setting_memory'),
	array('setting_serveropti', 'setting_serveropti'),
));

array_splice($menu['global'], 9, 0, array(
	array('founder_perm_credits', 'credits'),
));

array_splice($menu['style'], 8, 0, array(
	array('setting_editor_code', 'misc_bbcode'),
));

array_splice($menu['user'], 1, 0, array(
	array('founder_perm_members_group', 'members_group'),
	array('founder_perm_members_access', 'members_access'),
	array('founder_perm_members_credit', 'members_credit'),
	array('founder_perm_members_medal', 'members_medal'),
	array('founder_perm_members_repeat', 'members_repeat'),
	array('founder_perm_members_clean', 'members_clean'),
	array('founder_perm_members_edit', 'members_edit'),
));

array_splice($menu['group'], 1, 0, array(
	array('founder_perm_group_editgroup', 'group_editgroup'),
	array('founder_perm_group_deletegroup', 'group_deletegroup'),
));

array_splice($menu['extended'], 4, 0, array(
	array('founder_perm_members_confermedal', 'members_confermedal'),
));

array_splice($menu['extended'], 7, 0, array(
	array('founder_perm_ec_alipay', 'ec_alipay'),
	array('founder_perm_ec_tenpay', 'ec_tenpay'),
	array('founder_perm_ec_credit', 'ec_credit'),
	array('founder_perm_ec_orders', 'ec_orders'),
	array('founder_perm_tradelog', 'tradelog'),
));

?>
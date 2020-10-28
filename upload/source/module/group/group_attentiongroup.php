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
 *      $Id: group_attentiongroup.php 25889 2011-11-24 09:52:20Z monkey $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$_GET['handlekey'] = 'attentiongroup';
require_once libfile('function/group');
$usergroups = update_usergroups($_G['uid']);
$attentiongroup = !empty($_G['member']['attentiongroup']) ? explode(',', $_G['member']['attentiongroup']) : array();
$counttype = count($attentiongroup);
if(submitcheck('attentionsubmit')) {
	if(is_array($_GET['attentiongroupid'])) {
		$_GET['attentiontypeid'] = array_slice($_GET['attentiontypeid'], 0, 5);
		C::t('common_member_field_forum')->update($_G['uid'], array('attentiongroup' => implode(',', $_GET['attentiongroupid'])));
	} else {
		C::t('common_member_field_forum')->update($_G['uid'], array('attentiongroup' => ''));
	}
	showmessage('setup_finished', 'group.php?mod=my&view=groupthread');
}
include template('group/group_attentiongroup');

?>
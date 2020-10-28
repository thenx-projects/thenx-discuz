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
 *      $Id: member_emailverify.php 25756 2011-11-22 02:47:45Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

define('NOROBOT', TRUE);

$member = getuserbyuid($_G['uid']);
if(!$member || $member['groupid'] != 8) {
	showmessage('member_not_found');
} else {
	$member = array_merge(C::t('common_member_field_forum')->fetch($member['uid']), $member);
}

if($_G['setting']['regverify'] == 2) {
	showmessage('register_verify_invalid');
}

list($dateline, $type, $idstring) = explode("\t", $member['authstr']);
if($type == 2 && TIMESTAMP - $dateline < 86400) {
	showmessage('email_verify_invalid');
}

$idstring = $type == 2 && $idstring ? $idstring : random(6);
C::t('common_member_field_forum')->update($_G['uid'], array('authstr'=>"$_G[timestamp]\t2\t$idstring"));
$verifyurl = $_G['setting']['securesiteurl']."member.php?mod=activate&amp;uid={$_G[uid]}&amp;id=$idstring";
$email_verify_message = lang('email', 'email_verify_message', array(
	'username' => $_G['member']['username'],
	'bbname' => $_G['setting']['bbname'],
	'siteurl' => $_G['setting']['securesiteurl'],
	'url' => $verifyurl
));
include_once libfile('function/mail');
if(!sendmail("{$_G[member][username]} <$_GET[email]>", lang('email', 'email_verify_subject'), $email_verify_message)) {
	runlog('sendmail', "$_GET[email] sendmail failed.");
}
showmessage('email_verify_succeed');

?>
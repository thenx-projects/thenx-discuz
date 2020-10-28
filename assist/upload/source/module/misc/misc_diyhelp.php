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
 *      $Id: misc_diyhelp.php 25889 2011-11-24 09:52:20Z monkey $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$allowdiy = false; //diy权限:$_G['group']['allowdiy'] || $_G['group']['allowaddtopic'] && $topic['uid'] == $_G['uid'] || $_G['group']['allowmanagetopic']
$ref = $_GET['diy'] == 'yes';//DIY模式中
if(!$ref && $_GET['action'] == 'get') {
	if($_GET['type'] == 'index') {
		if($_G['group']['allowdiy']) {
			$allowdiy = true;
		}
	} else if($_GET['type'] == 'topic') {
		$topic = array();
		$topicid = max(0, intval($_GET['topicid']));
		if($topicid) {
			if($_G['group']['allowmanagetopic']) {
				$allowdiy = true;
			} else if($_G['group']['allowaddtopic']) {
				if(($topic=C::t('portal_topic')->fetch($topicid)) && $topic['uid'] == $_G['uid']) {
					$allowdiy = true;
				}
			}
		}
	}
}

include_once template('portal/portal_diyhelp');

?>
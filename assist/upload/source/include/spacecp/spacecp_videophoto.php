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
 *      $Id: spacecp_videophoto.php 22572 2011-05-12 09:35:18Z zhengqingpeng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if(empty($_G['setting']['verify'][7]['available'])) {
	showmessage('no_open_videophoto');
}

if($space['videophotostatus']) {
	space_merge($space, 'field_home');
	$videophoto = getvideophoto($space['videophoto']);
} else {
	$videophoto = '';
}
$actives = array('verify' =>' class="a"');
$opactives = array('videophoto' =>' class="a"');

$operation = 'verify';
$opactives = array('videophoto' =>' class="a"');
include template("home/spacecp_videophoto");
?>
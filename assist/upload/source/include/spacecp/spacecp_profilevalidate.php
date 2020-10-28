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
 *      $Id: spacecp_profilevalidate.php 6790 2010-03-25 12:30:53Z cnteacher $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$profilevalidate = array(
	'telephone' => '/^((\\(?\\d{3,4}\\)?)|(\\d{3,4}-)?)\\d{7,8}$/',
	'mobile' => '/^(\+)?(86)?0?1\\d{10}$/',
	'zipcode' => '/^\\d{5,6}$/',
	'revenue' => '/^\\d+$/',
	'height' => '/^\\d{1,3}$/',
	'weight' => '/^\\d{1,3}$/',
	'qq' => '/^[1-9]*[1-9][0-9]*$/'
);

?>
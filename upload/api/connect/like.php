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
 *      $Id: like.php 25510 2011-11-14 02:22:26Z yexinhao $
 */

define('IN_API', true);
define('CURSCRIPT', 'api');

require_once '../../source/class/class_core.php';

$cachelist = array();
$discuz = C::app();
$discuz->init_setting = true;
$discuz->init();

$body = '';
$style = 'body { background: transparent; color: '.$_G['style']['tabletext'].'; font: '.$_G['style']['fontsize'].' '.$_G['style']['font'].'; margin:0; }'.
	'a { color: '.$_G['style']['link'].'; text-decoration: none; } a:hover { text-decoration: underline; }';

if($_G['setting']['connect']['like_allow'] && $_G['setting']['connect']['like_url']) {
	$style .= '#txQZ { border: medium none; float: left; height:21px; margin-top: 4px; overflow: hidden; width: 110px; }'.
		'.vm { vertical-align: middle; }';
	$body .= '<iframe id="txQZ" src="'.$_G['setting']['connect']['like_url'].'" class="vm" allowtransparency="true" scrolling="no" border="0" frameborder="0"></iframe>';
}

if($_G['setting']['connect']['turl_allow'] && $_G['setting']['connect']['turl_code']) {
	$style .= '#txWB_W1 { background: url("../../static/image/common/weibo.png") no-repeat scroll 0 50% transparent; float: left; line-height: 28px; padding: 0 5px 0 20px; }'.
		'#txWB_W1 img { display: none; }'.
		'#txWB_W1 b { font-weight: 400; }'.
		'#txWB_W1 a { color: '.$_G['style']['highlightlink'].'; }';
	$body .= $_G['setting']['connect']['turl_code'];
}

if($style && $body) {
	echo '<style>'.$style.'</style><body>'.$body.'</body>';
}
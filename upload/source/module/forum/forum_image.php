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
 *      $Id: forum_image.php 32531 2013-02-06 10:15:19Z zhangguosheng $
 */

if(!defined('IN_DISCUZ') || empty($_GET['aid']) || empty($_GET['size']) || empty($_GET['key'])) {
	header('location: '.$_G['siteurl'].'static/image/common/none.gif');
	exit;
}

$nocache = !empty($_GET['nocache']) ? 1 : 0;
$daid = intval($_GET['aid']);
$type = !empty($_GET['type']) ? $_GET['type'] : 'fixwr';
list($w, $h) = explode('x', $_GET['size']);
$dw = intval($w);
$dh = intval($h);
$thumbfile = 'image/'.helper_attach::makethumbpath($daid, $dw, $dh);$attachurl = helper_attach::attachpreurl();
if(!$nocache) {
	if(file_exists($_G['setting']['attachdir'].$thumbfile)) {
		dheader('location: '.$attachurl.$thumbfile);
	}
}

define('NOROBOT', TRUE);

$id = !empty($_GET['atid']) ? $_GET['atid'] : $daid;
if(dsign($id.'|'.$dw.'|'.$dh) != $_GET['key']) {
	dheader('location: '.$_G['siteurl'].'static/image/common/none.gif');
}

if($attach = C::t('forum_attachment_n')->fetch('aid:'.$daid, $daid, array(1, -1))) {
	if(!$dw && !$dh && $attach['tid'] != $id) {
	       dheader('location: '.$_G['siteurl'].'static/image/common/none.gif');
	}
        dheader('Expires: '.gmdate('D, d M Y H:i:s', TIMESTAMP + 3600).' GMT');
	if($attach['remote']) {
		$filename = $_G['setting']['ftp']['attachurl'].'forum/'.$attach['attachment'];
	} else {
		$filename = $_G['setting']['attachdir'].'forum/'.$attach['attachment'];
	}
	require_once libfile('class/image');
	$img = new image;
	if($img->Thumb($filename, $thumbfile, $w, $h, $type)) {
		if($nocache) {
			dheader('Content-Type: image');
			@readfile($_G['setting']['attachdir'].$thumbfile);
			@unlink($_G['setting']['attachdir'].$thumbfile);
		} else {
			dheader('location: '.$attachurl.$thumbfile);
		}
	} else {
		dheader('Content-Type: image');
		@readfile($filename);
	}
}

?>
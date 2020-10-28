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

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

loadcache('click');
$clicks = empty($_G['cache']['click']['picid'])?array():$_G['cache']['click']['picid'];

$picturelist = '';
$orderby = in_array($_GET['orderby'], array('thisweek', 'thismonth', 'today', 'all')) ? $_GET['orderby'] : '';

$navname = $_G['setting']['navs'][8]['navname'];
switch($_GET['view']) {
	case 'hot':
		$view = 'hot';
		$navtitle = lang('ranklist/navtitle', 'ranklist_title_picture_heat').' - '.$navname;
		$metakeywords = lang('ranklist/navtitle', 'ranklist_title_picture_heat');
		$metadescription = lang('ranklist/navtitle', 'ranklist_title_picture_heat');
		break;
	case 'sharetimes':
		$view = 'sharetimes';
		$navtitle = lang('ranklist/navtitle', 'ranklist_title_picture_share'). ' - '.$navname;
		$metakeywords = lang('ranklist/navtitle', 'ranklist_title_picture_share');
		$metadescription = lang('ranklist/navtitle', 'ranklist_title_picture_share');
		break;
	default:
		if($clicks[$_GET['view']]) {
			$view = 'click'.$_GET['view'];
			$navtitle = lang('ranklist/navtitle', 'ranklist_title_picture_'.$_GET['view']).' - '.$navname;
			$metakeywords = lang('ranklist/navtitle', 'ranklist_title_picture_'.$_GET['view']);
			$metadescription = lang('ranklist/navtitle', 'ranklist_title_picture_'.$_GET['view']);
		} else {
			$_GET['view'] = 'hot';
			$view = 'hot';
		}
}

$picturelist = getranklistdata($type, $view, $orderby);
$lastupdate = $_G['lastupdate'];
$nextupdate = $_G['nextupdate'];

include template('diy:ranklist/picture');

?>
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
 *      $Id: portalcp_related.php 30723 2012-06-14 03:49:17Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$op = in_array($_GET['op'], array('manual','search','add','get')) ? $_GET['op'] : '';
$aid = intval($_GET['aid']);
$catid = intval($_GET['catid']);
if($aid) {
	check_articleperm($catid, $aid);
} else {
	check_articleperm($catid);
}

$wherearr = $articlelist = 	$relatedarr = array();

if($op == 'manual') {
	$manualid = intval($_GET['manualid']);
	$ra = array();
	if($manualid) {
		$ra = C::t('portal_article_title')->fetch($manualid);
	}
} elseif($op == 'get') {
	$id = trim($_GET['id']);
	$getidarr = explode(',', $id);
	$getidarr = array_map('intval', $getidarr);
	$getidarr = array_unique($getidarr);
	$getidarr = array_filter($getidarr);
	if($getidarr) {
		$list = array();
		$query = C::t('portal_article_title')->fetch_all($getidarr);
		foreach($query as $value) {
			$list[$value['aid']] = $value;
		}
		foreach($getidarr as $getid) {
			if($list[$getid]) {
				$articlelist[] = $list[$getid];
			}
		}
	}
} elseif($op == 'search') {

	$catids = array();
	$searchkey = addslashes(stripsearchkey($_GET['searchkey']));
	$searchcate = intval($_GET['searchcate']);
	$catids = category_get_childids('portal', $searchcate);
	$catids[] = $searchcate;
	if($searchkey) {
		$wherearr[] = "title LIKE '%$searchkey%'";
	}
	$searchkey = dhtmlspecialchars($searchkey);
	if($searchcate) {
		$wherearr[] = "catid IN  (".dimplode($catids).")";
	}
	$wheresql = implode(' AND ', $wherearr);
	$count = C::t('portal_article_title')->fetch_all_by_sql($wheresql, '', 0, 0, 1);
	if($count) {
		$query = C::t('portal_article_title')->fetch_all_by_sql($wheresql, 'ORDER BY dateline DESC', 0, 50);
		foreach($query as $value) {
			$articlelist[] = $value;
		}
	}

} elseif($op == 'add') {
	$relatedid = trim($_GET['relatedid']);
	$relatedarr = explode(',', $relatedid);
	$relatedarr = array_map('intval', $relatedarr);
	$relatedarr = array_unique($relatedarr);
	$relatedarr = array_filter($relatedarr);
	if($relatedarr) {
		$query = C::t('portal_article_title')->fetch_all($relatedarr);
		$list = array();
		foreach($query as $value) {
			$list[$value['aid']] = $value;
		}
		foreach($relatedarr as $relateid) {
			if($list[$relateid]) {
				$articlelist[] = $list[$relateid];
			}
		}
	}

	if($_GET['update'] && $aid) {
		addrelatedarticle($aid, $relatedarr);
	}
} else {
	$count = 0;
	$query = C::t('portal_article_title')->range(0, 50);
	foreach($query as $value) {
		$articlelist[] = $value;
		$count++;
	}
}
$category = category_showselect('portal', 'searchcate', false, $_GET[searchcate]);
include_once template("portal/portalcp_related_article");
?>
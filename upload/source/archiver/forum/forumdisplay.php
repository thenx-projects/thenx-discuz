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
include loadarchiver('common/header');
?>
<div id="nav">
	<a href="./"><?php echo $_G['setting']['navs'][2]['navname']; ?></a> &rsaquo; <?php echo $_G['forum']['name']; ?>
</div>

<div id="content">
	<?php if(count($sublist)): ?>
	<ul>
		<?php foreach($sublist as $sub): ?>
		<li><a href="?fid-<?php echo $sub['fid']; ?>.html"><?php echo dhtmlspecialchars($sub['name']); ?></a></li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>
	<ul type="1" start="1">
		<?php foreach($_G['forum_threadlist'] as $thread): ?>
			<?php if($thread['isgroup'] == 0): ?>
			<li><a href="?tid-<?php echo $thread['tid']; ?>.html"><?php echo $thread['subject']; ?></a> (<?php echo $thread['replies'] . lang('forum/archiver', 'replies'); ?>)
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>
	<div class="page">
		<?php echo arch_multi($_G['forum_threadcount'], $_G['tpp'], $page, "?fid-$_G[fid].html"); ?>
	</div>
</div>

<div id="end">
	<?php echo lang('forum/archiver', 'full_version'); ?>:
	<a href="../<?php echo in_array('forum_forumdisplay', $_G['setting']['rewritestatus']) ? rewriteoutput('forum_forumdisplay', 1, '', $_G['fid'], $page) : 'forum.php?mod=forumdisplay&fid='.$_G['fid'].'&page='.$page; ?>" target="_blank"><strong><?php echo $_G['forum']['name']; ?></strong></a>
</div>
<?php include loadarchiver('common/footer'); ?>
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
	<a href="./"><strong><?php echo $_G['setting']['bbname']; ?></strong></a>
</div>
<div id="content">
	<?php foreach($catlist as $key => $cat): ?>
	<h3><?php echo $cat['name']; ?></h3>
	<?php if(!empty($cat['forums'])): ?>
	<ul>
		<?php foreach($cat['forums'] as $fid): ?>
		<li><a href="?fid-<?php echo $fid; ?>.html"><?php echo $forumlist[$fid]['name']; ?></a></li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>
	<?php endforeach; ?>
</div>
<div id="end">
	<?php echo lang('forum/archiver', 'full_version'); ?>:
	<a href="../forum.php" target="_blank"><strong><?php echo $_G['setting']['bbname']; ?></strong></a>
</div>
<?php include loadarchiver('common/footer'); ?>
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
 *      $Id: class_optimizer.php 30871 2012-06-27 09:32:37Z zhangjie $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class optimizer {

	private $optimizer = array();

	public function __construct($type) {
		$this->optimizer = new $type();
	}


	public function check() {
		return $this->optimizer->check();
	}

	public function optimizer() {
		return $this->optimizer->optimizer();
	}

	public function option_optimizer($options) {
		return $this->optimizer->option_optimizer($options);
	}

	public function get_option() {
		return $this->optimizer->get_option();
	}
}
?>
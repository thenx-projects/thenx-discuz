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
 *      $Id: discuz_base.php 30321 2012-05-22 09:09:35Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

abstract class discuz_base
{
	private $_e;
	private $_m;

	public function __construct() {

	}

	public function __set($name, $value) {
		$setter='set'.$name;
		if(method_exists($this,$setter)) {
			return $this->$setter($value);
		} elseif($this->canGetProperty($name)) {
			throw new Exception('The property "'.get_class($this).'->'.$name.'" is readonly');
		} else {
			throw new Exception('The property "'.get_class($this).'->'.$name.'" is not defined');
		}
	}

	public function __get($name) {
		$getter='get'.$name;
		if(method_exists($this,$getter)) {
			return $this->$getter();
		} else {
			throw new Exception('The property "'.get_class($this).'->'.$name.'" is not defined');
		}
	}

	public function __call($name,$parameters) {
		throw new Exception('Class "'.get_class($this).'" does not have a method named "'.$name.'".');
	}

	public function canGetProperty($name)
	{
		return method_exists($this,'get'.$name);
	}

	public function canSetProperty($name)
	{
		return method_exists($this,'set'.$name);
	}

	public function __toString() {
		return get_class($this);
	}

	public function __invoke() {
		return get_class($this);
	}

}
?>
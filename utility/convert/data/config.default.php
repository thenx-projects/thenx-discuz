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
 * DiscuzX Convert
 *
 * $Id: index.php 8 2010-04-07 03:56:45Z Cnteacher $
 */

$_config['source']['dbhost'] = 'localhost';
$_config['source']['dbuser'] = 'root';
$_config['source']['dbpw'] = '';
$_config['source']['dbname'] = 'discuz';
$_config['source']['tablepre'] = 'cdb_';
$_config['source']['dbcharset'] = '';
$_config['source']['pconnect'] = '1';

$_config['target']['dbhost'] = 'localhost';
$_config['target']['dbuser'] = 'root';
$_config['target']['dbpw'] = '';
$_config['target']['dbname'] = 'discuzx';
$_config['target']['tablepre'] = 'pre_';
$_config['target']['dbcharset'] = '';
$_config['target']['pconnect'] = '1';

$_config['ucenter']['dbhost'] = '';
$_config['ucenter']['dbuser'] = '';
$_config['ucenter']['dbpw'] = '';
$_config['ucenter']['dbname'] = '';
$_config['ucenter']['tablepre'] = '';
$_config['ucenter']['dbcharset'] = '';
$_config['ucenter']['pconnect'] = '1';

?>
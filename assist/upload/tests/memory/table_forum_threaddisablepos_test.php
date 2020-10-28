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

class TestThreadDisablePos
{
        private $bydb;
        private $bymem;

        function setUp() {
                $oldvalue = C::memory()->enable;
                C::memory()->enable = false;
                $this->bydb = new table_forum_threaddisablepos();
                C::memory()->enable = true;
                $this->bymem = new table_forum_threaddisablepos();
                C::memory()->enable = $oldvalue;
        }

        function testMemInsert() {
                $this->bymem->truncate();
                $this->bymem->insert(array('tid' => 1234));
                assertTrue($this->bymem->fetch(1234));
                $this->bymem->truncate();
                assertFalse($this->bymem->fetch(1234));
        }

        function testDbInsert() {
                $this->bydb->truncate();
                $this->bydb->insert(array('tid' => 1234));
                assertTrue($this->bydb->fetch(1234));
                $this->bydb->truncate();
                assertFalse($this->bydb->fetch(1234));
        }
}
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

function is_valid($ip)
{
    return filter_var($ip, FILTER_VALIDATE_IP) !== FALSE;
}

class TestFilterVar
{
    function testTrue()
    {
        assertTrue(is_valid("64:ff9b::10.10.10.10"));
        assertTrue(is_valid("::1"));
        assertTrue(is_valid("fe80::8902:43d1:fa45:d468"));
        assertTrue(is_valid("FE80::1"));
    }

    function testFalse()
    {
        assertFalse(is_valid("[::1]"));
        assertFalse(is_valid("[::1]:8080"));
    }

    function testScopped()
    {
        assertFalse(is_valid("fe80::8902:43d1:fa45:d468/64"));
        assertFalse(is_valid("fe80::8902:43d1:fa45:d468%10"));
        assertFalse(is_valid("fe80::8902:43d1:fa45:d468%eth0"));
    }


    function testWithMask()
    {
        assertFalse(is_valid("::ffff:192.1.56.10/96"));
    }
}

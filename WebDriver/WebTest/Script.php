<?php
/**
 * Copyright 2011-2012 Anthon Pang. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package WebDriver
 *
 * @author Anthon Pang <anthonp@nationalfibre.net>
 */

/**
 * abstract WebDriver_WebTest_Script class
 *
 * @package WebDriver
 */
abstract class WebDriver_WebTest_Script
{
    /**
     * Session
     *
     * @var WebDriver_Session
     */
    protected $session;

    /**
     * Tally on assertions
     *
     * @var array
     */
    protected $assertStats;

    /**
     * Constructor
     *
     * @param WebDriver_Session $session
     */
    public function __construct($session)
    {
        $this->session = $session;
        $this->assertStats = array(
            'pass' => 0,
            'failure' => 0,
            'total' => 0,
        );
    }

    /**
     * Assert (expect) value
     *
     * @param mixed  $expression Expression
     * @param mixed  $expected   Expected
     * @param string $message    Message
     *
     * @throw WebDriver_Exception_WebTestAssertion if $expression is not equal to $expected
     */
    protected function assert($expression, $expected, $message)
    {
        $this->assertStats['total']++;

        if ($expression !== $expected) {
            $this->assertStats['failure']++;

            throw WebDriver_Exception::factory(WebDriver_Exception::WEBTEST_ASSERTION, $message);
        }

        $this->assertStats['pass']++;
    }

    /**
     * Assert (expect) exception
     *
     * @param function $callback Callback function
     * @param string   $message  Message
     *
     * @throw WebDriver_Exception_WebTestAssertion if not exception is thrown
     */
    protected function assertException($callback, $message)
    {
        $this->assertStats['total']++;

        try {
            $callback();

            $this->assertStats['failure']++;
            throw WebDriver_Exception::factory(WebDriver_Exception::WEBTEST_ASSERTION, $message);
        } catch (Exception $e) {
            // expected exception
        }

        $this->assertStats['pass']++;
    }
}

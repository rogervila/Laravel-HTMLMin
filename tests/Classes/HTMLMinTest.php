<?php

/**
 * This file is part of Laravel HTMLMin by Graham Campbell.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace GrahamCampbell\Tests\HTMLMin\Classes;

use Mockery;
use GrahamCampbell\HTMLMin\Classes\HTMLMin;
use GrahamCampbell\TestBench\Classes\AbstractTestCase;

/**
 * This is the htmlmin test class.
 *
 * @package    Laravel-HTMLMin
 * @author     Graham Campbell
 * @copyright  Copyright 2013-2014 Graham Campbell
 * @license    https://github.com/GrahamCampbell/Laravel-HTMLMin/blob/master/LICENSE.md
 * @link       https://github.com/GrahamCampbell/Laravel-HTMLMin
 */
class HTMLMinTest extends AbstractTestCase
{
    public function testBladeEnabled()
    {
        $htmlmin = $this->getHTMLMin();

        $return = $htmlmin->blade('test    123');

        $this->assertEquals($return, 'test 123');

        $return = $htmlmin->blade('test    <div></div>');

        $this->assertEquals('test <div></div>', $return);
    }

    public function testBladeDisabled()
    {
        $htmlmin = $this->getHTMLMin();

        $return = $htmlmin->blade('test    <textarea></textarea>');

        $this->assertEquals('test    <textarea></textarea>', $return);

        $return = $htmlmin->blade('test    <pre></pre>');

        $this->assertEquals('test    <pre></pre>', $return);
    }

    public function testRenderQuick()
    {
        $htmlmin = $this->getHTMLMin();

        $return = $htmlmin->render('test');

        $this->assertEquals('test', $return);
    }

    public function testRenderFull()
    {
        $htmlmin = $this->getHTMLMin();
        $html = 'test<style>font-size: 12pt;</style><script>alert("Hello");</script>';

        $return = $htmlmin->render($html);

        $this->assertEquals($html, $return);
    }

    public function testMakeBlade()
    {
        $htmlmin = $this->getHTMLMin();

        $view = Mockery::mock('Illuminate\View\View');

        $view->shouldReceive('render')->once()->andReturn('test');

        $htmlmin->getView()->shouldReceive('make')->once()
            ->with('test', array('example' => 'qwerty'))->andReturn($view);

        $return = $htmlmin->make('test', array('example' => 'qwerty'));

        $this->assertEquals('test', $return);
    }

    public function testMakeFull()
    {
        $htmlmin = $this->getHTMLMin();
        $html = 'test<style>font-size: 12pt;</style><script>alert("Hello");</script>';

        $view = Mockery::mock('Illuminate\View\View');

        $view->shouldReceive('render')->once()->andReturn($html);

        $htmlmin->getView()->shouldReceive('make')->once()
            ->with($html, array('example' => 'qwerty'))->andReturn($view);

        $return = $htmlmin->make($html, array('example' => 'qwerty'), true);

        $this->assertEquals($html, $return);
    }

    protected function getHTMLMin()
    {
        $view = Mockery::mock('Illuminate\View\Environment');

        return new HTMLMin($view);
    }
}
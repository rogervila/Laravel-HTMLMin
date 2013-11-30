<?php namespace GrahamCampbell\HTMLMin\Classes;

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
 *
 * @package    Laravel-HTMLMin
 * @author     Graham Campbell
 * @license    Apache License
 * @copyright  Copyright 2013 Graham Campbell
 * @link       https://github.com/GrahamCampbell/Laravel-HTMLMin
 */

use Illuminate\View\Compilers\BladeCompiler;

class HTMLMinCompiler extends BladeCompiler {

    /**
     * The htmlmin instance.
     *
     * @var \GrahamCampbell\HTMLMin\Classes\HTMLMin
     */
    protected $min;

    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct($min, $files, $cache) {
        parent::__construct($files, $cache);
        $this->min = $min;
        $this->compilers[] = 'Minify';
    }
    /**
    * Minifies the HTML output before saving it.
    *
    * @param  string  $value
    * @return string
    */
    protected function compileMinify($value) {
        return $this->min->blade($value);
    }
}
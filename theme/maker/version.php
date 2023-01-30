<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

defined('MOODLE_INTERNAL') || die();

$plugin->version   = 2022112801;
$plugin->release  = 'Moodle 4.1 Maker v10.0';
$plugin->maturity  = MATURITY_STABLE;
$plugin->requires  = 2022041200; 
$plugin->component = 'theme_maker';
$plugin->dependencies = array(
    'theme_boost'  => 2022041900, //Parent: boost
);

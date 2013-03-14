<?php
/*
* Copyright (c) 2012 Jason Hancock <jsnbyh@gmail.com>
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is furnished
* to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
* THE SOFTWARE.
*
* This file is part of the nagios-puppet bundle that can be found
* at https://github.com/jasonhancock/nagios-cpu
*/

$alpha = 'CC';

$colors = array(
    '#941342' . $alpha,
    '#435247' . $alpha,
    '#00CBF6' . $alpha,
    '#BFBD82' . $alpha,
    '#C5031A' . $alpha,
    '#F39034' . $alpha,
    '#3D282A' . $alpha,
    '#33369E' . $alpha,
    '#08A000' . $alpha
);

$vlabel = 'Percent';
    
$opt[1] = sprintf('-T 55 -l 0 --vertical-label "%s" --title "%s / CPU Usage"', $vlabel, $hostname);
$def[1] = '';
$ds_name[1] = 'CPU Usage';

foreach ($DS as $i) {
    $def[1] .= rrd::def("var$i", $rrdfile, $DS[$i], 'AVERAGE');

    if ($i == '1') {
        $def[1] .= rrd::area ("var$i", $colors[$i-1], rrd::cut(ucfirst($NAME[$i]), 15));
    } else {
        $def[1] .= rrd::area ("var$i", $colors[$i-1], rrd::cut(ucfirst($NAME[$i]), 15), 'STACK');
    }

    $def[1] .= rrd::gprint  ("var$i", array('LAST','MAX','AVERAGE'), "%4.0lf %s\\t");
}

$def[1] .= 'COMMENT:"' . $TEMPLATE[$i] . '\r" ';


$opt[2] = sprintf('-T 55 -l 0 --vertical-label "%s" --title "%s / CPU Usage (sans idle)"', $vlabel, $hostname);
$def[2] = '';
$ds_name[2] = 'CPU Usage (sans idle)';

foreach ($DS as $i) {
    $def[2] .= rrd::def("var$i", $rrdfile, $DS[$i], 'AVERAGE');

    if($i == 4)
        continue;

    if ($i == '1') {
        $def[2] .= rrd::area ("var$i", $colors[$i-1], rrd::cut(ucfirst($NAME[$i]), 15));
    } else {
        $def[2] .= rrd::area ("var$i", $colors[$i-1], rrd::cut(ucfirst($NAME[$i]), 15), 'STACK');
    }

    $def[2] .= rrd::gprint  ("var$i", array('LAST','MAX','AVERAGE'), "%4.0lf %s\\t");
}

$def[2] .= 'COMMENT:"' . $TEMPLATE[$i] . '\r" ';


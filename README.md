nagios-cpu
=============

A nagios plugin and supporting pnp4nagios templates to graph all of the various
types of cpu utilization.

![check_cpu](https://github.com/jasonhancock/nagios-cpu/raw/master/example-images/check_cpu.png)

License
-------
Copyright (c) 2012 Jason Hancock <jsnbyh@gmail.com>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is furnished
to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

Installation
------------

Copy the check\_cpu from the plugins directory into your nagios plugins directory.
This plugin runs locally on a machine via NRPE, so you will need to do this for
any machine you wish to monitor.

On the nagios server, copy the pnp4nagios/check\_commands/check\_cpu.cfg into
your pnp4nagios check\_commands directory (ususally /etc/pnp4nagios/check\_commands).
Copy the pnp4nagios/templates/check\_cpu.php into your pnp4nagios templates directory.

NRPE Configuration
------------------

Add the following to your NRPE configuration file and restart NRPE (adjust the plugin
path as necessary):

```
command[check_cpu]=/usr/lib64/nagios/plugins/check_cpu
```

Nagios Configuration
--------------------

Assuming you already have a check\_nrpe command defined, you simply need to add
a service definition:

```
define service{
    use                  generic-service-graphed
    service_description  CPU Usage 
    hostgroups           Linux Servers 
    check_command        check_nrpe!check_cpu
}
```

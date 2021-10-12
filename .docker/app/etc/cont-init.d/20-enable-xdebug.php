#!/usr/bin/with-contenv php
<?php

$xdebug = getenv('XDEBUG_ENABLE');

if ('1' !== $xdebug) {
    unlink('/etc/php/7.4/fpm/conf.d/20-xdebug.ini');
    unlink('/etc/php/7.4/cli/conf.d/20-xdebug.ini');
}

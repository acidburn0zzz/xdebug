--TEST--
Test for bug #1841: 'match' keyword [2]
--XFAIL--
PHP shows assignment on wrong line (9 instead of 6)
--SKIPIF--
<?php
require __DIR__ . '/../utils.inc';
check_reqs('PHP >= 8.0');
?>
--INI--
xdebug.mode=coverage
xdebug.start_with_request=trigger
opcache.optimization_level=0
--FILE--
<?php
require __DIR__ . '/../utils.inc';

xdebug_start_code_coverage(XDEBUG_CC_UNUSED | XDEBUG_CC_DEAD_CODE);

require dirname(__FILE__) . '/bug01841-002.inc';

$cc = xdebug_get_code_coverage();

ksort( $cc );
$fileInfo = array_values( array_slice( $cc, 0, 1 ) )[0];
mustBeExecuted( $fileInfo, [ 12, 4, 6, 7 ] );
mustNotBeExecuted( $fileInfo, [ 8, 9 ] );
?>
--EXPECTF--
line #12 is present and covered
line #4 is present and covered
line #6 is present and covered
line #7 is present and covered
line #8 is present and not covered
line #9 is present and not covered

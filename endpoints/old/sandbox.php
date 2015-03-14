<?php

/**
 *
 * External PHP Sandbox Layer
 *
 */

$timeout = intval($argv[1]);
$script_id = $argv[2];

set_time_limit($timeout);

echo $timeout;

echo "\n";

flush();
exit;
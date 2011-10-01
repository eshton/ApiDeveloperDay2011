<?php

include 'lib/BUTESmsSender.php';

$test = new BUTESmsSender(false);
$test->send('447513389091', 'LOLLER');
<?php
require_once __DIR__."/vendor/autoload.php";

use Bbnsms\SMSClient;

$smsclient = new SMSClient();
printf("Valid Credentials: %s", $smsclient->testCredentials());
echo PHP_EOL;
printf("Balance: %.2f", $smsclient->getBalance());
echo PHP_EOL;
printf("Send Response: %s", $smsclient->send("Hello", "BBN LAB", ["2348183172770","2349090000246"], 0));
echo PHP_EOL;
// printf("Scheduler Response: %s", $smsclient->schedule(time() + 60, "SchedTstr", "Hello", "BBN LAB", ["2348183172770"], 0));
echo PHP_EOL;
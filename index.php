<?php

use Dreamcasa\LeadEasyTest\AppProvider\App;
use Dreamcasa\LeadEasyTest\LeadData;
use Dreamcasa\LeadEasyTest\Sender;
use Dreamcasa\LeadEasyTest\User;

require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$providerApp = new App();
$user = new User();

$lead = LeadData::factory(
    'AP1234',
    'Person Name',
    'email@example.com',
    '551199999999',
    'Message is here'
);

$sender = new Sender();
$sender->sendLead($providerApp, $lead, $user);
exit(1);

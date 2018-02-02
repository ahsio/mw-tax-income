<?php

require './vendor/autoload.php';

use MW\Application\Tax\RuleSet;
use MW\Application\Tax\TaxAmount;
use MW\Infrastructure\Delivery\CLI\TaxAmountCommand;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Console\Application;

try {
    $rules = Yaml::parseFile('./config/app.yml');
} catch (ParseException $e) {
    printf('Unable to parse the YAML string: %s', $e->getMessage());
}

$ruleSet = new RuleSet($rules['default']['rules']);

$taxAmount = new TaxAmount($ruleSet);

$application = new Application();

$application->add(new TaxAmountCommand($taxAmount));

$application->run();

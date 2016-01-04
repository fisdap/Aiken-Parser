<?php

require('../vendor/autoload.php');

$file = './aiken.txt';

$aiken = new \Fisdap\Aiken\Parser\AikenParser($file);
$itemCollection = $aiken->buildTestItemCollection();

echo "<pre>";
var_dump($itemCollection->toArray());
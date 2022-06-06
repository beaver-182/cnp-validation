<?php

require './src/validation.php';

$randomCnp = generateCnp();

echo "Random generated CNP $randomCnp is ".(isCnpValid($randomCnp) ? 'valid':'invalid');

echo "<br/><br/>";

//check your cnp here
$testCNP = '5120620448584';
echo "This CNP $testCNP is ".(isCnpValid($testCNP) ? 'valid':'invalid');
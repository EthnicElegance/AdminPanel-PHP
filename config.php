<?php
require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;


$factory = (new Factory())
    ->withDatabaseUri('https://ethincelegance-default-rtdb.firebaseio.com/');
$database = $factory->createDatabase();
?>
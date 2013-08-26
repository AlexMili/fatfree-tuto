<?php
$f3=require('base.php');
$f3->route('GET /',
    function() {
        echo 'Hello World!';
    }
);
$f3->route('GET|POST /about/@prenom',
    function($f3) {
        echo 'Hello ' .$f3->get('PARAMS.prenom');
    }
);
$f3->config('config.cfg');
$f3->run();
?>
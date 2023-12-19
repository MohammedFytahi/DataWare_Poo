<?php
interface test {
    public function index();
}
abstract class Band {
    
}

class child implements test {
    function __construct($name) {

        echo $name;
    }
    public function index() {
        echo "test";
    }
}

class child1 implements test {
    public static function index() {
        echo "test 1";
    }
}

$obj = new child("zouhir");
$obj1 = new child1();

child1::index();
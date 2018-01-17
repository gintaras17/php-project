<?php

class Car {
    public $wheels = 4; //galima matyti visur
    protected $hood = 1;    //galima matyti tik subklases viduje arba tos klases metode
    private $engine = 1;    //galima matyti tik tos klases metodo viduje
    var $doors = 4;
    
    function showProperty() {
        echo $this->engine;
    }
    
}

$bmw = new Car();
$semi = new Semi();
class Semi extends Car {
    
}
echo $bmw->showProperty();

?>
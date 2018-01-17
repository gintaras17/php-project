<?php

class Car {
    var $wheels = 4;
    var $hood = 1;
    var $engine = 1;
    var $doors = 4;
    
    function MoveWheels() {
        $this->wheels = 10;
        //echo "Wheels move";
    }
    
    function CreateDoors(){
        $this->doors = 6;
    }
}

$bmw = new Car();
$truck = new Car();
//$bmw->MoveWheels();
//$bmw->wheels = 8;
//echo $bmw->wheels;
echo $bmw->wheels . "<br>";

echo $truck->wheels = 10 . "<br>";
$truck->CreateDoors();

echo $truck->doors;


?>
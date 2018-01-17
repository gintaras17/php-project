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

class Plane extends Car {   //paveldejimas is kitos klases
    var $wheels = 20;
}

$jet = new Plane();
//$jet->MoveWheels();
echo $jet->wheels;

//if(class_exists("Plane")) {
 //   echo "it does";
//}

?>
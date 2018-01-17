<?php

class Car {
    static $wheels = 4;     //reiskia kad pridetas dabar prie sios klases ir nepridetas prie $variable = new variable();, todel negalime daugiau jo naudoti kaip iprate-gausime klaida, turim naudoti kitaip    Galime naudoti bet kur, kur naudojame class.
    var $hood = 1;
    
    function MoveWheels() {
        //$this->wheels = 10;
        Car::$wheels = 10;      //arba galime iskviesti tokiu budu
    }
    
 
}

$bmw = new Car();       //pirmiausia darome nauja klase ir tik tuomet galima kazka daryti su ja

//echo $bmw->wheels;       //static nepanaudosi nei prie echo, nei be jo.

Car::MoveWheels();      //jeigu kvieciame is metodo, reikia kviesti metoda, nebe prideta reiksme.

echo Car::$wheels;      //noredami parodyti static reiksme, turime iskviesti butent ta klase, kurioje static reiksme yra, tad naudojame "::" vietoje "->" ir turime naudoti $ zenkla, nes tai kintamasis, ne reikalavimas. Taip pat galime tureti static metodus toje klaseje.

?>
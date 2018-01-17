<?php

class Car {
    function MoveWheels() {
        echo "Wheels move";
    }
}






if(method_exists("Car", "MoveWheels")) {
    echo "method exists";
} else {
    echo "does not";
}

?>
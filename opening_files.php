<?php

$file = "example.txt";

$handle = fopen($file, 'w');        //"w" - write, reiskia rasyti

fclose($handle);        //butinai reikia fclose, nes be jo gali buti bedu..



?>
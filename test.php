<?php

echo password_hash('secret', PASSWORD_BCRYPT, array('cost' => 12) );	//paskutinis yra skaicius del sios funkcijos tam tikro veikimo greicio, didesnis skaicius duos didesne apkrova serveriui, tai  bus leciau, mazesnis bus greiciau, bet tai nera labai gerai..



?>
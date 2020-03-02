<?php

	$db = new mysqli('localhost', 'root', '', 'awebdes');

	if(!$db){
		echo "connection error";
	}

?>
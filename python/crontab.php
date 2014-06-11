<?php

include("funktionen.php");


switch( $_GET['func'] ){
	

	
	case 'midnight':

		calculate_strom();
		rotateLog();
		break;
	
	
		
		default:
		break;
}	
		

?>
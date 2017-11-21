<?php

// # DEBUGGING & AUTOLOADER
//include 'debug.php'; 	// comment out when done!
include 'autoload.php';

include 'dbVars.php';

// # INSTANTIATE PROGRAM OBJECT
$obj = new main();

class main {
	
	private $html; 	// for output string
	
	public function __construct() {
		// begin building output 
		
		// ## PAGE NAME from 'page' param (default = 'homepage')
		$pageRequest = pageBuild::getName();
		
		$page = new $pageRequest;

		if($_SERVER['REQUEST_METHOD'] == 'GET') {
			$page->get();
		} else {
			$page->post();
		}
	}
	
	public function __destruct() {
		// echo $this->html;
	}
}

// ## NO OTHER CLASSES SHOULD REMAIN HERE

// ## COLLECTIONS.php:	class table extends collection { protected static $modelname = 'table'; }
// ## MODELS.php: 		class table extends model { public $column; } plus a __construct()er, where $this->tableName = 'tableName';


/*
TODOS:
-page chooser (params: operation, table[, id])
-CREATE	(...done?)
-READ	(needs formatting)
-UPDATE
-DELETE
*/

echo '<hr>';

?>

<?php

// a page has no name...
abstract class page {
	protected $html;

	public function __construct() {
		$this->html = pageBuild::PageHeader();
	}
    
	public function __destruct() {
		$this->html .= pageBuild::pageEnder();
		echo $this->html;
	}

	public function get() {
		echo 'default get message';
	}

	public function post() {
		//print_r($_POST);
	}
}

// index.php?page=homepage
class homepage extends page {
	public function get() {
		// print error message, because you should be gone by now...
		if ($table == NULL)
			header(pageBuild::redirect());
		$this->html .= htmlTags::heading('WHY ARE YOU HERE?!');
	}
	
	public function post() {
		// print error message, because you should be gone by now...
		$this->html .= htmlTags::heading('WHY ARE YOU HERE?!');
	}
}

// index.php?page=create
class create extends page {
	public function get() {
		// get table
		$table = pageBuild::getParam('table');
		
		$this->html .= htmlTags::formBuild($table, get_class());
	}

	public function post() {
		// debug $_POST
		echo htmlTags::preObj($_POST);
		//This is how you would save a new todo item
		$table = pageBuild::getParam('table');
		
		$record = $table::create();

		if ($table == 'accounts')
			pageSave::saveAccounts($record);
		if ($table == 'todos')
			pageSave::saveTodos($record);
		
		$record->save();
		echo htmlTags::preObj($record);
	}
}

// index.php?page=read
class read extends page {
	public function get() {
		// get params
		$table = pageBuild::getParam('table');
		$id = pageBuild::getParam('id');
		
		if ($id == NULL) {
			// if no $id specified, findAll();
			$this->html .= htmlTags::heading('Find all ' . $table . ':');
			$records = $table::findAll();
		} else {
			// otherwise, find by ID
			$this->html .= htmlTags::heading('Find id '. $id . ' from ' . $table . ':');
			$records = $table::findOne($id);
		}		
		
		$this->html .= htmlTags::preObj($records);
	}
}

// index.php?page=update
class update extends page {
	public function get() {
		// get table
		$table = pageBuild::getParam('table');
		$id = pageBuild::getParam('id');
		
		// if no $id specified, go home
		if ($id == NULL) {
			header(pageBuild::redirect());
		} else {
			// find the record
			$record = $table::findOne($id);
			$this->html .= htmlTags::heading('Find id '. $id . ' from ' . $table . ':');
			
			// build the form (with preload data)
			$this->html .= htmlTags::formBuild($table, get_class(), $record);
		}		
		
		$this->html .= htmlTags::preObj($record);
	}

	public function post() {
		//method for updating one record
		$id = pageBuild::getParam('id');
		$table = pageBuild::getParam('table');
		
		$record = $table::create();

		$record->id = $id;
		if ($table == 'accounts')
			pageSave::saveAccounts($record);
		if ($table == 'todos')
			pageSave::saveTodos($record);
		
		$record->save();

		$this->html .= htmlTags::preObj($record);
	}
}

// index.php?page=remove
class remove extends page {
	public function get() {
		// get table
		$table = pageBuild::getParam('table');
		$id = pageBuild::getParam('id');
		
		// if no $id specified, go home;
		if ($id == NULL) {
			header(pageBuild::redirect());
		} else {
			$this->html .= htmlTags::heading('Find id '. $id . ' from ' . $table . ':');
			$record = $table::findOne($id);
			$this->html .= htmlTags::preObj($record);
			
			// form for delete
			$this->html .= htmlTags::formBuild($table, get_class(), $record);
		}
	}
	
	public function post() {
		//method for updating one record
		$id = pageBuild::getParam('id');
		$table = pageBuild::getParam('table');
		//$table = rtrim($table, 's');
		$record = $table::findOne($id);
		
		$record->delete();
		
		//$record->save();
		$this->html .= htmlTags::preObj($record);
	}

}

?>
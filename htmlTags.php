<?php

class htmlTags {	

	// ## SIMPLE ONES: <title>, <h1>, <a>, <br>, <pre>
	public static function makeTitle($str) {			
		return '<title>' . $str . '</title>';
	}
	
	public static function heading($str) {
		return '<h1>' . $str . '</h1>';
	}

	public static function href($link, $str = NULL) {
		$text = ($str == NULL) ? $link : $str;
		
		return '<a href=' . $link . '>' . $text . '</a>';
	}
	
	public static function lineBreak() {
			return '<br>';
	}
	
	public static function pre($str) {
		return '<pre>' . $str . '</pre>';
	}
	
	// like the above, but for arrays/objects
	public static function preObj($obj) {
		return htmlTags::pre(print_r($obj, true));
	}
	
	// ## listMaker: <ol> & <ul>
	public static function listMaker($arr, $ordered) {
		$list = htmlTags::listMaker($ordered, 0);
		foreach ($arr as $item) {
			$list .= '<li>' . $item . '</li>';
		}
		$list .= htmlTags::listMaker($ordered, 1);
		
		return $list;
	}
	
	private static function listTag($ordered, $close) {
		if ($ordered) {
			$type = 'ol';
		} else {
			$type = 'ul';
		}
		
		if ($close) {
			$close = '/';
		}
		
		return '<' . $close . $type . '>';
	}
	
	// ## form builder (str Title, str PageName)
	public static function formBuild($table, $operation, $data = NULL) {
		
		$id = pageBuild::getParam('id');
		$form  = htmlTags::heading(ucwords($table));
		
		$form .= htmlTags::formAction($table, $operation, $id);
		if ($operation != 'remove') {
			$form .= ($table == 'accounts') ?
				htmlTags::accountFormInputs($data) :
				htmlTags::todoFormInputs($data);
		}
		
		$form .= '<input type="submit" value="'. $operation .
				'" name="submit">';
		$form .= '</form> ';
		
		return $form;
	}
	
	public static function formAction($table, $operation, $id) {
		$action = '<form action="index.php?';
		$action .= 'page=' . $operation . '&table=' . $table;
		if ($id != NULL)
			$action .= '&id=' . $id;
		$action .= '" method="post" enctype="multipart/form-data">';
		
		return $action;
	}
	
	public static function formInput($name, $val = NULL, $type = 'text') {
		// echo '--- ' . $val . ' ---' . htmlTags::lineBreak();
		$input = '<input type="' . $type . '" ' .
					 'name="' . $name . '" ' .
					 'id="'   . $name . '" ' . 
					 'value="'. $val  . '">';
		
		return $input;
	}
	
	public static function accountFormInputs($data) {
		// all 'account' form inputs
		$inputs  = 'EMAIL: ' . 
			htmlTags::formInput('email', $data->email) . 
			htmlTags::lineBreak();
		$inputs .= 'FIRST NAME: ' . 
			htmlTags::formInput('fname', $data->fname) . 
			htmlTags::lineBreak();
		$inputs .= 'LAST NAME: ' . 
			htmlTags::formInput('lname', $data->lname) .
			htmlTags::lineBreak();
		$inputs .= 'PHONE: ' . 
			htmlTags::formInput('phone', $data->phone) . 
			htmlTags::lineBreak();
		$inputs .= 'BIRTHDAY: ' . 
			htmlTags::formInput('birthday', $data->birthday, 'datetime') . htmlTags::lineBreak();
		$inputs .= 'GENDER: ' . 
			htmlTags::formInput('gender', $data->gender) .
			htmlTags::lineBreak();
		$inputs .= 'PASSWORD: ' . 
			htmlTags::formInput('password', $data->password) . 
			htmlTags::lineBreak();
		
		return $inputs;
	}
	
	public static function todoFormInputs($data) {
		// all 'todo' form inputs
		$inputs  = 'OWNER EMAIL: ' . 
			htmlTags::formInput('owneremail', $data->owneremail) .
			htmlTags::lineBreak();
		$inputs .= 'OWNER ID: ' . 
			htmlTags::formInput('ownerid', $data->ownerid) .
			htmlTags::lineBreak();
		$inputs .= 'CREATED DATE: ' . 
			htmlTags::formInput('createddate', $data->createddate, 'datetime') . 
			htmlTags::lineBreak();
		$inputs .= 'DUE DATE: ' . 
			htmlTags::formInput('duedate', $data->duedate, 'datetime') .
			htmlTags::lineBreak();
		$inputs .= 'MESSAGE: ' . 
			htmlTags::formInput('message', $data->message) .
			htmlTags::lineBreak();
		$inputs .= 'IS DONE: ' . 
			htmlTags::formInput('isdone', $data->isdone) . 
			htmlTags::lineBreak();
		
		return $inputs;
	}

}
?>

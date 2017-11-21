<?php

class pageSave extends page {
	public static function saveAccounts($record) {
		$record->email = $_POST['email'];
		$record->fname = $_POST['fname'];
		$record->lname = $_POST['lname'];
		$record->phone = $_POST['phone'];
		$record->birthday = $_POST['birthday'];
		$record->gender = $_POST['gender'];
		$record->password = $_POST['password'];
	}
			
	public static function saveTodos($record) {
		$record->owneremail = $_POST['owneremail'];
		$record->ownerid = $_POST['ownerid'];
		$record->createddate = $_POST['createddate'];
		$record->duedate = $_POST['duedate'];
		$record->message = $_POST['message'];
		$record->isdone = $_POST['isdone'];
	}
}
?>
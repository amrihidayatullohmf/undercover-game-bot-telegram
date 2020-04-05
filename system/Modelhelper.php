<?php
class Modelhelper {
	private $dbhelper;

	function __construct($dbhelper) {
		$this->dbhelper = $dbhelper;
	}

	public function isUserExist($chatID) {
		$check = $this->dbhelper->get_where('ub_players',['ID'=>$chatID]);
		return (count($check) > 0) ? TRUE : FALSE;
	}

	public function insertUser($chatID,$fullName,$userName,$phone) {
		return $this->dbhelper->insert('ub_players',[
											'ID' => $chatID,
											'fullname' => $fullName,
											'username' => $userName,
											'phone_number' => $phone,
											'total_score' => 0,
											'created_date' => date('Y-m-d H:i:s')
										]);
	}

	public function loginfo($infos) {
		return $this->dbhelper->insert('ub_chat_logs',[
											'chatID' => $infos['chatID'],
											'message' => $infos['text'],
											'fullname' => $infos['fullName'],
											'username' => $infos['userName'],
											'type_user' => $infos['userType'],
											'created_date' => date('Y-m-d H:i:s')
										]);
	}

}
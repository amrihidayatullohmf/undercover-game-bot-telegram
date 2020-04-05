<?php
class Telegramhelper {
	private $apiKey;
	private $apiHost;
	private $apiURL;
	private $siteURL;
	private $userInfo;
	private $configs;

	function __construct($configs) {
		$this->apiHost = $configs['telegramhost'];
		$this->apiKey = $configs['telegramkey'];
		$this->apiURL = $configs['telegramhost'].$configs['telegramkey'];
		$this->siteURL = $configs['siteurl'];

		$this->configs = $configs;
	}

	public function extractChatInformation($json) {
		$data = json_decode($json);

		if(!isset($data->message->chat->id)) {
			return FALSE;
		}

		$this->userInfo = $data;

		$text = strtolower($this->userInfo->message->text);
		$text = str_replace("@undergroundmf_bot", "", $text);

		return [
			'chatID' => $this->userInfo->message->chat->id,
			'text' => $text,
			'fullName' => $this->userInfo->message->from->first_name." ".$this->userInfo->message->from->last_name,
			'userName' => $this->userInfo->message->from->username,
			'phone' => '',
			'userType' => $this->userInfo->message->chat->type
		];
	}

	public function isValidUser() {
		return (isset($this->userInfo->message->chat->id) and $this->userInfo->message->chat->type != 'group') ? TRUE : FALSE;
	}

	public function isValidGroup() {
		return (isset($this->userInfo->message->chat->id) and $this->userInfo->message->chat->type == 'group') ? TRUE : FALSE;
	}

	public function sendMessage($message) {
		$url = "/sendmessage?chat_id=".$this->userInfo->message->chat->id."&text=".urlencode($message);
		return $this->_call($url);
	}

	public function setWebHook() {
		$url = '/setWebHook?url='.$this->siteURL.'botapi.php';
		return $this->_call($url);
	}

	public function _call($url) {
		$sendto = $this->apiURL.$url;
		$output = $sendto;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $sendto);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$output .= curl_exec($ch);
		curl_close($ch);

		file_put_contents("./log.txt", $output);

		return $output;
	}

}
<?php
class Groupsmessages extends Controller {
	public function __construct(){
		$this->usersController = $this->controller('Users');
		$this->groupsController = $this->controller('Groups');
		$this->gmModel = $this->model('Groupsmessage');
	}
	public function read_group_messages($group_id){
		$messages = $this->gmModel->read_group_messages($group_id);
		return $messages;
	}
	public function send_message($sender_id, $group_id){
		if(!empty($_POST['group_message'])){
			$send_message = $this->gmModel->send_message($sender_id, $group_id);
			header('Location: ' . $_SERVER['HTTP_REFERER']);
			return $send_message;
		}
	}
	public function delete_for_me($message_id){
		$delete_for_me = $this->gmModel->delete_for_me($message_id);
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		return $delete_for_me;
	}
	public function delete_o_for_me($message_id){
		$delete_o_for_me = $this->gmModel->delete_o_for_me($message_id);
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		return $delete_o_for_me;
	}
	public function delete_for_everyone($message_id){
		$delete_for_everyone = $this->gmModel->delete_for_everyone($message_id);
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		return $delete_for_everyone;
	}
}
?>
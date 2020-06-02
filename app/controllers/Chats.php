<?php
class Chats extends Controller {
	public function __construct(){
		$this->userController = $this->controller('Users');
		$this->chatModel = $this->model('Chat');
	}
	public function read($sender_id,$receiver_id){
		$user = new Users();
		if($sender_id === $_SESSION['user_id']){
			$data = [
				'logged_in_user' => $user->getUserInfo(),
				'receiver' => $user->findUserById($receiver_id),
				'messages' => $this->chatModel->read($sender_id,$receiver_id),
				'count_messages' => $this->chatModel->count($sender_id,$receiver_id),
			];
			$this->view('chats/show', $data);
		}elseif($sender_id == $_SESSION['user_id'] && $receiver_id == "start"){
			$data = [
				'logged_in_user' => $user->getUserInfo(),
			];
			$this->view('chats/show_start', $data);
		}else{
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
	}
	public function read_last($sender_id,$receiver_id){
		$user = new Users();
		$is_friend = $user->is_friend($receiver_id);
		if($sender_id === $_SESSION['user_id'] && $is_friend){
			$data = [
				'messages' => $this->chatModel->read_last($sender_id,$receiver_id),
			];
			$this->view('chats/show', $data);
		}elseif($sender_id == $_SESSION['user_id'] && $receiver_id == "start"){
			$data = [
				'logged_in_user' => $user->getUserInfo(),
			];
			$this->view('chats/show_start', $data);
		}else{
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
	}
	public function send_message($sender_id, $receiver_id){
		$user = new Users();
		$is_friend = $user->is_friend($receiver_id);
		if($sender_id === $_SESSION['user_id'] && $is_friend){
			$send_message = $this->chatModel->send_message($sender_id, $receiver_id);
			header('Location: ' . $_SERVER['HTTP_REFERER']);
			die();
			return $send_message;
		}
	}
	public function delete_for_me($message_id){
		$delete_for_me = $this->chatModel->delete_for_me($message_id);
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		return $delete_for_me;
	}
	public function delete_o_for_me($message_id){
		$delete_o_for_me = $this->chatModel->delete_o_for_me($message_id);
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		return $delete_o_for_me;
	}
	public function delete_for_everyone($message_id){
		$delete_for_everyone = $this->chatModel->delete_for_everyone($message_id);
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		return $delete_for_everyone;
	}
}
?>
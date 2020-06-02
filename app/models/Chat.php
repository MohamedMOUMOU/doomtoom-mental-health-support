<?php
class Chat{
	public function __construct(){
		$this->db = new Database;
	}
	public function send_message($sender_id, $receiver_id){
		$this->db->query("INSERT INTO chat_messages(sender_id,receiver_id,message) VALUES(:sender_id,:receiver_id,:message)");
		$this->db->bind(':sender_id', $sender_id);
		$this->db->bind(':receiver_id', $receiver_id);
		$this->db->bind(':message', $_POST['message']);
		return $this->db->execute();
	}
	public function read($sender_id,$receiver_id){
		$this->db->query("SELECT sender_id,message,creation_time,id FROM chat_messages WHERE ((sender_id = :sender_id AND receiver_id = :receiver_id) OR (sender_id = :receiver_id AND receiver_id = :sender_id)) AND delete_for_me != :delete_for_me AND delete_o_for_me != :delete_o_for_me AND !delete_for_everyone ORDER BY id ASC");
		$this->db->bind(':sender_id', $sender_id);
		$this->db->bind(':receiver_id', $receiver_id);
		$this->db->bind(':delete_for_me', 1 . "-" . $_SESSION['user_id']);
		$this->db->bind(':delete_o_for_me', 1 . "-" . $_SESSION['user_id']);
		$messages = $this->db->resultSet();
		return $messages;
	}
	public function read_last($sender_id,$receiver_id){
		$this->db->query("SELECT sender_id,message,creation_time FROM chat_messages WHERE ((sender_id = :sender_id AND receiver_id = :receiver_id) OR (sender_id = :receiver_id AND receiver_id = :sender_id)) AND delete_for_me != :delete_for_me AND delete_o_for_me != :delete_o_for_me AND !delete_for_everyone ORDER BY id DESC LIMIT 1");
		$this->db->bind(':sender_id', $sender_id);
		$this->db->bind(':receiver_id', $receiver_id);
		$this->db->bind(':delete_for_me', 1 . "-" . $_SESSION['user_id']);
		$this->db->bind(':delete_o_for_me', 1 . "-" . $_SESSION['user_id']);
		$messages = $this->db->resultSet();
		return $messages;
	}
	public function count($sender_id,$receiver_id){
		$this->db->query("SELECT sender_id,message FROM chat_messages WHERE (sender_id = :sender_id AND receiver_id = :receiver_id) OR (sender_id = :receiver_id AND receiver_id = :sender_id) ORDER BY id ASC");
		$this->db->bind(':sender_id', $sender_id);
		$this->db->bind(':receiver_id', $receiver_id);
		$this->db->execute();
		$messages = $this->db->rowCount();
		return $messages;
	}
	public function delete_for_me($message_id){
		$this->db->query("UPDATE chat_messages SET delete_for_me = :delete_for_me WHERE id = :message_id");
		$this->db->bind(':delete_for_me', 1 . "-" . $_SESSION['user_id']);
		$this->db->bind('message_id', $message_id);
		$this->db->execute();
	}
	public function delete_o_for_me($message_id){
		$this->db->query("UPDATE chat_messages SET delete_o_for_me = :delete_o_for_me WHERE id = :message_id");
		$this->db->bind(':delete_o_for_me', 1 . "-" . $_SESSION['user_id']);
		$this->db->bind('message_id', $message_id);
		$this->db->execute();
	}
	public function delete_for_everyone($message_id){
		$this->db->query("UPDATE chat_messages SET delete_for_everyone = :delete_for_everyone WHERE id = :message_id");
		$this->db->bind(':delete_for_everyone', true);
		$this->db->bind('message_id', $message_id);
		$this->db->execute();
	}
}
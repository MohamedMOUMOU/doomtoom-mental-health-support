<?php
class Groupsmessage{
	public function __construct(){
		$this->db = new Database;
	}
	public function send_message($sender_id, $group_id){
		$user = new Users();
		$group = new Groups();
		$creator_id = $group->find_group_by_id($group_id)->creator_id;
		$creator_name = $user->findUserById($creator_id)->user_name;
		$group_name = $group->find_group_by_id($group_id)->group_name;
		$this->db->query("INSERT INTO group_chats(sender_id,group_id,message) VALUES(:sender_id,:group_id,:message)");
		$this->db->bind(':sender_id', $sender_id);
		$this->db->bind(':group_id', $group_id);
		$this->db->bind(':message', $_POST['group_message']);
		return $this->db->execute();
	}
	public function read_group_messages($group_id){
		$this->db->query("SELECT sender_id,message,creation_time,id FROM group_chats WHERE group_id = :group_id AND delete_for_me != :delete_for_me AND delete_o_for_me != :delete_o_for_me AND !delete_for_everyone ORDER BY id ASC");
		$this->db->bind(':group_id', $group_id);
		$this->db->bind(':delete_for_me', 1 . "-" . $_SESSION['user_id']);
		$this->db->bind(':delete_o_for_me', 1 . "-" . $_SESSION['user_id']);
		$messages = $this->db->resultSet();
		return $messages;
	}
	public function count($group_id){
		$this->db->query("SELECT sender_id,message FROM group_chats WHERE group_id = :group_id");
		$this->db->bind(':group_id', $group_id);
		$this->db->execute();
		$messages = $this->db->rowCount();
		return $messages;
	}
	public function delete_for_me($message_id){
		$this->db->query("UPDATE group_chats SET delete_for_me = :delete_for_me WHERE id = :message_id");
		$this->db->bind(':delete_for_me', 1 . "-" . $_SESSION['user_id']);
		$this->db->bind('message_id', $message_id);
		$this->db->execute();
	}
	public function delete_o_for_me($message_id){
		$this->db->query("UPDATE group_chats SET delete_o_for_me = :delete_o_for_me WHERE id = :message_id");
		$this->db->bind(':delete_o_for_me', 1 . "-" . $_SESSION['user_id']);
		$this->db->bind('message_id', $message_id);
		$this->db->execute();
	}
	public function delete_for_everyone($message_id){
		$this->db->query("UPDATE group_chats SET delete_for_everyone = :delete_for_everyone WHERE id = :message_id");
		$this->db->bind(':delete_for_everyone', true);
		$this->db->bind('message_id', $message_id);
		$this->db->execute();
	}
}
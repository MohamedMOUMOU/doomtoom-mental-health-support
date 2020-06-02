<?php
class Photosgallery{
	public function __construct(){
		$this->db = new Database;
	}
	public function read($photos_gallery_id){
		$this->db->query("SELECT * FROM photos_galleries WHERE gallery_id = :photos_gallery_id");
		$this->db->bind(':photos_gallery_id', $photos_gallery_id);
		$read = $this->db->single();
		return $read;
	}
}
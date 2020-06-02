<?php
// Base Controller
// Loads the models and views
class Controller{
	// Load model
	public function model($model){
		// Require model file
		require_once '../app/models/' . ucwords($model) .'.php';
		// Instantiate model
		return new $model();
	}
	// Load view
	public function view($view, $data = [],$message = ''){
		// Check for view file
		if(file_exists('../app/views/'. $view . '.php')){
			require_once'../app/views/'. $view . '.php';
		}else{
			die("View does not exist");
		}
	}
	public function controller($controller){
		// Require model file
		if(file_exists('../app/controllers/'. ucwords($controller) . '.php')){
			require_once '../app/controllers/' . ucwords($controller) .'.php';
			// Instantiate model
		}else{
			die("Controller does not exist");
		}
	}
}
?>
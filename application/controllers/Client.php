<?php
  /**
   * Client
   * @package    CI
   * @author     Gino Tome <ginotome@gmail.com>
   */  
defined('BASEPATH') OR exit('No direct script access allowed');
include_once('Curl.php');
class Client extends Curl {

    /**
     * Print form request to calculate formula according values a, b, c
	 * Formula ax2; + bx + c = 0"
     *
     * @return void
    */	
	public function index()
	{
		session_start();
		$error_message = false;
		$errors = isset($_SESSION['form_errors']) ? $_SESSION['form_errors'] : null;
		unset($_SESSION['form_errors']);
		unset($_SESSION['request_result']);

		//Check for errors...
		if($errors){
			$error_message = implode('<br/>',$errors);
		}

		//Add security check to avoid hacking
		$security_check = (rand(1,10) * time());
		$_SESSION['security_check'] = $security_check;

		//Set data to view...
		$view_data = [
			'security_check' => $security_check,
			'error_message' => $error_message
		];
		$this->load->view('client',$view_data);
	}

    /**
     * Send request to Soqesolver API
     *
     * @return jquery
    */		
	public function send_request(){
		session_start();
		//echo '<pre>';var_dump($_SESSION,$_POST,$_SERVER);die(); 

		//Check if this request is legit, avoid hacking
		$request_id = !empty($_POST['request_id']) ? $_POST['request_id'] : null;
		if($request_id != $_SESSION['security_check']){
			header('HTTP/1.0 403 Forbidden');
			die();
		}

		$a = !empty($_POST['a']) ?  $_POST['a'] : null; 
		$b = isset($_POST['b']) ?  $_POST['b'] : null; 
		$c = isset($_POST['c']) ?  $_POST['c'] : null; 

		$errors = [];
		if($a === null){
			$errors[] = 'Invalid "a" value, expected integer different than 0.';
		}
		if($b === null){
			$errors[] = 'Invalid "b" value, expected integer';
		}		
		if($c === null){
			$errors[] = 'Invalid "c" value, expected integer';
		}		

		//If errors detected server side, redirect and alert
		if(!empty($errors)){
			$redirect = $_SERVER['HTTP_REFERER'];
			$_SESSION['form_errors'] = $errors;
			header("Location: $redirect");
		}

		$ip = !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unknown';
		//Prepare data to send request
		$data = [
			'a' => $a,
			'b' => $b,
			'c' => $c,
			'ip' => $ip,
			'token' => sha1("$a.$b.$c")
		];
		$data = json_encode($data);
		$result = $this->post_request($data);
		$result = json_decode($result,true);
		$_SESSION['request_result'] = $result;
		$redirectUrl = 'http://' . $_SERVER['SERVER_NAME'] . '/client/landing_result';
		header("Location: $redirectUrl");
	}
	
    /**
     * Parse result from Soqesolver API
     * Depending on return type show view
     * @return jquery
    */	
	public function landing_result(){
		session_start();
		$result = !empty($_SESSION['request_result']) ? $_SESSION['request_result'] : null;
		//echo '<pre>';var_dump($result,$_SERVER);die();
		if($result){
			$view_data = [
				'message' => $result['Message'],
				'val_1' => $result['X1'],
				'val_2' => $result['X2'],
				'back_url' => 'http://' . $_SERVER['SERVER_NAME'] . '/client'
			];			
			//First, check if we got an error
			if($result['Status'] == '-1'){
				//Set data to view...
				$this->load->view('error',$view_data);
			}else{
				//If no error, check solutions
				if($result['X1'] === 'No solution' && $result['X2'] === 'No solution'){
					//No solution
					$this->load->view('no_solution',$view_data);		
				}elseif($result['X1'] !== 'No solution' && $result['X2'] !== 'No solution'){
					//Two solutions
					$this->load->view('two_solution',$view_data);				
				}else{
					//Single solution
					$this->load->view('single_solution',$view_data);
				}
			}
		}
	}
}

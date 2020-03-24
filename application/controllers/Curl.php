<?php
  /**
   * Curl
   * @package    CI
   * @author     Gino Tome <ginotome@gmail.com>
   */  
defined('BASEPATH') OR exit('No direct script access allowed');

class Curl extends CI_Controller {
    /**
     * Send curl request to qesolver API
     * @return json
    */	    
    protected function post_request($data){
		$curl_config = $this->config->item('curl_config');
        $ch = curl_init($curl_config['url']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
    curl_close($ch);
    return $result;
    }
}

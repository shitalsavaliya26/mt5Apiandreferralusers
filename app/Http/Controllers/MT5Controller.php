<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MT5Controller extends Controller
{
	private $m_curl = null; 
  	private $m_server = ""; 

  	public function createAccount($request)
  	{
  		$server = explode(':', $request->servername);

  		if ($this->Init($request->servername) && $this->Auth($request->auth_login,$request->auth_password,2361,"WebAPI")) {  
  		
			$MT5Obj = new \MTWebAPI();
	  		$MT5Obj->Connect(
				$server[0],                   // IP address
				$server[1],         		  // Port
				50000,      			 	  // Timeout
				$request->auth_login,         // Login
				$request->auth_password,      // Password
				'WebAPI'     		          // Agent
			);

			$newUser = $MT5Obj->UserCreate(); 
			$user = $newUser;

			$user->Login = $request->Login; 
    		$user->Name = $request->Name;
    		$user->Email = $request->Email;
    		$user->Group = $request->Group;
    		$user->Leverage = $request->Leverage;
    		$user->Phone = $request->Phone;
    		$user->Address = $request->Address;
    		$user->City = $request->City;
    		$user->State = $request->State;
    		$user->Country = $request->Country;
    	 	$user->ZipCode = $request->ZipCode;
    		$user->MainPassword = "Avnya2020M";//$request->MainPassword;
    		$user->InvestPassword = $request->InvestPassword;
    		$user->PhonePassword = $request->PhonePassword;

			return $responseCode = $MT5Obj->UserAdd($user,$newUser);	
		}
  	}

  	public function depositeAmount($request)
  	{
  		$request = (object)$request;
	  	$server = explode(':', $request->servername);
	  	// dd($request,$server);
  		if ($this->Init($request->servername) && $this->Auth($request->auth_login,$request->auth_password,2361,"WebAPI")) {    

			$MT5Obj = new \MTWebAPI();
	  		$MT5Obj->Connect(
				$server[0],     			// IP address
				$server[1],         		// Port
				50000,      			 	// Timeout
				$request->auth_login,       // Login
				$request->auth_password,    // Password
				'WebAPI'     		     	// Agent
			);
	  		$responseCode = $MT5Obj->TradeBalance(
			   $request->login,            // Login
			   $request->type,             // Type of operation
			   $request->amount,           // Amount
			   isset($request->comment)?$request->comment:'Deposit'        		   // Comment
			);

	  		if ($responseCode == 0) {
				return response()->json(['success' => true, 'result' => 'Account Deposited Successfully',"reponse"=>$responseCode],200);
			} else {
				return response()->json(['success' => false, 'result' => 'Something went wrong',"reponse"=>$responseCode],200);
			}
		}    		
  	}
  	public function Deposite(Request $request)
  	{
	  	$server = explode(':', $request->servername);

  		if ($this->Init($request->servername) && $this->Auth($request->auth_login,$request->auth_password,2361,"WebAPI")) {    

			$MT5Obj = new \MTWebAPI();
	  		$MT5Obj->Connect(
				$server[0],     			// IP address
				$server[1],         		// Port
				50000,      			 	// Timeout
				$request->auth_login,       // Login
				$request->auth_password,    // Password
				'WebAPI'     		     	// Agent
			);

	  		$responseCode = $MT5Obj->TradeBalance(
			   $request->login,            // Login
			   $request->type,             // Type of operation
			   $request->amount,           // Amount
			   'Withdraw'         		   // Comment
			);

	  		if ($responseCode == 0) {
				return response()->json(['success' => true, 'result' => 'Account Deposited Successfully'],200);
			} else {
				return response()->json(['success' => false, 'result' => 'Something went wrong'],200);
			}
		}    		
  	}

  	public function Withdrawal(Request $request)
  	{
  		$server = explode(':', $request->servername);

  		if ($this->Init($request->servername) && $this->Auth($request->auth_login,$request->auth_password,2361,"WebAPI")) {    

			$MT5Obj = new \MTWebAPI();
	  		$MT5Obj->Connect(
				$server[0],     			// IP address
				$server[1],         		// Port
				50000,      			 	// Timeout
				$request->auth_login,       // Login
				$request->auth_password,    // Password
				'WebAPI'     		     	// Agent
			);

	  		$responseCode = $MT5Obj->TradeBalance(
			   $request->login,            // Login
			   $request->type,             // Type of operation
			   $request->amount,           // Amount
			   'Withdraw'         		   // Comment
			);

	  		if ($responseCode == 0) {
				return response()->json(['success' => true, 'result' => 'Account Withdrawal Successfully'],200);
			} else {
				return response()->json(['success' => false, 'result' => 'Something went wrong'],200);
			}
		}   		
  	}

  	public function HistoryGetTotal($request)
  	{
  		$server = explode(':', $request->servername);

  		if ($this->Init($request->servername) && $this->Auth($request->auth_login,$request->auth_password,2361,"WebAPI")) {    

		/*$MT5Obj = new \MTWebAPI();
	  		$MT5Obj->Connect(
				$server[0],     			// IP address
				$server[1],         		// Port
				50000,      			 	// Timeout
				$request->auth_login,       // Login
				$request->auth_password,    // Password
				'WebAPI'     		     	// Agent
			);

	  		$responseCode = $MT5Obj->HistoryGetTotal(
			   134609039,            // Login
			   $request->from,             // from
			   $request->to
			   // to
			   // 'Withdraw'         // total
			);

	  		if ($responseCode == 0) {
				return response()->json(['success' => true, 'result' => 'Account Withdrawal Successfully'],200);
			} else {
				return response()->json(['success' => false, 'result' => 'Something went wrong'],200);
			}*/	
		}   		
  	}

  	public function Init($server) 	
  	{ 
		$this->Shutdown(); 
	    
	    if($server == null) 
	   		return(false); 
	    
	    $this->m_curl = curl_init(); 
	    
	    if ($this->m_curl == null) 
	    	return(false); 
	    
	    curl_setopt($this->m_curl,CURLOPT_SSL_VERIFYPEER,0); 
	    curl_setopt($this->m_curl,CURLOPT_MAXCONNECTS,1);    
	    curl_setopt($this->m_curl, CURLOPT_HTTPHEADER, array(
	      	// 'Host: mt5api.icdx.co.id:443',
	    	'Accept: */* ',
	      	'User-Agent: MetaTrader 5 Web API/5.2005 (Windows NT 6.2; x64)',
	      	'Connection: Keep-Alive',
	      	'Content-Type: application/x-www-form-urlencoded'
	    ));

		$this->m_server = $server; 
	    
		return(true); 
	} 
	  
	public function Shutdown() 
	{ 
		if ($this->m_curl != null) 
	    	curl_close($this->m_curl); 
		$this->m_curl = null; 
	} 
	  
	public function Get($path) 
	{ 
		if ($this->m_curl == null) 
	    	return(false); 

		curl_setopt($this->m_curl,CURLOPT_POST,false); 
	    curl_setopt($this->m_curl,CURLOPT_URL,'https://'.$this->m_server.$path); 
	    curl_setopt($this->m_curl,CURLOPT_RETURNTRANSFER,true); 
	    
	    $result = curl_exec($this->m_curl); 
	    
	    if ($result == false) { 
	    	echo 'Curl GET error: '.curl_error($this->m_curl); 
	    	return(false); 
	    } 

	    $code = curl_getinfo($this->m_curl,CURLINFO_HTTP_CODE); 
	    
	    if ($code != 200) { 
	    	echo 'Curl GET code: '.$code; 
	    	return(false); 
	    }

	    return($result); 
	} 

	public function Auth($login, $password, $build, $agent) 
	{ 
		if ($this->m_curl == null) 
	    	return(false);     
	    
	    $path = '/auth_start?version='.$build.'&agent='.$agent.'&login='.$login.'&type=manager'; 
	    $result = $this->Get($path); 
	    
	    if ($result == false) 
	    	return(false); 
	    
	    $auth_start_answer = json_decode($result); 
	    
	    if ((int)$auth_start_answer->retcode != 0) { 
	    	echo 'Auth start error : '.$auth_start_answer.retcode; 
	    	return(false); 
	    } 

	    $srv_rand = hex2bin($auth_start_answer->srv_rand); 
	    $password_hash = md5(mb_convert_encoding($password,'utf-16le','utf-8'),true).'WebAPI'; 
	    $srv_rand_answer = md5(md5($password_hash,true).$srv_rand); 
	    $cli_rand_buf = random_bytes(16); 
	    $cli_rand = bin2hex($cli_rand_buf); 
	    $path = '/auth_answer?srv_rand_answer='.$srv_rand_answer.'&cli_rand='.$cli_rand; 
	    $result = $this->Get($path); 
	    
	    if ($result == false) 
	    	return(false); 
	    
	    $auth_answer_answer = json_decode($result); 
	    
	    if ((int)$auth_answer_answer->retcode != 0) { 
	    	echo 'Auth answer error : '.$auth_answer_answer.retcode; 
	    	return(false); 
	    } 
	    
	    $cli_rand_answer = md5(md5($password_hash,true).$cli_rand_buf); 
	    
	    if ($cli_rand_answer != $auth_answer_answer->cli_rand_answer) { 
	    	echo 'Auth answer error : invalid client answer'; 
	    	return(false); 
	    } 
	    
	    return(true); 
	}
}
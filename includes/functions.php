<?php 


if (!function_exists('e')) {
	function e($string){
		if ($string) {
			return strip_tags($string);
		}
		
	}
}

//like micropost
if (!function_exists('like_topic')) {
	function like_topic($topic_id){
		//like
		global $db;
 $q = $db->prepare('INSERT INTO topic_like(user_id, topic_id) VALUES(:user_id, :topic_id)');
 $q->execute([
 'user_id' => get_session('user_id'),
 'topic_id' => $topic_id
 ]);
 //update
 $q = $db->prepare('UPDATE  topics SET like_count = like_count + 1 WHERE id = :topic_id');
 $q->execute([
 'topic_id' => $topic_id
 ]);
	}
}

//unlike 
if (!function_exists('unlike_topic')) {
	function unlike_topic($topic_id){
		//unlike
		global $db;
 $q = $db->prepare('DELETE FROM topic_like 
 	                WHERE user_id = :user_id 
 	                AND topic_id = :topic_id');
 $q->execute([
 'user_id' => get_session('user_id'),
 'topic_id' => $topic_id
 ]);
 //update
 $q = $db->prepare('UPDATE  topics SET like_count = like_count - 1 WHERE id = :topic_id');
 $q->execute([
 'topic_id' => $topic_id
 ]);
	}
}


//friend_request_hase_been_sent
if (!function_exists('friend_request_hase_been_sent')) {
	function friend_request_hase_been_sent($id1,$id2){


		global $db;

		$q = $db->prepare("SELECT status FROM friends_r_s WHERE  (user_id1 = :user_id1 AND user_id2 = :user_id2 )

			OR(user_id1 = :user_id2 AND user_id2 = :user_id1 )");
		$q->execute([
               'user_id1' => $id1,
               'user_id2' => $id2
		]);

		$count =  $q->rowCount();

		$q->closeCursor();

		return(bool) $count;
	}
}
//nombres d'amis
if (!function_exists('f_count')) {
	function f_count(){

		global $db;

		$q = $db->prepare("SELECT status  FROM friends_r_s 
			               WHERE (user_id1 = :user_connected OR user_id2 = :user_connected AND status = '1')");
		$q->execute([
               'user_connected' => $_GET['id']
		]);

		$count =  $q->rowCount();

		$q->closeCursor();

		return $count;
		
	}
}

if (!function_exists('relation_link')) {
	function relation_link($id){
		global $db;

		$q = $db->prepare("SELECT user_id1, user_id2, status FROM friends_r_s WHERE  (user_id1 = :user_id1 AND user_id2 = :user_id2 )

			OR(user_id1 = :user_id2 AND user_id2 = :user_id1 )");
	    $q->execute([
	     'user_id1' => get_session('user_id'),
	     'user_id2' => $id 
	 ]);
	    $data = $q->fetch();
	    if ($data['user_id2'] == get_session('user_id') && $data['status'] == '0') {
	    	
	    	//lien pour accepter la demande
	    	return "accept_link";
	    }elseif($data['user_id1'] == get_session('user_id') && $data['status'] == '0'){
            //Msg pour dire que la demande a deja ete envoyer
            return "cancel_link";
	    }elseif (($data['user_id1'] == get_session('user_id') or $data['user_id1'] == $id) AND $data['status'] == '1' ) {
	    	return "delete_link";
	    }else{
          return "add_link";
	    }
	    $q->closeCursor();
	    die($data->status);
	}
}


if (!function_exists('replace_links')) {
	function replace_links($texte){
		$regex_url = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\:[0-9]+)?(\/\S*)?/";
	   return	preg_replace($regex_url, 

	   	"<a href=\"$0\" target=\"_blank\">$0</a>",
	   	
	   	 $texte);
	}
}

//cell count
if (!function_exists('cell_count')) {
	function cell_count($table, $field_name, $field_value){
		global $db;
		$q = $db->prepare("SELECT * FROM $table WHERE $field_name = ?");
		$q->execute([$field_value]);

		return $q->rowCount();
	}
}
//remember 
if (!function_exists('remember')) {
	function remember($user_id){
		global $db;
	// Generer le token de maniere aleatoir
		$token = openssl_random_pseudo_bytes(24);
		// Generer le selector de maniere aleatoir
		do{
			$selector = openssl_random_pseudo_bytes(9);
		}while(cell_count('auth_tokens','selector', $selector) > 0);

		//sauver ces infos
		$q = $db->prepare('INSERT INTO auth_tokens(expires, selector, user_id, token) VALUES(DATE_ADD(NOW(), INTERVAL 14 DAY), :selector, :user_id, :token)');
		$q->execute([
         'selector' => $selector,
         'user_id' => $user_id,
         'token' => hash('sha256', $token)
		]);
		//cree un cookie auth

		setcookie('auth',
		 base64_encode($selector).':'.base64_encode($token), 
		 time()+1209600, 
		 null, 
		 null, 
		 false, 
		 true);
	}
}
  //remember autogin
if (!function_exists('auto_login')) {
	function auto_login(){
		global $db;
    // verifier que cookie existe 
		if (!empty($_COOKIE['auth'])) {
			$split = explode(':', $_COOKIE['auth']);
			if (count($split) !== 2) {
				return false;

			}
			//recupperer via le cookie
			list($selector, $token) = $split;

			$q = $db->prepare('SELECT auth_tokens.id, auth_tokens.token, auth_tokens.user_id, users.id, users.pseudo, users.avatar, users.email 
			 FROM auth_tokens
			 LEFT JOIN users
			 ON auth_tokens.user_id = users.id 
			 WHERE selector = ? AND expires >= CURDATE()');
			$q->execute([base64_decode($selector)]);

			$data = $q->fetch(PDO::FETCH_OBJ);
            
            if ($data) {
            	if (hash_equals($data->token, hash('sha256', base64_decode($token)))) {
            		session_regenerate_id(true);
            		$_SESSION['user_id'] = $data->user_id;
                    $_SESSION['pseudo'] = $data->pseudo;
                    $_SESSION['avatar'] = $data->avatar;
                    $_SESSION['email'] = $data->email;
                    return true;
            	}
            		
            }
		}
	return false;

	}
}
//redirect_intent
if (!function_exists('redirect_intent')) {
	function redirect_intent($default_url){
		if ($_SESSION['forwarding_url']) {
			$url = $_SESSION['forwarding_url'];
		}else{
            $url = $default_url;
		}
		$_SESSION['forwarding_url'] = null;
	    redirect($url);
	}
}

if (!function_exists('is_logged_in')) {
	function is_logged_in(){
		return isset($_SESSION['user_id']) || isset($_SESSION['pseudo']);
	}
}


if (!function_exists('get_session')) {
	function get_session($key){
		if ($key) {
			return !empty($_SESSION[$key])
		        ? e($_SESSION[$key])
		        : null;

		}
		
	}
}

if (!function_exists('get_current_locale')) {
	function get_current_locale(){
		return $_SESSION['locale'];
	}
}
//user infos
if (!function_exists('find_user_by_id')) {
	function find_user_by_id($id){
		global $db;

		$q = $db->prepare("SELECT name, pseudo, email, city, country, sex, twitter, github, available_for_hiring, bio, avatar FROM users  WHERE id = ?");

		$q->execute([$id]);

		$data = $q->fetch(PDO::FETCH_OBJ);

		$q->closeCursor();

		return $data;
		
	}
}

if (!function_exists('find_code_by_id')) {
	function find_code_by_id($id){
		global $db;

		$q = $db->prepare('SELECT code FROM codes WHERE id = ?');

		$q->execute([$id]);

		$data = $q->fetch(PDO::FETCH_OBJ);

		$q->closeCursor();

		return $data;
		
	}
}


if (!function_exists('not_empty')) {
	function not_empty($fields = []){
		if (count($fields) != 0) {
			foreach ($fields as $field) {
				if (empty($_POST[$field]) || trim($_POST[$field]) == "") {
					return false;
				}
			}
			return true;
		}
	}
}

if (!function_exists('is_already_in_use')) {
	function is_already_in_use($field, $value, $table){
		global $db;

		$q = $db->prepare("SELECT id  FROM $table WHERE  $field = ?");
		$q->execute([$value]);

		$count =  $q->rowCount();

		$q->closeCursor();

		return $count;
	}
}

if (!function_exists('set_flash')) {
	function set_flash($message, $type = 'info'){
		$_SESSION['notification']['message'] = $message;
		$_SESSION['notification']['type'] = $type;
			}
}

if (!function_exists('redirect')) {
	function redirect($page){
		header('Location: '. $page);

		exit();
	}
}

if (!function_exists('save_input_data')) {
	function save_input_data(){
		foreach ($_POST as $key => $value) {
			if (strpos($key, 'password') === false) {
				$_SESSION['input'][$key] = $value;
			}
		}
	}
}

if (!function_exists('get_input')) {
	function get_input($key){
		return !empty($_SESSION['input'][$key])
		        ? e($_SESSION['input'][$key])
		        : null;

	}
}

if (!function_exists('clear_input_data')) {
	function clear_input_data(){
		if(isset($_SESSION['input'])){

		         $_SESSION['input'] = [];
		        

		}

	}
}



if (!function_exists('set_active')) {
	function set_active($file){
		$page = array_pop(explode('/', $_SERVER['SCRIPT_NAME']));

		if ($page == $file.'.php') {
			return "active";
		}else{
			return "";
		}
	}
}

//get avatar

if (!function_exists('get_avatar_url')) {
	function get_avatar_url($email,$size = 15){
		return "http://gravatar.com/avatar/".md5(strtolower(trim(e($email))))."?s=".$size.'&d=mm';
	}
}

//get avatar
/*
if (!function_exists('get_avatar_url')) {
	function get_avatar_url($email,$size = 25){
		return "http://gravatar.com/avatar/".md5(strtolower(trim(e($email))))."?s=".$size;
	}
   }*/
//algorithm hashage
if (!function_exists('bcrypt_hash_password')) {
	function bcrypt_hash_password($value, $options = array()){
		$cost = isset($options['rounds']) ? $options['rounds'] : 10;
		$hash = password_hash($value, PASSWORD_BCRYPT, array('cost' => $cost));
		if ($hash === false) 
		{
			throw new Exception("Bcrypt hashing n'est ps supporter.");
			
		}
		return $hash;
	}
}

//verifie password

if (!function_exists('bcrypt_verify_password')) {
	function bcrypt_verify_password($value, $hashedValue){
		return password_verify($value, $hashedValue);
	}
}
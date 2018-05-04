<?php
class mail{
	public function list_mail($what,$box){
		$user = $_SESSION['mail'];
		$pswd = $_SESSION['pswd'];
		if($box === 'drafts'){
			if($connect = imap_open("{imap.gmail.com:993/imap/ssl/novalidate-cert/norsh}[Gmail]/Brouillons", $user, $pswd) ){}else{echo "Connection to server failed";
				echo "<a href='../view/index.php'> Go back to login</a>";
				return;}
		}else{
			if($connect = imap_open("{imap.gmail.com:993/imap/ssl/novalidate-cert/norsh}Inbox", $user, $pswd)){}else{echo "Connection to server failed !";
				echo "<a href='../view/index.php'> Go back to login</a>";
				return;}
		}
		$headers = imap_headers($connect) or die("Couldn't get emails");
		$numEmails = sizeof($headers);
		if(isset($_POST['search-input']) && $_POST['search-input']!=''){
			$search = $_POST['search-input'];
			$emails = imap_search($connect, 'TEXT "'.$search.'"');
		}elseif(isset($_GET['labels']) && $_GET['labels']!=''){
			$search = $_GET['labels'];
			$emails = imap_search($connect, 'TEXT "'.$search.'"');
		}else{
			$emails = imap_search($connect,'ALL');
		}
		if($emails){
			$output='';
			rsort($emails);
			foreach ($emails as $numEmails) {
				$overview = imap_fetch_overview($connect,$numEmails,0);
				$structure = imap_fetchstructure($connect, $numEmails);
				switch ($structure->encoding) {
					case '0':
						$message = imap_fetchbody($connect, imap_msgno($connect, $overview[0]->uid), 1);
						break;
					case '1':
						$message =  quoted_printable_decode(imap_8bit(imap_fetchbody($connect, imap_msgno($connect, $overview[0]->uid), 1)));
						break;
					case '2':
						$message = imap_binary(imap_fetchbody($connect, imap_msgno($connect, $overview[0]->uid), 1));
						break;
					case '3':
						$message = base64_decode(imap_fetchbody($connect, imap_msgno($connect, $overview[0]->uid), 1));
						break;
					case '4':
						$message = imap_qprint(imap_fetchbody($connect, imap_msgno($connect, $overview[0]->uid), 1));
						break;
					case '5':
						$message = imap_fetchbody($connect, imap_msgno($connect, $overview[0]->uid), 1);
						break;
					default:
						$message = imap_fetchbody($connect, imap_msgno($connect, $overview[0]->uid), 1);
						break;
				}
				if(isset($structure->parts) && is_array($structure->parts) && isset($structure->parts[1])) {
		            $part1 = $structure->parts[1];
		            $part = $structure->parts[1];
		            $message = imap_fetchbody($connect,$numEmails,2);
		            if($part->encoding == 0){
		            	$message = imap_fetchbody($connect, imap_msgno($connect, $overview[0]->uid), 1);
		            }
		            if($part1->encoding == 3) {
		                $message = imap_base64($message);
		            } else if($part->encoding == 1) {
		                $message = imap_8bit($message);
		            } else {
		                $message = imap_qprint($message);
		            }
		        }
				if($what == 0){
		        	if($overview[0]->seen == 0){
		        		$output.= '<div class="email-item email-item-unread pure-g" id="mail-'.$numEmails.'">';
		        	}else{
		        		$output.= '<div class="email-item pure-g" id="mail-'.$numEmails.'">';
		        	}
					$output.= '<div class="pure-u-3-4">';
					if(isset($overview[0]->from)){
						$output.= '<h5 class="email-name">'.$overview[0]->from.'</h5>';
					}elseif(isset($overview[0]->to)){
						$output.= '<h5 class="email-name">'.$overview[0]->to.'</h5>';
					}
					if(isset($overview[0]->subject)){
						$output.= '<h4 class="email-subject">'.imap_utf8($overview[0]->subject).'</h4>';
					}
					if ($box === 'drafts') {
							$output.= '</div><input class="checkbox-mail" type="checkbox" name="draft-'.$numEmails.'" value="draft-'.$numEmails.'"/></div>';
	        		}else{
						$output.= '</div><input class="checkbox-mail" type="checkbox" name="mail-'.$numEmails.'" value="'.$numEmails.'"/></div>';
	        		}
				}elseif($what == 1){

					#HEADER
					$output.= '<div class="email-content" id="content-mail-'.$numEmails.'">';
					$output.= '<div class="email-content-header pure-g">';
					$output.= '<div class="pure-u-1-2">';
					if(isset($overview[0]->subject)){
						$output.= '<h1 class="email-content-title">'.imap_utf8($overview[0]->subject).'</h1>';
					}
					if(isset($overview[0]->from)){
						$output.= '<p class ="email-content-subtitle">From <a>'.$overview[0]->from.'</a> at <span>'.$overview[0]->date.'</span></p></div>';
					}elseif(isset($overview[0]->to)){
						$output.= '<p class="email-content-subtitle">To <a>'.$overview[0]->to.'</a></p></div>';
					}else{
						$output.= '</div>';
					}
					if($box == 'drafts'){
						$output.='</div>';
					}else{
						$output.= '<div class="email-content-controls pure-u-1-2"><button class="secondary-button pure-button">Reply</button></div></div>';
					}

					#BODY
					$output.= '<div class="email-content-body">';
					$output.= '<div class="body-message">'.$message.'</div>';
					$output.= '</div></div>';
				}	
			}
			echo $output;
		}
		imap_close($connect);
	}
	public function delete_mail(){
		if(isset($_POST)){
			$user = $_SESSION['mail'];
			$pswd = $_SESSION['pswd'];
			foreach ($_POST as $value) {
				$connect = imap_open("{imap.gmail.com:993/imap/ssl/novalidate-cert/norsh}Inbox", $user, $pswd) or die("Connection to server failed");
			}
			foreach ($_POST as $value) {
				if(strlen($value) == 1){
					imap_delete($connect, $value);
				}else{
					$ex = explode('-', $value);
					$value = $ex[1];
					imap_delete($connect, $value);
				}
			}
			imap_close($connect);
		}
	}
	public function mail_draft(){
		if(isset($_POST['mail_to0']) && $_POST['mail_to0']!='' && isset($_POST['mail_subject']) && $_POST['mail_subject']!='' && isset($_POST['mail_content']) && $_POST['mail_content']!=''){

			$rootMailBox = "{imap.gmail.com:993/imap/ssl/novalidate-cert/norsh}";
			$draftsMailBox = $rootMailBox . '[Gmail]/Brouillons';
			$user = $_SESSION['mail'];
			$pswd = $_SESSION['pswd'];
			$conn = imap_open ($rootMailBox, $user, $pswd) or die("can't connect: " . imap_last_error());
			$envelope["to"]  = $_POST['mail_to0'];
			$envelope["subject"]  = $_POST['mail_subject'];
			$envelope["date"]= date("l, j M Y H:i:s");
			$part["type"] = TYPETEXT;
			$part["subtype"] = "plain";
			$part["description"] = "part description";
			$part["contents.data"] = $_POST['mail_content'];

			$body[1] = $part;

			$msg = imap_mail_compose($envelope, $body);

			if (imap_append($conn, $draftsMailBox, $msg) === false) {
			    die("could not append message: ".imap_last_error());
			}
		}
	}
}
?>
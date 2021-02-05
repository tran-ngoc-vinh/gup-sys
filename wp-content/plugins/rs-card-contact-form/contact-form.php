<?php
/*
Plugin Name: Contact Form
Description: Declares a plugin that will create a contact form
Version: 1.4
*/
?>
<?php
require_once plugin_dir_path(__FILE__) . 'options.php';

function rscard_enqueue_script() {
	$options = get_option( 'rscard_hide_meta' );
	if(isset($options['google_recaptcha']) && $options['google_recaptcha'] != ''){
		wp_enqueue_script( 'google-recaptcha','https://www.google.com/recaptcha/api.js?onload=PxRecaptchaCallback&render=explicit',array(),'', true );
	}
	wp_enqueue_script( 'contact-form', plugin_dir_url( __FILE__ ).'js/contact-form.js',array('jquery','main'),'', true );
} 
$options = get_option( 'rscard_hide_meta' );
?>
<?php add_action( 'wp_enqueue_scripts', 'rscard_enqueue_script' );

if(is_admin()){
    add_action('wp_ajax_rs_card_contact_form', 'rs_card_contact_form');
    add_action('wp_ajax_nopriv_rs_card_contact_form', 'rs_card_contact_form');
}

function rs_card_contact_form() {	
	$options = get_option( 'rscard_hide_meta' );
	
	$captcha_status = true;
	if(!empty($options['google_recaptcha']) && !empty($options['google_recaptcha_sec'])):
		$resp = checkRecaptchaToken();
		if(!$resp->success){
			$captcha_status = false;
		}
	endif;

	if($_POST['email_to']){
		$emailTo = $_POST['email_to'];
	}elseif(get_option( 'admin_email' )){
		$emailTo = get_option( 'admin_email' );
	}else{
		$emailTo = false;
	}
	$response = array('status' => true, 'data' => '',);	

	if(!$_POST['name']){$response['status'] = false;$response['data'][] = 'name';}
	if(!$_POST['message']){$response['status'] = false;$response['data'][] = 'message';}
	if(trim($_POST['email']) == '')  {
		$response['data'][] = 'email';
		$response['status'] = false;
	}elseif(!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)){
		$response['data'][] = 'email';
		$response['status'] = false;
	}else {
		$email = trim($_POST['email']);
	}
	
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=utf-8\r\n";
	$headers .= "From: ".$emailTo."\r\n";
	$headers .= "Reply-To: ".$email."\r\n";
	
	if (empty($_POST['subject'])) {
		$subject = "Contact form message"; // Enter your subject here
	} else {
		$subject = $_POST['subject'];
	}
	$body = "";

	if($response['status'] == true && $emailTo && $captcha_status):
		reset($_POST);
		while (list($key, $val) = each($_POST)) {
			$title = ucwords(strtolower($key));
			if($title == 'Action' || $title == 'Email_to' || $title == 'G_recaptcha_response'): continue; endif;
			$body .= "<b>$title:</b> ";
			$body .= $val;
			$body .= "<br>";
		}
		
		isset($options['success_message'])? $success_message = $options['success_message']: $success_message = 'Your email was sent!';
		isset($options['error_message'])? $error_message = $options['error_message']: $error_message = 'Something went wrong, please check plugin options.';
		$result = wp_mail($emailTo, $subject, $body, $headers); //This method sends the mail.
		if($result){
			echo $success_message;
		}else{
			echo $error_message;
		}
	endif;	
	if(!$captcha_status){
		echo "recaptcha is invalid!";
	}
	
    exit;
}
// Contact Form
add_shortcode('rs_card_contact_form', 'send_contact_form');
function send_contact_form($atts) {
	$options = get_option( 'rscard_hide_meta' );
	isset($options['email_address'])? $email_address = $options['email_address']: $email_address = '';
	isset($options['email_placeholder'])? $email_placeholder = $options['email_placeholder']: $email_placeholder = __('Email','rs-card');
	isset($options['name_placeholder'])? $name_placeholder = $options['name_placeholder']: $name_placeholder = __('Name','rs-card');
	isset($options['subject_placeholder'])? $subject_placeholder = $options['subject_placeholder']: $subject_placeholder = __('Subject','rs-card');
	isset($options['message_placeholder'])? $message_placeholder = $options['message_placeholder']: $message_placeholder = __('Message','rs-card');
	isset($options['submit_placeholder'])? $submit_placeholder = $options['submit_placeholder']: $submit_placeholder = __('Send','rs-card');
		isset($options['privacy_placeholder'])? $privacy_placeholder = $options['privacy_placeholder']: $privacy_placeholder = __('I have read the Privacy Policy note.','rs-card');
	isset($options['google_recaptcha_style'])? $google_recaptcha_style = $options['google_recaptcha_style']: $google_recaptcha_style = 'light';
    $str = "<form class='contactForm' action='#' method='post'>
				<div class='input-field'>
					<input class='contact-name' type='text' name='name'/>
					<span class='line'></span>
					<label>".esc_html__($name_placeholder,'rs-card')."</label>
				</div>

				<div class='input-field'>
					<input class='contact-email' type='email' name='email'/>
					<span class='line'></span>
					<label>".esc_html__($email_placeholder,'rs-card')."</label> 
				</div>

				<div class='input-field'>
					<input class='contact-subject' type='text' name='subject'/>
					<span class='line'></span>
					<label>".esc_html__($subject_placeholder,'rs-card')."</label>
				</div>

				<div class='input-field'>
					<textarea class='contact-message' rows='4' name='message'></textarea>
					<span class='line'></span>
					<label>".esc_html__($message_placeholder,'rs-card')."</label>
				</div>";
				if(isset($options['google_recaptcha']) && isset($options['google_recaptcha_sec'])):
					$str .= "<div class='g-recaptcha' data-theme='".esc_attr($google_recaptcha_style)."' data-sitekey='".esc_attr($options['google_recaptcha'])."' id='recaptcha1'></div>";
				endif;
				if($email_address && filter_var(trim($email_address), FILTER_VALIDATE_EMAIL)):
					$str .= "<input type='hidden' class='email_to' name='email_to' value='".esc_attr($email_address)."'/>";
				endif;
				if( !empty( $privacy_placeholder ) ):
					$str .= '<div class="check-field">
								<input type="checkbox" name="rsPivacyPolicy" id="rsPivacyPolicy">
								<label for="rsPivacyPolicy">'. esc_html__($privacy_placeholder,'rs-card') .'</label>
							</div>';
				endif;
		$str .= "<span class='btn-outer btn-primary-outer ripple'>
					<input class='contact-submit btn btn-lg btn-primary' type='submit' value='".esc_html__($submit_placeholder,'rs-card')."'/>
				</span>
				
				<div class='contact-response'></div>
			</form>";
    return $str;
}
require plugin_dir_path( __FILE__ ). 'widget/contact-form-widget.php';

function checkRecaptchaToken(){
	$options = get_option( 'rscard_hide_meta' );
	
	$data = array(
				'secret' => urlencode($options['google_recaptcha_sec']),
				'response' => urlencode($_POST['g_recaptcha_response']),
				'remoteip' => urlencode($_SERVER['REMOTE_ADDR'])
			);

	$verify = curl_init();
	curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
	curl_setopt($verify, CURLOPT_POST, true);
	curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($verify);
	curl_close($verify);
	return json_decode($response);
}
<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'rs_card_contact_form_widget' );

/**
 * Register our widget.
 */
function rs_card_contact_form_widget() {
	register_widget( 'RsCcardContactForm' );
}

/**
 * recent_Posts Widget class.
 */
class RsCcardContactForm extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'rs-card-contact-form', 'description' => 'Rs-Card: Contact Form' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'rs-card-contact-form' );

		/* Create the widget. */
		parent::__construct( 'rs-card-contact-form', 'Rs-Card: Contact Form', $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );


		/* Before widget (defined by themes). */			
		echo $before_widget;		

		
		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title ) echo $before_title . $title . $after_title;
		$options = get_option( 'rscard_hide_meta' );
		isset($options['email_address'])? $email_address = $options['email_address']: $email_address = '';
		isset($options['email_placeholder'])? $email_placeholder = $options['email_placeholder']: $email_placeholder = 'Email';
		isset($options['name_placeholder'])? $name_placeholder = $options['name_placeholder']: $name_placeholder = 'Name';
		isset($options['subject_placeholder'])? $subject_placeholder = $options['subject_placeholder']: $subject_placeholder = 'Subject';
		isset($options['message_placeholder'])? $message_placeholder = $options['message_placeholder']: $message_placeholder = 'Message';
		isset($options['privacy_placeholder'])? $privacy_placeholder = $options['privacy_placeholder']: $privacy_placeholder = 'I have read the Privacy Policy note.';
		isset($options['submit_placeholder'])? $submit_placeholder = $options['submit_placeholder']: $submit_placeholder = 'Send';
		isset($options['google_recaptcha_style'])? $google_recaptcha_style = $options['google_recaptcha_style']: $google_recaptcha_style = 'light';
		?>
            <form class='contactForm' action='#' method='post'>
				<div class='input-field'>
					<input class='contact-name' type='text' name='name'/>
					<span class='line'></span>
					<label><?php echo esc_html($name_placeholder);?></label>
				</div>

				<div class='input-field'>
					<input class='contact-email' type='email' name='email'/>
					<span class='line'></span>
					<label><?php echo esc_html($email_placeholder);?></label>
				</div>

				<div class='input-field'>
					<input class='contact-subject' type='text' name='subject'/>
					<span class='line'></span>
					<label><?php echo esc_html($subject_placeholder);?></label>
				</div>

				<div class='input-field'>
					<textarea class='contact-message' rows='4' name='message'></textarea>
					<span class='line'></span>
					<label><?php echo esc_html($message_placeholder);?></label>
				</div>
				<?php if($email_address && filter_var(trim($email_address), FILTER_VALIDATE_EMAIL)):?>
					<input type='hidden' class='email_to' name='email_to' value='<?php echo esc_attr($email_address);?>'/>
				<?php endif;?>
				<?php if(isset($options['google_recaptcha']) && isset($options['google_recaptcha_sec'])):?>
					<div class="g-recaptcha" data-theme="<?php echo esc_attr($google_recaptcha_style);?>" data-sitekey="<?php echo esc_attr($options['google_recaptcha']);?>" id='recaptcha2'></div>
				<?php endif;?>
				<?php if( !empty( $privacy_placeholder ) ):?>
					<div class="check-field">
						<input type="checkbox" name="rsPivacyPolicy" id="rsPivacyPolicy">
						<label for="rsPivacyPolicy"><?php echo esc_attr($privacy_placeholder);?></label>
					</div>
				<?php endif;?>
				<span class='btn-outer btn-primary-outer ripple'>
					<input class='contact-submit btn btn-lg btn-primary' type='submit' value='<?php echo esc_attr($submit_placeholder);?>'/>
				</span>
				
				<div class='contact-response'></div>
			</form>
	<?php
		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => '');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:','rs-card' ); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" style="width:100%;" />
		</p>
		
	<?php
	}
}

?>
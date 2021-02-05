<?php
/**
 * Add an admin submenu link under Settings
 */
function rscard_add_options_submenu_page() {
     add_submenu_page(
          'options-general.php',          // admin page slug
          esc_html__( 'Contact Form Options', 'rs-card' ), // page title
          esc_html__( 'Contact Form Options', 'rs-card' ), // menu title
          'manage_options',               // capability required to see the page
          'rscard_options',                // admin page slug, e.g. options-general.php?page=rscard_options
          'rscard_options_page'            // callback function to display the options page
     );
}
add_action( 'admin_menu', 'rscard_add_options_submenu_page' );
 
/**
 * Register the settings
 */
function rscard_register_settings() {
     register_setting(
          'rscard_options',  // settings section
          'rscard_hide_meta' // setting name
     );
}
add_action( 'admin_init', 'rscard_register_settings' );
 
/**
 * Build the options page
 */
function rscard_options_page() {
     if ( ! isset( $_REQUEST['settings-updated'] ) )
          $_REQUEST['settings-updated'] = false; ?>
 
     <div class="wrap">
           
          <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
           
          <div id="poststuff">
               <div id="post-body">
                    <div id="post-body-content">
                         <form method="post" action="options.php">
                              <?php 
								  settings_fields( 'rscard_options' );
								  $options = get_option( 'rscard_hide_meta' );
								  isset($options['email_address'])? $email_address = $options['email_address']: $email_address = '';
								  isset($options['google_recaptcha'])? $google_recaptcha = $options['google_recaptcha']: $google_recaptcha = '';
								  isset($options['google_recaptcha_sec'])? $google_recaptcha_sec = $options['google_recaptcha_sec']: $google_recaptcha_sec = '';
								  isset($options['email_placeholder'])? $email_placeholder = $options['email_placeholder']: $email_placeholder = __('Email','rs-card');
								  isset($options['name_placeholder'])? $name_placeholder = $options['name_placeholder']: $name_placeholder = __('Name','rs-card');
								  isset($options['subject_placeholder'])? $subject_placeholder = $options['subject_placeholder']: $subject_placeholder = __('Subject','rs-card');
								  isset($options['message_placeholder'])? $message_placeholder = $options['message_placeholder']: $message_placeholder = __('Message','rs-card');
								  isset($options['submit_placeholder'])? $submit_placeholder = $options['submit_placeholder']: $submit_placeholder = __('Send','rs-card');
                                  isset($options['privacy_placeholder'])? $privacy_placeholder = $options['privacy_placeholder']: $privacy_placeholder = __('I have read the Privacy Policy note.','rs-card');
								  isset($options['success_message'])? $success_message = $options['success_message']: $success_message = __('Your email was sent!','rs-card');
								  isset($options['error_message'])? $error_message = $options['error_message']: $error_message = __('Something went wrong, please check plugin options.','rs-card');
								  isset($options['google_recaptcha_style'])? $google_recaptcha_style = $options['google_recaptcha_style']: $google_recaptcha_style = 'light';
							  ?>
                              <table class="form-table">
									<tr valign="top"><th scope="row"><?php _e( 'Email Address', 'rs-card' ); ?></th>
                                        <td>
											<input type="text" name="rscard_hide_meta[email_address]" id="email_address" value="<?php echo esc_attr($email_address);?>">
                                        </td>
                                    </tr>
                                    <tr valign="top"><th scope="row"><?php _e( 'Email Placeholder', 'rs-card' ); ?></th>
                                        <td>
											<input type="text" name="rscard_hide_meta[email_placeholder]" id="email_placeholder" value="<?php echo esc_attr($email_placeholder);?>">
                                        </td>
                                    </tr>								  
									<tr valign="top"><th scope="row"><?php _e( 'Name Placeholder', 'rs-card' ); ?></th>
                                        <td>
											<input type="text" name="rscard_hide_meta[name_placeholder]" id="name_placeholder" value="<?php echo esc_attr($name_placeholder);?>">
                                        </td>
                                    </tr>
									<tr valign="top"><th scope="row"><?php _e( 'Subject Placeholder', 'rs-card' ); ?></th>
                                        <td>
											<input type="text" name="rscard_hide_meta[subject_placeholder]" id="subject_placeholder" value="<?php echo esc_attr($subject_placeholder);?>">
                                        </td>
                                    </tr>	
									<tr valign="top"><th scope="row"><?php _e( 'Message Placeholder', 'rs-card' ); ?></th>
                                        <td>
											<input type="text" name="rscard_hide_meta[message_placeholder]" id="message_placeholder" value="<?php echo esc_attr($message_placeholder);?>">
                                        </td>
                                    </tr>
                                  <tr valign="top"><th scope="row"><?php _e( 'Privacy Policy Text', 'rs-card' ); ?></th>
                                      <td>
                                          <input type="text" name="rscard_hide_meta[privacy_placeholder]" id="privacy_placeholder" value="<?php echo esc_attr($privacy_placeholder);?>">
                                      </td>
                                  </tr>
									<tr valign="top"><th scope="row"><?php _e( 'Submit Button Text', 'rs-card' ); ?></th>
                                        <td>
											<input type="text" name="rscard_hide_meta[submit_placeholder]" id="submit_placeholder" value="<?php echo esc_attr($submit_placeholder);?>">
                                        </td>
                                    </tr>
									<tr valign="top"><th scope="row"><?php _e( 'Google Recaptcha Key', 'rs-card' ); ?></th>
                                        <td>
											<input type="text" name="rscard_hide_meta[google_recaptcha]" id="google_recaptcha" value="<?php echo esc_attr($google_recaptcha);?>">
                                        </td>
                                    </tr>
									<tr valign="top"><th scope="row"><?php _e( 'Successfully Sent Message', 'rs-card' ); ?></th>
                                        <td>
											<input type="text" name="rscard_hide_meta[success_message]" id="success_message" value="<?php echo esc_attr($success_message);?>">
                                        </td>
                                    </tr>
									<tr valign="top"><th scope="row"><?php _e( 'Error Message', 'rs-card' ); ?></th>
                                        <td>
											<input type="text" name="rscard_hide_meta[error_message]" id="error_message" value="<?php echo esc_attr($error_message);?>">
                                        </td>
                                    </tr>
									<tr valign="top"><th scope="row"><?php _e( 'Google Recaptcha Secret', 'rs-card' ); ?></th>
                                        <td>
											<input type="text" name="rscard_hide_meta[google_recaptcha_sec]" id="google_recaptcha" value="<?php echo esc_attr($google_recaptcha_sec);?>">
                                        </td>
                                    </tr>
									<tr valign="top"><th scope="row"><?php _e( 'Use Google Recaptcha Dark Theme', 'rs-card' ); ?></th>
                                        <td> 
											<input type="checkbox" name="rscard_hide_meta[google_recaptcha_style]" id="google_recaptcha_style" value="dark"<?php if($google_recaptcha_style == 'dark'):?> checked<?php endif;?>>
                                        </td>
                                    </tr>
                                        <td>
											<input type="submit" id="submit" value="Update">
                                        </td>
                                    </tr>	
                              </table>
                         </form>
                    </div> <!-- end post-body-content -->
               </div> <!-- end post-body -->
          </div> <!-- end poststuff -->
     </div>
	 <?php
}

function rscard_options_page_after_save( $old_value, $new_value ) {

	if( ! is_plugin_active( 'wpml-string-translation/plugin.php' ) ) {
		return;
	}

    foreach( $new_value as $key => $value ){

	    do_action( 'wpml_register_single_string', 'rs_card', $value, $new_value[ $key ] );

    }

}
add_action( 'update_option_rscard_hide_meta', 'rscard_options_page_after_save', 10, 2 );
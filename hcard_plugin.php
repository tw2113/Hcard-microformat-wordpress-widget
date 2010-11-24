<?php
/*
Plugin Name: Contact Information hcard Widget
Plugin URI: http://michaelbox.net
Description: Plugin that creates a widget containing optional contact information wrapped in microdata hcard classes
Version: 1.0
Author: Michael Beckwith
Author URI: http://michaelbox.net
*/

function declare_hcard_profile() {
echo '<link rel="profile" href="http://microformats.org/profile/hcard">';
}
add_action('wp_head','declare_hcard_profile');

class hCardWidget extends WP_Widget {
	function hCardWidget() {
		parent::WP_Widget(false, $name = 'hCardWidget');	
	}
	
	function widget($args, $instance) {
		//Output the widget content
		extract( $args );
		/*provided by user*/
		$title = apply_filters('widget_title', $instance['title']);
		//variables to style below
		$title = $instance['title'];
		$first_name = $instance['first_name'];
		$last_name = $instance['last_name'];
		$business_name = $instance['business_name'];
		$position_title = $instance['position_title'];
		$mailbox_num = $instance['mailbox_num'];
		$apt_suite = $instance['apt_suite'];
		$street = $instance['street'];
		$city = $instance['city'];
		$state = $instance['state'];
		$zip = $instance['zip'];
		$email_address = $instance['email_address'];
		$telephone = $instance['telephone'];

		echo '<!--begin vcard--><div id="contact_info" class="vcard sidebarbox">';

		/*Insert how to lay out the resulting information when viewing live*/
		
		//Names area
		if (($first_name) || ($last_name)) {
			$namecheck = 'true';
			echo '<p><span class="fn n">';
		}
		if ($first_name) {
			echo '<span class="given-name">'.$first_name.'</span>';
		}	
		if ($last_name) {
			echo '<span class="family-name">'.$last_name.'</span>';
		} 
		if ($namecheck == 'true') {
			echo '</span></p>';
		}
		
		//Organization info area
		if ($business_name)  {
			echo '<span class="org">'.$business_name.'</span>';
			if ($position_title) {//check just to see if a <br/> is needed
				echo '<br/>';
			}
		}
		if ($position_title) {
			echo '<span class="title">'.$position_title.'</span>';
		}
		
		//Address info area
		if (($mailbox_num) || ($street) || ($city) || ($state) || ($zip) || ($email_address) || ($telephone) ) {
		$addresscheck = 'true';
		echo '<p class="adr">';
		}
		
		if ($mailbox_num) {
			echo '<span class="post-office-box">P.O. Box '.$mailbox_num.'</span><br/>';
		}
		if ($street) {
			echo '<span class="street-address">'.$street.'</span> ';
			if ($apt_suite) {//check just to see if a <br/> is needed
				echo '<br/>';
			}
		}
		if ($apt_suite) {
			echo '<span class="extended-address">'.$apt_suite.'</span>';
		}
		if ($city) {
			echo '<span class="locality">'.$city.'</span> ';
		}
		if ($state) {
			echo '<span class="region">'.$state.'</span>, ';
		}
		if ($zip) {
			echo '<span class="postal-code">'.$zip.'</span>';
		}
		if ($email_address) {
			echo '<p><a class="email" href="mailto:'.$email_address.'">'.$email_address.'</a><br/>';
		}
		if ($telephone) {
			echo '<span class="tel">'.$telephone.'</span>';
		}
		if ($addresscheck == 'true') {
		echo '</p>';
		}
		echo'</div><!--end vcard-->';
	}
	
	function update($new_instance, $old_instance) {
		//Process and save the widget options
		$instance = $old_instance;
		/*strips tags as needed to keep them clean*/
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['link'] = strip_tags($new_instance['link']);
		$instance['image'] = strip_tags($new_instance['image']);
		$instance['thumb'] = strip_tags($new_instance['thumb']);
		$instance['descrip'] = strip_tags($new_instance['descrip']);
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['first_name'] = strip_tags($new_instance['first_name']);
		$instance['last_name'] = strip_tags($new_instance['last_name']);
		$instance['business_name'] = strip_tags($new_instance['business_name']);
		$instance['position_title'] = strip_tags($new_instance['position_title']);
		$instance['mailbox_num'] = strip_tags($new_instance['mailbox_num']);
		$instance['apt_suite'] = strip_tags($new_instance['apt_suite']);
		$instance['street'] = strip_tags($new_instance['street']);
		$instance['city'] = strip_tags($new_instance['city']);
		$instance['state'] = strip_tags($new_instance['state']);
		$instance['zip'] = strip_tags($new_instance['zip']);
		$instance['email_address'] = strip_tags($new_instance['email_address']);
		$instance['telephone'] = strip_tags($new_instance['telephone']);
		
		return $instance;
	}
	
	function form($instance) {
		//Output the options form in admin
		$title = $instance['title'];
		$first_name = $instance['first_name'];
		$last_name = $instance['last_name'];
		$business_name = $instance['business_name'];
		$position_title = $instance['position_title'];
		$mailbox_num = $instance['mailbox_num'];
		$apt_suite = $instance['apt_suite'];
		$street = $instance['street'];
		$city = $instance['city'];
		$state = $instance['state'];
		$zip = $instance['zip'];
		$email_address = $instance['email_address'];
		$telephone = $instance['telephone']; ?>
		
		<!--The form that the user has to enter the data-->
			<p>Please provide at least one name field (first or last) for hcard validity. The remaining fields are optional. Output based on provided data.</p>
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Widget Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" placeholder="Title of the widget" type="text" value="<?php echo $title; ?>" /></label></p><!--Widget title-->
			<p><label for="<?php echo $this->get_field_id('first_name'); ?>">First Name: <input class="widefat" id="<?php echo $this->get_field_id('first_name'); ?>" name="<?php echo $this->get_field_name('first_name'); ?>" placeholder="First name please..." type="text" value="<?php echo $first_name; ?>" /></label></p><!--First name field-->
            <p><label for="<?php echo $this->get_field_id('last_name'); ?>">Last Name: <input class="widefat" id="<?php echo $this->get_field_id('last_name'); ?>" name="<?php echo $this->get_field_name('last_name'); ?>" placeholder="...and then your last name." type="text" value="<?php echo $last_name; ?>" /></label></p><!--Last name field-->
			<p><label for="<?php echo $this->get_field_id('business_name'); ?>">Business Name: <input class="widefat" id="<?php echo $this->get_field_id('business_name'); ?>" name="<?php echo $this->get_field_name('business_name'); ?>" placeholder="What is your business' name?" type="text" value="<?php echo $business_name; ?>" /></label></p><!--Business Name-->
			<p><label for="<?php echo $this->get_field_id('position_title'); ?>">Position Title: <input class="widefat" id="<?php echo $this->get_field_id('position_title'); ?>" name="<?php echo $this->get_field_name('position_title'); ?>" placeholder="Ooh, what's your job title?" type="text" value="<?php echo $position_title; ?>" /></label></p><!--Position-->
			<p><label for="<?php echo $this->get_field_id('mailbox_num'); ?>">P.O. Box: <input class="widefat" id="<?php echo $this->get_field_id('mailbox_num'); ?>" name="<?php echo $this->get_field_name('mailbox_num'); ?>" placeholder="What is your P.O. Box?" type="text" value="<?php echo $mailbox_num; ?>" /></label></p><!--PO Box-->
			<p><label for="<?php echo $this->get_field_id('apt_suite'); ?>">Apt or Suite #: <input class="widefat" id="<?php echo $this->get_field_id('apt_suite'); ?>" name="<?php echo $this->get_field_name('apt_suite'); ?>" placeholder="Which Apt/Suite in the building are you at?" type="text" value="<?php echo $apt_suite; ?>" /></label></p><!--Apt #-->
			<p><label for="<?php echo $this->get_field_id('street'); ?>">Street Address: <input class="widefat" id="<?php echo $this->get_field_id('street'); ?>" name="<?php echo $this->get_field_name('street'); ?>" placeholder="What's your street address?" type="text" value="<?php echo $street; ?>" /></label></p><!--Street Addy-->
			<p><label for="<?php echo $this->get_field_id('city'); ?>">City: <input class="widefat" id="<?php echo $this->get_field_id('city'); ?>" name="<?php echo $this->get_field_name('city'); ?>" placeholder="You live in a city/town right?" type="text" value="<?php echo $city; ?>" /></label></p><!--City-->
			<p><label for="<?php echo $this->get_field_id('state'); ?>">State: <input class="widefat" id="<?php echo $this->get_field_id('state'); ?>" name="<?php echo $this->get_field_name('state'); ?>" placeholder="Remember, madness is not a valid state" type="text" value="<?php echo $state; ?>" /></label></p><!--State-->
			<p><label for="<?php echo $this->get_field_id('zip'); ?>">Zip code: <input class="widefat" id="<?php echo $this->get_field_id('zip'); ?>" name="<?php echo $this->get_field_name('zip'); ?>" placeholder="What's the zip code?" type="text" value="<?php echo $zip; ?>" /></label></p><!--Zip-->
			<p><label for="<?php echo $this->get_field_id('email_address'); ?>">Email: <input class="widefat" id="<?php echo $this->get_field_id('email_address'); ?>" name="<?php echo $this->get_field_name('email_address'); ?>" placeholder="What email should people use?" type="email" value="<?php echo $email_address; ?>" /></label></p><!--Email-->
			<p><label for="<?php echo $this->get_field_id('telephone'); ?>">Telephone: <input class="widefat" id="<?php echo $this->get_field_id('telephone'); ?>" name="<?php echo $this->get_field_name('telephone'); ?>" placeholder="What numbers should people dial?" type="text" value="<?php echo $telephone; ?>" /></label></p><!--Telephone-->
		
	<?php }
}
//register_widget('hCardWidget');
add_action('widgets_init', create_function('', 'return register_widget("hCardWidget");'));

?>

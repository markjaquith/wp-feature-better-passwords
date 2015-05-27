<?php
defined( 'WPINC' ) or die;

?>

<tr id="password" class="user-pass1-wrap">
	<th><label for="pass1"><?php _e( 'New Password' ); ?></label></th>
	<td>
		<input class="hidden" value=" " /><!-- #24364 workaround -->
		<input type="password" name="pass1" id="pass1" class="regular-text" size="16" value="" autocomplete="off" />
		<p class="description"><?php _e( 'If you would like to change the password type a new one. Otherwise leave this blank.' ); ?></p>
	</td>
</tr>
<tr class="user-pass2-wrap">
	<th scope="row"><label for="pass2"><?php _e( 'Repeat New Password' ); ?></label></th>
	<td>
	<input name="pass2" type="password" id="pass2" class="regular-text" size="16" value="" autocomplete="off" />
	<p class="description"><?php _e( 'Type your new password again.' ); ?></p>
	<br />
	<div id="pass-strength-result"><?php _e( 'Strength indicator' ); ?></div>
	<p class="description indicator-hint"><?php echo wp_get_password_hint(); ?></p>
	</td>
</tr>

<?php
defined( 'WPINC' ) or die;

?>

<script>
jQuery(function($){
	var pw_new = $('.user-pass1-wrap'),
			pw_line = pw_new.find('.wp-pwd'),
			pw_field = $('#pass1'),
			pw_togglebtn = pw_new.find('.wp-hide-pw'),
			pw_generatebtn = pw_new.find('button.wp-generate-pw'),
			pw_2 = $('.user-pass2-wrap'),
			parentform = pw_new.closest('form')
	;

	pw_2.hide();
	pw_line.hide();
	pw_togglebtn.show();
	pw_generatebtn.show();

	parentform.on('submit', function(){
		$('#pass2').val( pw_field.val() );
		pw_field.attr('type', 'password');
	});


	pw_new.on('click', 'button.wp-generate-pw', function(e){
		e.preventDefault();
		pw_generatebtn.hide();
		pw_line.show();
		pw_field.val(pw_field.data('pw')).attr('type', 'text');
		pw_field.trigger('propertychange');
	});

	pw_togglebtn.on('click', function(e){
		var show = pw_togglebtn.attr('data-toggle');
		e.preventDefault();
		if (show == 1) {
			pw_field.attr('type', 'text');
			pw_togglebtn.attr('data-toggle', 0)
				.find('.text')
					.text('hide')
			;
		} else {
			pw_field.attr('type', 'password');
			pw_togglebtn.attr('data-toggle', 1)
				.find('.text')
					.text('show')
			;
		}
	});
});
</script>

<style>
button.wp-hide-pw > .dashicons {
	position: relative;
	top: 3px;
}
</style>

<tr id="password" class="user-pass1-wrap">
	<th><label for="pass1"><?php _e( 'New Password' ); ?></label></th>
	<td>
		<input class="hidden" value=" " /><!-- #24364 workaround -->
		<button type="button" style="display:none" class="button button-secondary wp-generate-pw"><?php _e( 'Generate new password' ); ?></button>
		<div class="wp-pwd">
		<input type="password" name="pass1" id="pass1" class="regular-text" size="16" value="" autocomplete="off" data-pw="<?php echo esc_attr( wp_generate_password( 24, false, false ) ); ?>" /> <button type="button" style="display: none" class="button button-secondary wp-hide-pw" data-toggle="0">
			<span class="dashicons dashicons-visibility"></span>
			<span class="text">hide</span>
		</button>
		<br />
		<div id="pass-strength-result"><?php _e( 'Strength indicator' ); ?></div>
		</div>
	</td>
</tr>
<tr class="user-pass2-wrap">
	<th scope="row"><label for="pass2"><?php _e( 'Repeat New Password' ); ?></label></th>
	<td>
	<input name="pass2" type="password" id="pass2" class="regular-text" size="16" value="" autocomplete="off" />
	<p class="description"><?php _e( 'Type your new password again.' ); ?></p>
	</td>
</tr>

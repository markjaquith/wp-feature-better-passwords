<?php
defined( 'WPINC' ) or die;

?>

<script>
jQuery(function($){
	window.pwsL10n.empty = '&nbsp;';
	var pw_new = $('.user-pass1-wrap'),
			pw_line = pw_new.find('.wp-pwd'),
			pw_field = $('#pass1'),
			pw_field2 = $('#pass2'),
			pw_togglebtn = pw_new.find('.wp-hide-pw'),
			pw_generatebtn = pw_new.find('button.wp-generate-pw'),
			pw_2 = $('.user-pass2-wrap'),
			parentform = pw_new.closest('form'),
			pw_strength = $('#pass-strength-result')
	;

	pw_2.hide();
	pw_line.hide();
	pw_togglebtn.show();
	pw_generatebtn.show();

	parentform.on('submit', function(){
		pw_field2.val( pw_field.val() );
		pw_field.attr('type', 'password');
	});


	pw_field.on('input propertychange', function(){
		setTimeout( function(){
			var cssClass = pw_strength.attr('class');
				pw_field.removeClass( 'short bad good strong' );
			if ( 'undefined' !== typeof cssClass ) {
				pw_field.addClass( cssClass );
			}
		}, 1 );
	});

	/**
	 * Fix a LastPass mismatch issue, LastPass only changes pass2.
	 *
	 * This fixes the issue by copying any changes from the hidden
	 * pass2 field to the pass1 field.
	 */
	pw_field2.on( 'input propertychange', function(){
		pw_field.val( pw_field2.val() );
		pw_field.trigger( 'propertychange' );
	} );

	pw_new.on('click', 'button.wp-generate-pw', function(){
		pw_generatebtn.hide();
		pw_line.show();
		pw_field.val(pw_field.data('pw')).attr('type', 'text');
		pw_field.trigger('propertychange');
	});

	pw_togglebtn.on('click', function(){
		var show = pw_togglebtn.attr('data-toggle');
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
#pass-strength-result {
	float: none;
	margin-top: -2px;
	width: 25em;
	box-sizing: border-box;
	opacity: 0;
}
#pass-strength-result.short, #pass-strength-result.bad, #pass-strength-result.good, #pass-strength-result.strong {
	opacity: 1;
}
input#pass1 {
	box-shadow: none;
}

input#pass1.short {
	border-color: #f04040;
}

input#pass1.bad {
	border-color: #ff853c;
}

input#pass1.good {
	border-color: #fc0;
}

input#pass1.strong {
	border-color: #8dff1c;
}
</style>

<tr id="password" class="user-pass1-wrap">
	<th><label for="pass1"><?php _e( 'New Password' ); ?></label></th>
	<td>
		<input class="hidden" value=" " /><!-- #24364 workaround -->
		<button type="button" style="display:none" class="button button-secondary wp-generate-pw"><?php _e( 'Generate new password' ); ?></button>
		<div class="wp-pwd">
		<input type="password" name="pass1" id="pass1" class="regular-text" value="" autocomplete="off" data-pw="<?php echo esc_attr( wp_generate_password( 24 ) ); ?>" /> <button type="button" style="display: none" class="button button-secondary wp-hide-pw" data-toggle="0">
			<span class="dashicons dashicons-visibility"></span>
			<span class="text">hide</span>
		</button>
		<div style="display:none" id="pass-strength-result"></div>
		</div>
	</td>
</tr>
<tr class="user-pass2-wrap">
	<th scope="row"><label for="pass2"><?php _e( 'Repeat New Password' ); ?></label></th>
	<td>
	<input name="pass2" type="password" id="pass2" class="regular-text" value="" autocomplete="off" />
	<p class="description"><?php _e( 'Type your new password again.' ); ?></p>
	</td>
</tr>

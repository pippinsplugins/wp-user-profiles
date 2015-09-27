<?php

/**
 * Add the default user profile metaboxes
 *
 * @since 0.1.0
 *
 * @param   string  $type
 * @param   mixed   $user
 */
function wp_user_profiles_add_profile_meta_boxes( $type = '', $user = false ) {

	// Bail if not user metaboxes
	if ( 'admin_page_profile' !== $type ) {
		return;
	}

	// Register metaboxes for the user edit screen
	add_meta_box(
		'submitdiv',
		_x( 'Status', 'users user-admin edit screen', 'wp-user-profiles' ),
		'wp_user_profiles_status_metabox',
		'admin_page_profile',
		'side',
		'core'
	);

	// Name
	add_meta_box(
		'name',
		_x( 'Name', 'users user-admin edit screen', 'wp-user-profiles' ),
		'wp_user_profiles_name_metabox',
		'admin_page_profile',
		'normal',
		'core'
	);

	// Register metaboxes for the user edit screen
	add_meta_box(
		'about',
		_x( 'About', 'users user-admin edit screen', 'wp-user-profiles' ),
		'wp_user_profiles_about_metabox',
		'admin_page_profile',
		'normal',
		'core'
	);

}

/**
 * Add the default user profile metaboxes
 *
 * @since 0.1.0
 *
 * @param   string  $type
 * @param   mixed   $user
 */
function wp_user_profiles_add_account_meta_boxes( $type = '', $user = false ) {

	// Bail if not user metaboxes
	if ( 'admin_page_account' !== $type ) {
		return;
	}

	// Status
	add_meta_box(
		'submitdiv',
		_x( 'Status', 'users user-admin edit screen', 'wp-user-profiles' ),
		'wp_user_profiles_status_metabox',
		'admin_page_account',
		'side',
		'core'
	);

	// Password
	add_meta_box(
		'email',
		_x( 'Email', 'users user-admin edit screen', 'wp-user-profiles' ),
		'wp_user_profiles_email_metabox',
		'admin_page_account',
		'normal',
		'core'
	);

	// Password
	add_meta_box(
		'password',
		_x( 'Password', 'users user-admin edit screen', 'wp-user-profiles' ),
		'wp_user_profiles_password_metabox',
		'admin_page_account',
		'normal',
		'core'
	);

	// Sessions
	add_meta_box(
		'sessions',
		_x( 'Sessions', 'users user-admin edit screen', 'wp-user-profiles' ),
		'wp_user_profiles_session_metabox',
		'admin_page_account',
		'normal',
		'core'
	);
}

/**
 * Add the default user profile metaboxes
 *
 * @since 0.1.0
 *
 * @param   string  $type
 * @param   mixed   $user
 */
function wp_user_profiles_add_options_meta_boxes( $type = '', $user = false ) {

	// Bail if not user metaboxes
	if ( 'admin_page_options' !== $type ) {
		return;
	}

	// Always register the status box
	add_meta_box(
		'submitdiv',
		_x( 'Status', 'users user-admin edit screen', 'wp-user-profiles' ),
		'wp_user_profiles_status_metabox',
		'admin_page_options',
		'side',
		'core'
	);

	// Color schemes
	add_meta_box(
		'colors',
		_x( 'Color Scheme', 'users user-admin edit screen', 'wp-user-profiles' ),
		'wp_user_profiles_color_scheme_metabox',
		'admin_page_options',
		'normal',
		'core'
	);

	// Color schemes
	add_meta_box(
		'options',
		_x( 'Personal Options', 'users user-admin edit screen', 'wp-user-profiles' ),
		'wp_user_profiles_personal_options_metabox',
		'admin_page_options',
		'normal',
		'core'
	);
}

/**
 * Render the primary metabox for user profile screen
 *
 * @since 0.1.0
 *
 * @param WP_User $user The WP_User object to be edited.
 */
function wp_user_profiles_status_metabox( $user = null ) {

	// Bail if no user id or if the user has not activated their account yet
	if ( empty( $user->ID ) ) {
		return;
	}

	// Bail if user has not been activated yet (how did you get here?)
	if ( isset( $user->user_status ) && ( 2 == $user->user_status ) ) : ?>

		<p class="not-activated"><?php esc_html_e( 'User account has not yet been activated', 'wp-user-profiles' ); ?></p><br/>

		<?php return;

	endif; ?>

	<div class="submitbox" id="submitcomment">
		<div id="minor-publishing">
			<div id="misc-publishing-actions">
				<?php

				// Get the spam status once here to compare against below
				if ( IS_PROFILE_PAGE && ( ! in_array( $user->user_login, get_super_admins() ) ) ) : ?>

					<div class="misc-pub-section" id="comment-status-radio">
						<label class="approved"><input type="radio" name="user_status" value="ham" <?php checked( $user->user_status, 2 ); ?>><?php esc_html_e( 'Active', 'wp-user-profiles' ); ?></label><br />
						<label class="spam"><input type="radio" name="user_status" value="spam" <?php checked( $user->user_status, 0 ); ?>><?php esc_html_e( 'Spammer', 'wp-user-profiles' ); ?></label>
					</div>

				<?php endif ;?>

				<div class="misc-pub-section curtime misc-pub-section-last">
					<?php

					// translators: Publish box date format, see http://php.net/date
					$datef = __( 'M j, Y @ G:i', 'wp-user-profiles' );
					$date  = date_i18n( $datef, strtotime( $user->user_registered ) );
					?>
					<span id="timestamp"><?php printf( __( 'Registered on: <strong>%1$s</strong>', 'wp-user-profiles' ), $date ); ?></span>
				</div>
			</div>

			<div class="clear"></div>
		</div>

		<div id="major-publishing-actions">
			<div id="publishing-action">
				<a class="button" href="<?php echo esc_url(); ?>" target="_blank"><?php esc_html_e( 'View User', 'wp-user-profiles' ); ?></a>
				<?php submit_button( esc_html__( 'Update', 'wp-user-profiles' ), 'primary', 'save', false ); ?>
				<input type="hidden" name="action" value="update" />
				<input type="hidden" name="user_id" id="user_id" value="<?php echo esc_attr( $user->ID ); ?>" />
			</div>
			<div class="clear"></div>
		</div>
	</div>

	<?php
}

/**
 * Render the personal options metabox for user profile screen
 *
 * @since 0.1.0
 *
 * @param WP_User $user The WP_User object to be edited.
 */
function wp_user_profiles_color_scheme_metabox( $user = null ) {

	// Bail if no color schemes
	if ( ! count( $GLOBALS['_wp_admin_css_colors'] ) || ! has_action( 'admin_color_scheme_picker' ) ) {
		return;
	} ?>

	<table class="form-table">
		<tr class="user-admin-color-wrap">
			<th scope="row"><?php esc_html_e( 'Admin Color Scheme', 'wp-user-profiles' ); ?></th>
			<td><?php
			/**
			 * Fires in the 'Admin Color Scheme' section of the user editing screen.
			 *
			 * The section is only enabled if a callback is hooked to the action,
			 * and if there is more than one defined color scheme for the admin.
			 *
			 * @since 3.0.0
			 * @since 3.8.1 Added `$user_id` parameter.
			 *
			 * @param int $user_id The user ID.
			 */
			do_action( 'admin_color_scheme_picker', $user->ID );
			?></td>
		</tr>
	</table>

	<?php
}

/**
 * Render the personal options metabox for user profile screen
 *
 * @since 0.1.0
 *
 * @param WP_User $user The WP_User object to be edited.
 */
function wp_user_profiles_personal_options_metabox( $user = null ) {
?>

	<table class="form-table">

		<?php if ( ! ( IS_PROFILE_PAGE && ! ( current_user_can( 'edit_posts' ) || current_user_can( 'edit_pages' ) ) ) ) : ?>

			<tr class="user-rich-editing-wrap">
				<th scope="row"><?php _e( 'Visual Editor' ); ?></th>
				<td><label for="rich_editing"><input name="rich_editing" type="checkbox" id="rich_editing" value="false" <?php if ( ! empty( $user->rich_editing ) ) checked( 'false', $user->rich_editing ); ?> /> <?php _e( 'Disable the visual editor when writing' ); ?></label></td>
			</tr>
			<tr class="user-comment-shortcuts-wrap">
				<th scope="row"><?php _e( 'Keyboard Shortcuts' ); ?></th>
				<td><label for="comment_shortcuts"><input type="checkbox" name="comment_shortcuts" id="comment_shortcuts" value="true" <?php if ( ! empty( $user->comment_shortcuts ) ) checked( 'true', $user->comment_shortcuts ); ?> /> <?php _e('Enable keyboard shortcuts for comment moderation.'); ?></label> <?php _e('<a href="https://codex.wordpress.org/Keyboard_Shortcuts" target="_blank">More information</a>'); ?></td>
			</tr>

		<?php endif; ?>

		<tr class="show-admin-bar user-admin-bar-front-wrap">
			<th scope="row"><?php _e( 'Toolbar' ); ?></th>
			<td>
				<fieldset>
					<legend class="screen-reader-text"><span><?php _e('Toolbar') ?></span></legend>
					<label for="admin_bar_front">
						<input name="admin_bar_front" type="checkbox" id="admin_bar_front" value="1"<?php checked( _get_admin_bar_pref( 'front', $user->ID ) ); ?> />
						<?php _e( 'Show Toolbar when viewing site' ); ?>
					</label><br />
				</fieldset>
			</td>
		</tr>
		<?php
		/**
		 * Fires at the end of the 'Personal Options' settings table on the user editing screen.
		 *
		 * @since 2.7.0
		 *
		 * @param WP_User $user The current WP_User object.
		 */
		do_action( 'personal_options', $user );
		?>

	</table>

	<?php
}

/**
 * Render the personal options metabox for user profile screen
 *
 * @since 0.1.0
 *
 * @param WP_User $user The WP_User object to be edited.
 */
function wp_user_profiles_name_metabox( $user = null ) {

	if ( IS_PROFILE_PAGE ) {
		/**
		 * Fires after the 'Personal Options' settings table on the 'Your Profile' editing screen.
		 *
		 * The action only fires if the current user is editing their own profile.
		 *
		 * @since 2.0.0
		 *
		 * @param WP_User $user The current WP_User object.
		 */
		do_action( 'profile_personal_options', $user );
	} ?>

<table class="form-table">
	<tr class="user-user-login-wrap">
		<th><label for="user_login"><?php _e('Username'); ?></label></th>
		<td>
			<cite title="<?php _e('Usernames cannot be changed.'); ?>"><?php echo esc_attr( $user->user_login ); ?></cite>
			<input type="hidden" name="user_login" id="user_login" value="<?php echo esc_attr($user->user_login); ?>" disabled="disabled" class="regular-text" />
		</td>
	</tr>

<?php if ( !IS_PROFILE_PAGE && !is_network_admin() ) : ?>
<tr class="user-role-wrap"><th><label for="role"><?php _e('Role') ?></label></th>
<td><select name="role" id="role">
<?php
// Compare user role against currently editable roles
$user_roles = array_intersect( array_values( $user->roles ), array_keys( get_editable_roles() ) );
$user_role  = reset( $user_roles );

// print the full list of roles with the primary one selected.
wp_dropdown_roles($user_role);

// print the 'no role' option. Make it selected if the user has no role yet.
if ( $user_role )
	echo '<option value="">' . __('&mdash; No role for this site &mdash;') . '</option>';
else
	echo '<option value="" selected="selected">' . __('&mdash; No role for this site &mdash;') . '</option>';
?>
</select></td></tr>
<?php endif; //!IS_PROFILE_PAGE

if ( is_multisite() && is_network_admin() && ! IS_PROFILE_PAGE && current_user_can( 'manage_network_options' ) && !isset($super_admins) ) { ?>
<tr class="user-super-admin-wrap"><th><?php _e('Super Admin'); ?></th>
<td>
<?php if ( $user->user_email != get_site_option( 'admin_email' ) || ! is_super_admin( $user->ID ) ) : ?>
<p><label><input type="checkbox" id="super_admin" name="super_admin"<?php checked( is_super_admin( $user->ID ) ); ?> /> <?php _e( 'Grant this user super admin privileges for the Network.' ); ?></label></p>
<?php else : ?>
<p><?php _e( 'Super admin privileges cannot be removed because this user has the network admin email.' ); ?></p>
<?php endif; ?>
</td></tr>
<?php } ?>

<tr class="user-first-name-wrap">
	<th><label for="first_name"><?php _e('First Name') ?></label></th>
	<td><input type="text" name="first_name" id="first_name" value="<?php echo esc_attr($user->first_name) ?>" class="regular-text" /></td>
</tr>

<tr class="user-last-name-wrap">
	<th><label for="last_name"><?php _e('Last Name') ?></label></th>
	<td><input type="text" name="last_name" id="last_name" value="<?php echo esc_attr($user->last_name) ?>" class="regular-text" /></td>
</tr>

<tr class="user-nickname-wrap">
	<th><label for="nickname"><?php _e('Nickname'); ?> <span class="description"><?php _e('(required)'); ?></span></label></th>
	<td><input type="text" name="nickname" id="nickname" value="<?php echo esc_attr($user->nickname) ?>" class="regular-text" /></td>
</tr>

<tr class="user-display-name-wrap">
	<th><label for="display_name"><?php _e('Display name publicly as') ?></label></th>
	<td>
		<select name="display_name" id="display_name">
		<?php
			$public_display = array();
			$public_display['display_nickname']  = $user->nickname;
			$public_display['display_username']  = $user->user_login;

			if ( !empty($user->first_name) )
				$public_display['display_firstname'] = $user->first_name;

			if ( !empty($user->last_name) )
				$public_display['display_lastname'] = $user->last_name;

			if ( !empty($user->first_name) && !empty($user->last_name) ) {
				$public_display['display_firstlast'] = $user->first_name . ' ' . $user->last_name;
				$public_display['display_lastfirst'] = $user->last_name . ' ' . $user->first_name;
			}

			if ( !in_array( $user->display_name, $public_display ) ) // Only add this if it isn't duplicated elsewhere
				$public_display = array( 'display_displayname' => $user->display_name ) + $public_display;

			$public_display = array_map( 'trim', $public_display );
			$public_display = array_unique( $public_display );

			foreach ( $public_display as $id => $item ) {
		?>
			<option <?php selected( $user->display_name, $item ); ?>><?php echo $item; ?></option>
		<?php
			}
		?>
		</select>
	</td>
</tr>
</table>

	<?php
}

/**
 * Render the contact metabox for user profile screen
 *
 * @since 0.1.0
 *
 * @param WP_User $user The WP_User object to be edited.
 */
function wp_user_profiles_email_metabox( $user = null ) {
	$current_user = wp_get_current_user(); ?>

	<table class="form-table">
		<tr class="user-email-wrap">
			<th><label for="email"><?php _e('Email'); ?> <span class="description"><?php _e('(required)'); ?></span></label></th>
			<td><input type="email" name="email" id="email" value="<?php echo esc_attr( $user->user_email ) ?>" class="regular-text ltr" />
			<?php
			$new_email = get_option( $current_user->ID . '_new_email' );
			if ( $new_email && $new_email['newemail'] != $current_user->user_email && $user->ID == $current_user->ID ) : ?>
			<div class="updated inline">
			<p><?php
				printf(
					__( 'There is a pending change of your email to %1$s. <a href="%2$s">Cancel</a>' ),
					'<code>' . $new_email['newemail'] . '</code>',
					esc_url( self_admin_url( 'profile.php?dismiss=' . $current_user->ID . '_new_email' ) )
			); ?></p>
			</div>
			<?php endif; ?>
			</td>
		</tr>
	</table>

	<?php
}

/**
 * Render the contact metabox for user profile screen
 *
 * @since 0.1.0
 *
 * @param WP_User $user The WP_User object to be edited.
 */
function wp_user_profiles_contact_metabox( $user = null ) {
?>

	<table class="form-table">
		<tr class="user-url-wrap">
			<th><label for="url"><?php _e('Website') ?></label></th>
			<td><input type="url" name="url" id="url" value="<?php echo esc_attr( $user->user_url ) ?>" class="regular-text code" /></td>
		</tr>

		<?php foreach ( wp_get_user_contact_methods( $user ) as $name => $desc ) : ?>

			<tr class="user-<?php echo $name; ?>-wrap">
				<th><label for="<?php echo $name; ?>">
					<?php
					/**
					 * Filter a user contactmethod label.
					 *
					 * The dynamic portion of the filter hook, `$name`, refers to
					 * each of the keys in the contactmethods array.
					 *
					 * @since 2.9.0
					 *
					 * @param string $desc The translatable label for the contactmethod.
					 */
					echo apply_filters( "user_{$name}_label", $desc );
					?>
				</label></th>
				<td><input type="text" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo esc_attr($user->$name) ?>" class="regular-text" /></td>
			</tr>

		<?php endforeach; ?>

	</table>

	<?php
}

/**
 * Render the about metabox for user profile screen
 *
 * @since 0.1.0
 *
 * @param WP_User $user The WP_User object to be edited.
 */
function wp_user_profiles_about_metabox( $user = null ) {
?>

	<table class="form-table">
		<tr class="user-url-wrap">
			<th><label for="url"><?php _e('Website') ?></label></th>
			<td><input type="url" name="url" id="url" value="<?php echo esc_attr( $user->user_url ) ?>" class="regular-text code" /></td>
		</tr>
		<tr class="user-description-wrap">
			<th><label for="description"><?php _e('Biographical Info'); ?></label></th>
			<td>
				<textarea name="description" id="description" rows="5" cols="30"><?php echo $user->description; // textarea_escaped ?></textarea>
				<p class="description">
					<?php _e('Share a little biographical information to fill out your profile. This may be shown publicly.'); ?></p>
			</td>
		</tr>
	</table>

	<?php
}


/**
 * Render the password metabox for user profile screen
 *
 * @since 0.1.0
 *
 * @param WP_User $user The WP_User object to be edited.
 */
function wp_user_profiles_session_metabox( $user = null ) {

	// Get session
	$sessions = WP_Session_Tokens::get_instance( $user->ID ); ?>

	<table class="form-table">

		<?php if ( IS_PROFILE_PAGE && count( $sessions->get_all() ) === 1 ) : ?>

			<tr class="user-sessions-wrap hide-if-no-js">
				<th><?php _e( 'Sessions' ); ?></th>
				<td aria-live="assertive">
					<div class="destroy-sessions"><button type="button" disabled class="button button-secondary"><?php _e( 'Log Out Everywhere Else' ); ?></button></div>
					<p class="description">
						<?php _e( 'You are only logged in at this location.' ); ?>
					</p>
				</td>
			</tr>

		<?php elseif ( IS_PROFILE_PAGE && count( $sessions->get_all() ) > 1 ) : ?>

			<tr class="user-sessions-wrap hide-if-no-js">
				<th><?php _e( 'Sessions' ); ?></th>
				<td aria-live="assertive">
					<div class="destroy-sessions"><button type="button" class="button button-secondary" id="destroy-sessions"><?php _e( 'Log Out Everywhere Else' ); ?></button></div>
					<p class="description">
						<?php _e( 'Did you lose your phone or leave your account logged in at a public computer? You can log out everywhere else, and stay logged in here.' ); ?>
					</p>
				</td>
			</tr>

		<?php elseif ( ! IS_PROFILE_PAGE && $sessions->get_all() ) : ?>

			<tr class="user-sessions-wrap hide-if-no-js">
				<th><?php _e( 'Sessions' ); ?></th>
				<td>
					<p><button type="button" class="button button-secondary" id="destroy-sessions"><?php _e( 'Log Out Everywhere' ); ?></button></p>
					<p class="description">
						<?php
						/* translators: 1: User's display name. */
						printf( __( 'Log %s out of all locations.' ), $user->display_name );
						?>
					</p>
				</td>
			</tr>

		<?php endif; ?>

	</table>

<?php
}


/**
 * Render the capabilities metabox for user profile screen
 *
 * @since 0.1.0
 *
 * @param WP_User $user The WP_User object to be edited.
 */
function wp_user_profiles_additional_capabilities_metabox( $user = null ) {
?>

<table class="form-table">
<tr class="user-capabilities-wrap">
	<th scope="row"><?php _e( 'Capabilities' ); ?></th>
	<td>
<?php
	$output = '';
	foreach ( $user->caps as $cap => $value ) {
		if ( ! $wp_roles->is_role( $cap ) ) {
			if ( '' != $output )
				$output .= ', ';
			$output .= $value ? $cap : sprintf( __( 'Denied: %s' ), $cap );
		}
	}
	echo $output;
?>
	</td>
</tr>
</table>

<?php
}

/**
 * Render the password metabox for user profile screen
 *
 * @since 0.1.0
 *
 * @param WP_User $user The WP_User object to be edited.
 */
function wp_user_profiles_password_metabox( $user = null ) {
?>

	<table class="form-table">
		<tr id="password" class="user-pass1-wrap">
			<th><label for="pass1"><?php _e( 'New Password' ); ?></label></th>
			<td>
				<input class="hidden" value=" " /><!-- #24364 workaround -->
				<button type="button" class="button button-secondary wp-generate-pw hide-if-no-js"><?php _e( 'Generate Password' ); ?></button>
				<div class="wp-pwd hide-if-js">
					<span class="password-input-wrapper">
						<input type="password" name="pass1" id="pass1" class="regular-text" value="" autocomplete="off" data-pw="<?php echo esc_attr( wp_generate_password( 24 ) ); ?>" aria-describedby="pass-strength-result" />
					</span>
					<button type="button" class="button button-secondary wp-hide-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e( 'Hide password' ); ?>">
						<span class="dashicons dashicons-hidden"></span>
						<span class="text"><?php _e( 'Hide' ); ?></span>
					</button>
					<button type="button" class="button button-secondary wp-cancel-pw hide-if-no-js" data-toggle="0" aria-label="<?php esc_attr_e( 'Cancel password change' ); ?>">
						<span class="text"><?php _e( 'Cancel' ); ?></span>
					</button>
					<div style="display:none" id="pass-strength-result" aria-live="polite"></div>
				</div>
			</td>
		</tr>
		<tr class="user-pass2-wrap hide-if-js">
			<th scope="row"><label for="pass2"><?php _e( 'Repeat New Password' ); ?></label></th>
			<td>
				<input name="pass2" type="password" id="pass2" class="regular-text" value="" autocomplete="off" />
				<p class="description"><?php _e( 'Type your new password again.' ); ?></p>
			</td>
		</tr>
		<tr class="pw-weak">
			<th><?php _e( 'Confirm Password' ); ?></th>
			<td>
				<label>
					<input type="checkbox" name="pw_weak" class="pw-checkbox" />
					<?php _e( 'Confirm use of weak password' ); ?>
				</label>
			</td>
		</tr>
	</table>

<?php
}



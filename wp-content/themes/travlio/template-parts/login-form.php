<h3 class="title-account"><?php echo esc_html__('Login','travlio'); ?></h3>
<div class="form-acount" tabindex="-1" role="dialog">
	<div class="inner">
		<div id="apus_login_form" class="form-container">
			<form class="apus-login-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="post">
				<div class="form-group">
					<label class="hidden" for="username_or_email"><?php esc_html_e('Username Or Email', 'travlio'); ?></label>
	                <sup class="apus-required-field hidden">*</sup>
					<input autocomplete="off" type="text" name="username" class="form-control style2" id="username_or_email" placeholder="<?php esc_attr_e("Enter username or email",'travlio'); ?>">
				</div>
				<div class="form-group">
					<label class="hidden" for="login_password"><?php echo esc_html__("Password",'travlio'); ?></label>
	                <sup class="apus-required-field hidden">*</sup>
					<input name="password" type="password" class="password required form-control style2" id="login_password" placeholder="<?php esc_attr_e("Enter Password",'travlio'); ?>">
				</div>
				<div class="row flex-middle action-login form-group">
					<div class="col-sm-6">
						<label for="apus-user-remember">
							<input type="checkbox" name="remember" id="apus-user-remember" value="true">
							<span><?php echo esc_html__("Keep me signed in",'travlio'); ?></span>
						</label>
					</div>
					<div class="col-sm-6 text-right">
						<a href="#apus_forgot_password_form" class="back-link" title="<?php esc_attr_e("Forgot Password",'travlio'); ?>"><?php echo esc_html__("Lost Your Password?",'travlio'); ?></a>
					</div>
				</div>
				<div class="form-group clear-submit">
					<input type="submit" class="btn btn-second btn-block" name="submit" value="<?php esc_attr_e("Login",'travlio'); ?>"/>
				</div>
				<?php
					do_action('login_form');
					wp_nonce_field('ajax-apus-login-nonce', 'security_login');
				?>
			</form>

			<?php do_action('travlio_login_form'); ?>
		</div>
		<!-- reset form -->
		<div id="apus_forgot_password_form" class="form-container">
			<form name="forgotpasswordform" class="forgotpassword-form" action="<?php echo esc_url( site_url('wp-login.php?action=lostpassword', 'login_post') ); ?>" method="post">
				<h3 class="sub_title"><?php echo esc_html__('Reset Password', 'travlio'); ?></h3>
				<div class="lostpassword-fields">
					<div class="form-group">
						<label for="lostpassword_username" class="hidden"><?php echo esc_html__("Username or E-mail",'travlio'); ?></label>
                		<sup class="apus-required-field hidden">*</sup>
						<input type="text" name="user_login" class="user_login form-control style2" id="lostpassword_username" placeholder="<?php esc_attr_e("Username or E-mail",'travlio'); ?>">
					</div>
					<?php
						do_action('lostpassword_form');
						wp_nonce_field('ajax-apus-lostpassword-nonce', 'security_lostpassword');
					?>
					<div class="form-group">
						<input type="submit" class="btn btn-success btn-block" name="wp-submit" value="<?php esc_attr_e('Get New Password', 'travlio'); ?>" tabindex="100" />
						<input type="button" class="btn btn-danger btn-block btn-cancel" value="<?php esc_attr_e('Cancel', 'travlio'); ?>" tabindex="101" />
					</div>
				</div>
					<div class="lostpassword-link"><a href="#apus_login_form" class="back-link text-danger"><?php echo esc_html__('Back To Login', 'travlio'); ?></a></div>
			</form>
		</div>
	</div>
</div>
<div class="bottom-login text-center">
	<?php echo esc_html__('Don\'t have an account.','travlio') ?> <a class="apus-user-register change-action text-theme" href="#apus_register_form"><?php echo esc_html__('Register', 'travlio'); ?></a>
</div>
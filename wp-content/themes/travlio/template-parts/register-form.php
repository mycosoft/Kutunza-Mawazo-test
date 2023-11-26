<h3 class="title-account"><?php echo esc_html__('Register','travlio'); ?></h3>
<div class="form-register">
  <div class="inner">
  	<div class="container-form">
          <form name="apusRegisterForm" method="post" class="apus-register-form">
              <div id="apus-reg-loader-info" class="apus-loader hidden">
                  <span><?php esc_html_e('Please wait ...', 'travlio'); ?></span>
              </div>
              <div id="apus-register-alert" class="alert alert-danger" role="alert" style="display:none;"></div>
              <div id="apus-mail-alert" class="alert alert-danger" role="alert" style="display:none;"></div>

             	<div class="form-group">
                	<label class="hidden" for="username"><?php esc_html_e('Username', 'travlio'); ?></label>
                	<sup class="apus-required-field hidden">*</sup>
                	<input type="text" class="form-control style2" name="username" id="username" placeholder="<?php esc_attr_e("Enter Username",'travlio'); ?>">
            	</div>
            	<div class="form-group">
                	<label class="hidden" for="reg-email"><?php esc_html_e('Email', 'travlio'); ?></label>
                	<sup class="apus-required-field hidden">*</sup>
                	<input type="text" class="form-control style2" name="email" id="reg-email" placeholder="<?php esc_attr_e("Enter Email",'travlio'); ?>">
            	</div>
              <div class="form-group">
                  <label class="hidden" for="password"><?php esc_html_e('Password', 'travlio'); ?></label>
                  <sup class="apus-required-field hidden">*</sup>
                  <input type="password" class="form-control style2" name="password" id="password" placeholder="<?php esc_attr_e("Enter Password",'travlio'); ?>">
              </div>
              <div class="form-group space-bottom-30">
                  <label class="hidden" for="confirmpassword"><?php esc_html_e('Confirm Password', 'travlio'); ?></label>
                  <sup class="apus-required-field hidden">*</sup>
                  <input type="password" class="form-control style2" name="confirmpassword" id="confirmpassword" placeholder="<?php esc_attr_e("Confirm Password",'travlio'); ?>">
              </div>
              
              <?php wp_nonce_field('ajax-apus-register-nonce', 'security_register'); ?>

              <div class="form-group clear-submit">
                <button type="submit" class="btn btn-theme btn-block" name="submitRegister">
                    <?php echo esc_html__('Register now', 'travlio'); ?>
                </button>
              </div>

              <?php do_action('register_form'); ?>
          </form>
    </div>
	</div>
</div>
<div class="bottom-login text-center">
  <?php echo esc_html__('Already have an account?','travlio') ?> <a class="apus-user-login change-action text-theme" href="#apus_login_forgot_form"><?php echo esc_html__('Login', 'travlio'); ?></a>
</div>
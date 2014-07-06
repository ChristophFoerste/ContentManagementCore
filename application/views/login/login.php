<div class="col-xs-12 col-sm-4 col-sm-offset-4">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <strong><?php echo $this->lang->line('login_panel_head'); ?></strong>
        </div>
        <div class="panel-body">
            <form id="loginForm" action="<?php echo base_url(); ?>index.php/login/validate" data-baseURL="<?php echo base_url(); ?>">
                <div class="form-group" id="logoutMessage" style="display: <?php if(!$logout) echo "none"; ?>;">
                    <p class="bg-success text-center text-success"><?php echo $this->lang->line('login_message_logout'); ?></p>
                </div>
                <div class="form-group" id="loginFormErrorMessage" style="display: none;">
                    <p class="bg-danger text-center text-danger"><?php echo $this->lang->line('login_message_error'); ?></p>
                </div>
                <div class="form-group">
                    <label for="loginUsername"><?php echo $this->lang->line('login_form_labelUsername'); ?></label><br />
                    <input type="text" name="admin_username" id="loginUsername" class="form-control" placeholder="<?php echo $this->lang->line('login_form_placeholderUsername'); ?>" required />
                </div>
                <div class="form-group">
                    <label for="loginPassword"><?php echo $this->lang->line('login_form_labelPassword'); ?></label><br />
                    <div class="input-group">
                        <input type="password" name="admin_password" id="loginPassword" class="form-control" placeholder="<?php echo $this->lang->line('login_form_placeholderPassword'); ?>" required />
                        <span class="input-group-addon" id="loginPasswordSwitch" style="cursor: pointer;"><i class="fa fa-fw fa-eye-slash"></i></span>
                    </div>
                </div>
                <div class="checkbox">
                    <label class="pull-left" style="display: none;">
                        <input type="checkbox" name="admin_rememberLogin" value="true" /> <?php echo $this->lang->line('login_form_labelStayLoggedIn'); ?>
                    </label>
                    <a href="<?php echo base_url(); ?>login/lostPassword" class="pull-right"><?php echo $this->lang->line('login_form_labelLostPassword'); ?></a>
                </div>
                <div class="form-group">
                    <button type="button" name="submitLoginForm" class="btn btn-primary pull-right"><?php echo $this->lang->line('login_form_buttonLogin'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
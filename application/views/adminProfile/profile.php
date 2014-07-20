<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="page-header">
    <h3><?php echo $this->lang->line("adminProfile_head_mainPage").' <span class="admin-name">'.$admin->getFullname(); ?></span></h3>
</div>

<div class="row">
    <div class="col-sm-4 col-xs-12">
        <!--label for="authProfilePicture">Profilbild</label><br /-->
        <div style="cursor: pointer;">
            <form id="authProfileForm" action="" method="post" enctype="multipart/form-data" data-fileUpload="<?php echo base_url(); ?>index.php/adminProfile/uploadProfilePicture">
                <img id="authProfilePicture" src="<?php echo $profilePicturePath;?>" alt="" title="" class="img-responsive" />
            </form>
            <div class="dropzone-previews" style="display: none;"></div>
        </div>
        <br />
    </div>

    <div class="col-xs-12 col-sm-8">
        <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
            <li class="active"><a href="#authentication" data-toggle="tab"><?php echo $this->lang->line("adminProfile_tab_authentication"); ?></a></li>
            <!--li><a href="#settings" data-toggle="tab"><?php echo $this->lang->line("adminProfile_tab_settings"); ?></a></li-->
        </ul>
        <div id="my-tab-content" class="tab-content">
            <div class="tab-pane active" id="authentication">
                <form id="adminProfile_authenticationForm" action="<?php echo base_url(); ?>index.php/adminProfile/updateUser" >
                    <div class="row" style="margin-top: 15px;">
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="authGender"><?php echo $this->lang->line("adminProfile_label_gender"); ?></label><br />
                                        <?php
                                            $formData = 'id="authGender" class="form-control"';
                                            echo form_dropdown('admin_genderTypeID', $genderTypes, $user->admin_genderTypeID, $formData);
                                        ?>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="authLanguage"><?php echo $this->lang->line("adminProfile_label_language"); ?></label><br />
                                        <?php
                                            $formData = 'id="authLanguage" class="form-control"';
                                            echo form_dropdown('admin_languageID', $languages, $user->admin_languageID, $formData);
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="authFirstname"><?php echo $this->lang->line("adminProfile_label_firstname"); ?></label><br />
                                        <?php echo form_input(array(
                                            'name'          => 'admin_firstname',
                                            'id'            => 'authFirstname',
                                            'value'         => $user->admin_firstname,
                                            'maxlength'     => 25,
                                            'class'         => 'form-control',
                                            'type'          => 'text'
                                        )); ?>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="authLastname"><?php echo $this->lang->line("adminProfile_label_lastname"); ?></label><br />
                                        <?php echo form_input(array(
                                            'name'          => 'admin_lastname',
                                            'id'            => 'authLastname',
                                            'value'         => $user->admin_lastname,
                                            'maxlength'     => 25,
                                            'class'         => 'form-control',
                                            'type'          => 'text'
                                        )); ?>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="authUsername"><?php echo $this->lang->line("adminProfile_label_username"); ?></label><br />
                                        <?php echo form_input(array(
                                            'name'          => 'admin_username',
                                            'id'            => 'authUsername',
                                            'value'         => $user->admin_username,
                                            'maxlength'     => 25,
                                            'class'         => 'form-control',
                                            'type'          => 'text',
                                            'disabled'      => 'disabled'
                                        )); ?>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="authPassword"><?php echo $this->lang->line("adminProfile_label_password"); ?></label><br />
                                        <div class="input-group">
                                            <?php echo form_input(array(
                                                'name'          => 'admin_password',
                                                'id'            => 'authPassword',
                                                'value'         => $user->admin_password,
                                                'maxlength'     => 50,
                                                'class'         => 'form-control',
                                                'type'          => 'password'
                                            )); ?>
                                            <span class="input-group-addon" id="profilePasswordSwitch" style="cursor: pointer;"><i class="fa fa-fw fa-eye-slash"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="authEmail"><?php echo $this->lang->line("adminProfile_label_email"); ?></label><br />
                                        <div class="input-group">
                                            <?php echo form_input(array(
                                                'name'          => 'admin_email',
                                                'id'            => 'authEmail',
                                                'value'         => $user->admin_email,
                                                'maxlength'     => 100,
                                                'class'         => 'form-control',
                                                'type'          => 'text'
                                            )); ?>
                                            <span class="input-group-addon"><i class="fa fa-fw fa-envelope"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <button type="button" name="authSubmitButton" class="btn btn-primary pull-right" disabled="disabled"><?php echo $this->lang->line("adminProfile_button_safe"); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane" id="settings">

            </div>
        </div>
    </div>
</div>
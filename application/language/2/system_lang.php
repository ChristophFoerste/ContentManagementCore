<?php
//header
$lang['system_header']                                      = 'System-Extensions';

//options
$lang['system_option_backup']                               = 'Create Backups';
$lang['system_option_installPlugin']                        = 'Add / Update Extensions';
$lang['system_option_activePlugins']                        = '(De-)Active Extensions';

//hints
$lang['system_hint_backup']                                 = 'Create a backup of a special plugin. This is recommended before installing a newer version of a plugin.';
$lang['system_hint_installPlugin']                          = 'Install or update an existing plugin by uploading a *zip-file. Plugins will be overwritten by the new installation.';
$lang['system_hint_activePlugins']                          = 'Show a list of installed plugins. The Popup allows you to deactivate or activate some of the installed extensions.';
$lang['system_hint_pluginBackupCreated']                    = 'The backup of the extension was created successfully';

//errors
$lang['system_error_pluginBackupCreated']                   = 'The backup of the extension could not be created';
$lang['system_error_pluginBackupNumberOfFilesExceed']       = 'The backup of the extension could not be created. The maximum of backups is reached.';

//buttons
$lang['system_button_backup']                               = 'Create backup';
$lang['system_button_installPlugin']                        = 'Install plugin';
$lang['system_button_activePlugins']                        = 'Show list of extensions';

//dialog backup plugin
$lang['system_dialog_pluginBackup_dialogTitle']             = 'Create Backup';
$lang['system_dialog_pluginBackup_actionDescription']       = 'After selecting a plugin and clicking the "create Backu"-button, a backup with current timestamp will be stored on the server.';
$lang['system_dialog_pluginBackup_buttonLabelCancel']       = 'Cancel';
$lang['system_dialog_pluginBackup_buttonLabelSave']         = 'Create backup';
$lang['system_dialog_pluginBackup_labelExtension']          = 'Extension';

//dialog (de-)activate plugins
$lang['system_dialog_pluginActivate_dialogTitle']           = '(De-)Activate Extension';
$lang['system_dialog_pluginActivate_buttonLabelCancel']     = 'Cancel';
$lang['system_dialog_pluginActivate_buttonLabelSave']       = 'Save';

//dialog install plugin
$lang['system_dialog_pluginInstallation_dialogTitle']       = 'Install Plugin';
$lang['system_dialog_pluginInstallation_actionDescription'] = 'After selecting a plugin and clicking the "create Backu"-button, the selected *.zip-file will be uploaded and installed to the server ';
$lang['system_dialog_pluginInstallation_buttonLabelChoose'] = 'Select file';
$lang['system_dialog_pluginInstallation_buttonLabelSave']   = 'Install';
$lang['system_dialog_pluginInstallation_buttonLabelCancel'] = 'Cancel';

?>
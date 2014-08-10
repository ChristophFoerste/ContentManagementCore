<?php
//header
$lang['system_header']                                              = 'System-Erweiterungen';

//options
$lang['system_option_backup']                                       = 'Backup erstellen';
$lang['system_option_installPlugin']                                = 'hinzufügen / aktualisieren';
$lang['system_option_activePlugins']                                = '(de-)aktivieren';

//hints
$lang['system_hint_backup']                                         = 'Erstellung eines Backups einer Erweiterung. Dies sollte vor der Installation einer neuen Erweiterung oder einer Aktualisierung durchgeführt werden.';
$lang['system_hint_installPlugin']                                  = 'Spielen Sie hier eine neue Erweiterung ein oder aktualisieren Sie eine bereits bestehende. Aktualisierungen überschreiben Erweiterungen.';
$lang['system_hint_activePlugins']                                  = 'Zeigt eine Liste installierter Erweiterungen. Das Popup erlaubt das (De-)Aktivieren einer oder mehrerer der Erweiterungen.';
$lang['system_hint_pluginBackupCreated']                            = 'Die Sicherung der Erweiterung wurde erstellt';

//errors
$lang['system_error_pluginBackupCreated']                           = 'Das Backup konnte nicht erstellt werden';
$lang['system_error_pluginBackupNumberOfFilesExceed']               = 'Das Backup konnte nicht erstellt werden, da die maximal mögliche Anzahl an Backups für dieses System erreicht wurde.';

//buttons
$lang['system_button_backup']                                       = 'Backup erstellen';
$lang['system_button_installPlugin']                                = 'Erweiterung einspielen';
$lang['system_button_activePlugins']                                = 'Erweiterungen (de-)aktivieren';

//dialog backup plugins
$lang['system_dialog_pluginBackup_dialogTitle']                     = 'Backup erstellen';
$lang['system_dialog_pluginBackup_actionDescription']               = 'Nach Auswahl der Erweiterung und einem Klick auf die "Backup erstellen"-Schaltfläche, wird eine Sicherung der Erweiterung mit Angabe des Datums und der Uhrzeit auf dem Server hinterlegt.';
$lang['system_dialog_pluginBackup_buttonLabelCancel']               = 'abbrechen';
$lang['system_dialog_pluginBackup_buttonLabelSave']                 = 'Backup erstellen';
$lang['system_dialog_pluginBackup_labelExtension']                  = 'Erweiterung';

//dialog (de-)activate plugins
$lang['system_dialog_pluginActivate_dialogTitle']                   = 'Erweiterung (de-)aktivieren';
$lang['system_dialog_pluginActivate_buttonLabelCancel']             = 'abbrechen';
$lang['system_dialog_pluginActivate_buttonLabelSave']               = 'speichern';

//dialog install plugin
$lang['system_dialog_pluginInstallation_dialogTitle']               = 'Erweiterung installieren';
$lang['system_dialog_pluginInstallation_actionDescription']         = 'Nach Auswahl der Erweiterung wird die ausgewählte *.zip-Datei auf den Server geladen und installiert.';
$lang['system_dialog_pluginInstallation_buttonLabelChoose']         = 'Datei auswählen';
$lang['system_dialog_pluginInstallation_buttonLabelClose']          = 'schließen';
$lang['system_dialog_pluginInstallation_buttonLabelCancel']         = 'abbrechen';

//dialog install plugin error-/successMessages
$lang['system_dialog_pluginInstallation_errorCantOpenZIP']          = 'ZIP-Archiv konnte nicht geöffnet werden.';
$lang['system_dialog_pluginInstallation_errorCantUploadFile']       = 'Datei konnte nicht hochgeladen werden';
$lang['system_dialog_pluginInstallation_successPluginInstalled']    = 'Die Erweiterung wurde erfolgreich installiert.';

?>
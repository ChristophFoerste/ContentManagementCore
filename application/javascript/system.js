$(document).ready(function(){
    $('button[name=pluginBackup]').click(function(){
        var $this = $(this);
        Application.Dialog.Alert($this, $this.attr('data-dialogTitle'), $this.attr('data-dialogMessage'), $this.attr('data-buttonLabel'));
    });
});
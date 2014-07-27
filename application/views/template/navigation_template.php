<nav id="topNavigation" class="navbar navbar-default navbar-inverse" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo base_url(); ?>index.php"><?php echo $this->config->item("projectName"); ?></a>
    </div>
    <?php if($admin != NULL && $admin->isLoggedIn) { ?>
    <div class="collapse navbar-collapse" id="navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fw <?php echo $currentPlugin->plugin_fontawesomeIcon; ?>"></i> <?php echo $currentPlugin->pluginDescription_name; ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <?php
                        $pluginManager = new \System\Plugin\Manager();
                        foreach($availablePlugins as $plugin) {
                            if($pluginManager->isPluginAvailable($plugin->plugin_systemName, $admin->languageID)){// && $admin->hasPermission($plugin->plugin_requiredPermission)) {
                                $listClass = "";
                                if($plugin->plugin_systemName === $currentPlugin) {
                                    $listClass = "class=\"active\"";
                                }
                                ?>
                                    <li <?php echo $listClass; ?>><a href="<?php echo base_url(); ?>index.php/<?php echo $plugin->plugin_systemName; ?>"><i class="fa fa-fw <?php echo $plugin->plugin_fontawesomeIcon;?>"></i> <?php echo $plugin->pluginDescription_name; ?></a></li>
                                <?php
                            }
                        }
                    ?>
                </ul>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-fw fa-user"></i> <?php echo $admin->getFullname(); ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo base_url(); ?>index.php/adminprofile"><?php echo $this->lang->line('application_plugin_adminProfile'); ?></a></li>
                    <li class="divider"></li>
                    <li><a href="<?php echo base_url(); ?>index.php/login/logout"><?php echo $this->lang->line('application_navigation_userLogout'); ?></a></li>
                </ul>
            </li>
        </ul>
    </div>
    <?php } ?>
</nav>

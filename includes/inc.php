<?php

include( 'elementor/kando_elementor.php' );
include( 'classes/smartPanelApi.php' );
include( 'classes/Number2Word.php' );
include( 'classes/recently-registered.php' );

include( 'builder/footer.php' );
include( 'builder/header.php' );

require_once get_parent_theme_file_path( '/includes/tgmpa/class-tgm-plugin-activation.php' );

require_once get_parent_theme_file_path( '/includes/merlin/vendor/autoload.php' );
require_once get_parent_theme_file_path( '/includes/merlin/class-merlin.php' );
require_once get_parent_theme_file_path( '/includes/merlin-config.php' );
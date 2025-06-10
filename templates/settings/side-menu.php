<?php
defined('ABSPATH') || exit('No Access!');
?>
<ul class="uk-list uk-list-divider">
    <li class="samyar-menu-item samyar-theme-name">
        <img src="<?php echo SAMYAR_DIR_IMG . '/icon/cando.png'; ?>" alt="logo">
        <strong class="samyar-theme-name"><?php _e('Kandopanel Theme', SAMYAR_TEXT_DOMAIN); ?></strong>
        <br>
        <span class="samyar-version"><?php echo __('Version', SAMYAR_TEXT_DOMAIN) . ' ' . SAMYAR_THEME_VER; ?></span>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="general">
            <span class="samyar-menu-icon" uk-icon="settings"></span>
            <div class="samyar-menu-title"><?php _e('General', SAMYAR_TEXT_DOMAIN); ?></div>
            <div class="samyar-menu-description"><?php _e('Basic plugin settings', SAMYAR_TEXT_DOMAIN); ?></div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="auth">
            <span class="samyar-menu-icon" uk-icon="user"></span>
            <div class="samyar-menu-title"><?php _e('Auth', SAMYAR_TEXT_DOMAIN); ?></div>
            <div class="samyar-menu-description"><?php _e('Auth settings', SAMYAR_TEXT_DOMAIN); ?></div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="gateways">
            <span class="samyar-menu-icon" uk-icon="credit-card"></span>
            <div class="samyar-menu-title"><?php _e('Gateways', SAMYAR_TEXT_DOMAIN); ?></div>
            <div class="samyar-menu-description"><?php _e('Gateways Payments', SAMYAR_TEXT_DOMAIN); ?></div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="dashboard">
            <span class="samyar-menu-icon" uk-icon="home"></span>
            <div class="samyar-menu-title"><?php _e('Dashboard', SAMYAR_TEXT_DOMAIN); ?></div>
            <div class="samyar-menu-description"><?php _e('Dashboard settings', SAMYAR_TEXT_DOMAIN); ?></div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="currency">
            <span class="samyar-menu-icon" uk-icon="world"></span>
            <div class="samyar-menu-title"><?php _e('Currency', SAMYAR_TEXT_DOMAIN); ?></div>
            <div class="samyar-menu-description"><?php _e('Profit and currency conversion', SAMYAR_TEXT_DOMAIN); ?></div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="cron">
            <span class="samyar-menu-icon" uk-icon="future"></span>
            <div class="samyar-menu-title"><?php _e('Cronjob', SAMYAR_TEXT_DOMAIN); ?></div>
            <div class="samyar-menu-description"><?php _e('Cronjob settings', SAMYAR_TEXT_DOMAIN); ?></div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="packages">
            <span class="samyar-menu-icon" uk-icon="credit-card"></span>
            <div class="samyar-menu-title"><?php _e('Packages and Profits', SAMYAR_TEXT_DOMAIN); ?></div>
            <div class="samyar-menu-description"><?php _e('Representation and profits', SAMYAR_TEXT_DOMAIN); ?></div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="services">
            <span class="samyar-menu-icon" uk-icon="menu"></span>
            <div class="samyar-menu-title"><?php _e('Services', SAMYAR_TEXT_DOMAIN); ?></div>
            <div class="samyar-menu-description"><?php _e('Services settings', SAMYAR_TEXT_DOMAIN); ?></div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="order">
            <span class="samyar-menu-icon" uk-icon="cart"></span>
            <div class="samyar-menu-title"><?php _e('Order', SAMYAR_TEXT_DOMAIN); ?></div>
            <div class="samyar-menu-description"><?php _e('Order settings', SAMYAR_TEXT_DOMAIN); ?></div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="header-notification">
            <span class="samyar-menu-icon" uk-icon="bell"></span>
            <div class="samyar-menu-title"><?php _e('Header Notification', SAMYAR_TEXT_DOMAIN); ?></div>
            <div class="samyar-menu-description"><?php _e('Header notification settings', SAMYAR_TEXT_DOMAIN); ?></div>
        </a>
    </li>

    <li class="samyar-menu-item">
        <a href="#" data-toggle="ticket">
            <span class="samyar-menu-icon" uk-icon="lifesaver"></span>
            <div class="samyar-menu-title"><?php _e('Ticket Settings', SAMYAR_TEXT_DOMAIN); ?></div>
            <div class="samyar-menu-description"><?php _e('Ticket Settings', SAMYAR_TEXT_DOMAIN); ?></div>
        </a>
    </li>

    <li class="samyar-menu-item">
        <a href="#" data-toggle="sms">
            <span class="samyar-menu-icon" uk-icon="phone"></span>
            <div class="samyar-menu-title"><?php _e('SMS', SAMYAR_TEXT_DOMAIN); ?></div>
            <div class="samyar-menu-description"><?php _e('SMS settings', SAMYAR_TEXT_DOMAIN); ?></div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="email">
            <span class="samyar-menu-icon" uk-icon="mail"></span>
            <div class="samyar-menu-title"><?php _e('EMAIL', SAMYAR_TEXT_DOMAIN); ?></div>
            <div class="samyar-menu-description"><?php _e('Email settings', SAMYAR_TEXT_DOMAIN); ?></div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="api">
            <span class="samyar-menu-icon" uk-icon="api"></span>
            <div class="samyar-menu-title"><?php _e('API Settings', SAMYAR_TEXT_DOMAIN); ?></div>
            <div class="samyar-menu-description"><?php _e('API Settings', SAMYAR_TEXT_DOMAIN); ?></div>
        </a>
    </li>
    <!--    <li class="samyar-menu-item">-->
    <!--        <a href="#" data-toggle="styles">-->
    <!--            <span class="samyar-menu-icon" uk-icon="paint-bucket"></span>-->
    <!--            <div class="samyar-menu-title">--><?php //_e('Styles', SAMYAR_TEXT_DOMAIN); ?><!--</div>-->
    <!--            <div class="samyar-menu-description">--><?php //_e('Color, fonts and more...', SAMYAR_TEXT_DOMAIN); ?><!--</div>-->
    <!--        </a>-->
    <!--    </li>-->

    <li class="samyar-menu-item">
        <a href="#" data-toggle="sync">
            <span class="samyar-menu-icon" uk-icon="refresh"></span>
            <div class="samyar-menu-title"><?php _e('Sync', SAMYAR_TEXT_DOMAIN); ?></div>
            <div class="samyar-menu-description"><?php _e('Auto-sync settings', SAMYAR_TEXT_DOMAIN); ?></div>
        </a>
    </li>

    <li class="samyar-menu-item">
        <a href="#" data-toggle="float-buttons">
            <span class="samyar-menu-icon" uk-icon="refresh"></span>
            <div class="samyar-menu-title"><?php _e('Float Buttons', SAMYAR_TEXT_DOMAIN); ?></div>
            <div class="samyar-menu-description"><?php _e('Float Buttons settings', SAMYAR_TEXT_DOMAIN); ?></div>
        </a>
    </li>

    <li class="samyar-menu-item">
        <a href="#" data-toggle="remove">
            <span class="samyar-menu-icon" uk-icon="trash"></span>
            <div class="samyar-menu-title"><?php _e('Remove Info', SAMYAR_TEXT_DOMAIN); ?></div>
            <div class="samyar-menu-description"><?php _e('Data cleanup', SAMYAR_TEXT_DOMAIN); ?></div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="minor-cleaning">
            <span class="samyar-menu-icon" uk-icon="trash"></span>
            <div class="samyar-menu-title"><?php _e('Minor Data Cleanup', SAMYAR_TEXT_DOMAIN); ?></div>
            <div class="samyar-menu-description"><?php _e('Partial data cleanup', SAMYAR_TEXT_DOMAIN); ?></div>
        </a>
    </li>
    <?php do_action('kando_add_settings_menu') ?>

    <li class="samyar-menu-item">
        <a href="#" data-toggle="spsync">
            <span class="samyar-menu-icon" uk-icon="refresh"></span>
            <div class="samyar-menu-title"><?php _e('Smartpanel Sync', SAMYAR_TEXT_DOMAIN); ?></div>
            <div class="samyar-menu-description"><?php _e('Smartpanel user sync', SAMYAR_TEXT_DOMAIN); ?></div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="help">
            <span class="samyar-menu-icon" uk-icon="lifesaver"></span>
            <div class="samyar-menu-title"><?php _e('Help', SAMYAR_TEXT_DOMAIN); ?></div>
            <div class="samyar-menu-description"><?php _e('Kandopanel Help', SAMYAR_TEXT_DOMAIN); ?></div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="info">
            <span class="samyar-menu-icon" uk-icon="info"></span>
            <div class="samyar-menu-title"><?php _e('Info and Plugins', SAMYAR_TEXT_DOMAIN); ?></div>
            <div class="samyar-menu-description"><?php _e('Info and Plugins', SAMYAR_TEXT_DOMAIN); ?></div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="backup">
            <span class="samyar-menu-icon" uk-icon="database"></span>
            <div class="samyar-menu-title"><?php _e('Backup Settings', SAMYAR_TEXT_DOMAIN); ?></div>
            <div class="samyar-menu-description"><?php _e('Export and import settings', SAMYAR_TEXT_DOMAIN); ?></div>
        </a>
    </li>
</ul>
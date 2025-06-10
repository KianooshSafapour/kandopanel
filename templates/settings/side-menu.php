<?php
defined('ABSPATH') || exit('No Access!');
?>
<ul class="uk-list uk-list-divider">
    <li class="samyar-menu-item samyar-theme-name">
        <img src="<?php echo SAMYAR_DIR_IMG . '/icon/cando.png'; ?>" alt="logo">
        <strong class="samyar-theme-name">پوسته کندوپنل</strong>
        <br>
        <span class="samyar-version"><?php echo __( 'version', SAMYAR_TEXT_DOMAIN ) . ' ' . SAMYAR_THEME_VER; ?></span>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="general">
            <span class="samyar-menu-icon" uk-icon="settings"></span>
            <div class="samyar-menu-title"><?php _e( 'General', SAMYAR_TEXT_DOMAIN ); ?></div>
            <div class="samyar-menu-description"><?php _e( 'Basic plugin settings', SAMYAR_TEXT_DOMAIN ); ?></div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="auth">
            <span class="samyar-menu-icon" uk-icon="user"></span>
            <div class="samyar-menu-title"><?php _e( 'auth', SAMYAR_TEXT_DOMAIN ); ?></div>
            <div class="samyar-menu-description"><?php _e( 'auth settings', SAMYAR_TEXT_DOMAIN ); ?></div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="currency">
            <span class="samyar-menu-icon" uk-icon="world"></span>
            <div class="samyar-menu-title"><?php _e( 'currency', SAMYAR_TEXT_DOMAIN ); ?></div>
            <div class="samyar-menu-description">تبدیل سود و نرخ ارز</div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="representation">
            <span class="samyar-menu-icon" uk-icon="credit-card"></span>
            <div class="samyar-menu-title"><?php _e( 'representation and profits', SAMYAR_TEXT_DOMAIN ); ?></div>
            <div class="samyar-menu-description">نمایندگی و سودها</div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="gateways">
            <span class="samyar-menu-icon" uk-icon="credit-card"></span>
            <div class="samyar-menu-title"><?php _e( 'gateways', SAMYAR_TEXT_DOMAIN ); ?></div>
            <div class="samyar-menu-description"><?php _e( 'Gateways Payments', SAMYAR_TEXT_DOMAIN ); ?></div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="dashboard">
            <span class="samyar-menu-icon" uk-icon="home"></span>
            <div class="samyar-menu-title"><?php _e( 'Dashboard', SAMYAR_TEXT_DOMAIN ); ?></div>
            <div class="samyar-menu-description"><?php _e( 'Dashboard settings', SAMYAR_TEXT_DOMAIN ); ?></div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="services">
            <span class="samyar-menu-icon" uk-icon="menu"></span>
            <div class="samyar-menu-title"><?php _e( 'Services', SAMYAR_TEXT_DOMAIN ); ?></div>
            <div class="samyar-menu-description"><?php _e( 'Services settings', SAMYAR_TEXT_DOMAIN ); ?></div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="order">
            <span class="samyar-menu-icon" uk-icon="cart"></span>
            <div class="samyar-menu-title"><?php _e( 'Order', SAMYAR_TEXT_DOMAIN ); ?></div>
            <div class="samyar-menu-description"><?php _e( 'Order settings', SAMYAR_TEXT_DOMAIN ); ?></div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="header-notification">
            <span class="samyar-menu-icon" uk-icon="bell"></span>
            <div class="samyar-menu-title">اطلاعیه هدر</div>
            <div class="samyar-menu-description">تنظیمات اطلاعیه هدر</div>
        </a>
    </li>

    <li class="samyar-menu-item">
        <a href="#" data-toggle="ticket">
            <span class="samyar-menu-icon" uk-icon="lifesaver"></span>
            <div class="samyar-menu-title"><?php _e( 'Ticket Settings', SAMYAR_TEXT_DOMAIN ); ?></div>
            <div class="samyar-menu-description"><?php _e( 'Ticket Settings', SAMYAR_TEXT_DOMAIN ); ?></div>
        </a>
    </li>

    <li class="samyar-menu-item">
        <a href="#" data-toggle="sms">
            <span class="samyar-menu-icon" uk-icon="phone"></span>
            <div class="samyar-menu-title"><?php _e( 'SMS', SAMYAR_TEXT_DOMAIN ); ?></div>
            <div class="samyar-menu-description"><?php _e( 'SMS settings', SAMYAR_TEXT_DOMAIN ); ?></div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="email">
            <span class="samyar-menu-icon" uk-icon="mail"></span>
            <div class="samyar-menu-title"><?php _e( 'EMAIL', SAMYAR_TEXT_DOMAIN ); ?></div>
            <div class="samyar-menu-description"><?php _e( 'Email settings', SAMYAR_TEXT_DOMAIN ); ?></div>
        </a>
    </li>
<!--    <li class="samyar-menu-item">-->
<!--        <a href="#" data-toggle="styles">-->
<!--            <span class="samyar-menu-icon" uk-icon="paint-bucket"></span>-->
<!--            <div class="samyar-menu-title">--><?php //_e( 'Styles', SAMYAR_TEXT_DOMAIN ); ?><!--</div>-->
<!--            <div class="samyar-menu-description">--><?php //_e( 'Color, fonts and more...', SAMYAR_TEXT_DOMAIN ); ?><!--</div>-->
<!--        </a>-->
<!--    </li>-->

    <li class="samyar-menu-item">
        <a href="#" data-toggle="sync">
            <span class="samyar-menu-icon" uk-icon="refresh"></span>
            <div class="samyar-menu-title"><?php _e( 'Sync', SAMYAR_TEXT_DOMAIN ); ?></div>
            <div class="samyar-menu-description">تنظیمات همگامسازی خودکار</div>
        </a>
    </li>


    <li class="samyar-menu-item">
        <a href="#" data-toggle="cron">
            <span class="samyar-menu-icon" uk-icon="future"></span>
            <div class="samyar-menu-title"><?php _e( 'cronjob', SAMYAR_TEXT_DOMAIN ); ?></div>
            <div class="samyar-menu-description">تنظیمات کرون جاب</div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="remove">
            <span class="samyar-menu-icon" uk-icon="trash"></span>
            <div class="samyar-menu-title"><?php _e( 'remove info', SAMYAR_TEXT_DOMAIN ); ?></div>
            <div class="samyar-menu-description">پاکسازی اطلاعات</div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="minor-cleaning">
            <span class="samyar-menu-icon" uk-icon="trash"></span>
            <div class="samyar-menu-title">پاکسازی جزیی اطلاعات</div>
            <div class="samyar-menu-description">پاکسازی با جزببات</div>
        </a>
    </li>
    <?php do_action( 'kando_add_settings_menu') ?>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="help">
            <span class="samyar-menu-icon" uk-icon="lifesaver"></span>
            <div class="samyar-menu-title"><?php _e( 'Help', SAMYAR_TEXT_DOMAIN ); ?></div>
            <div class="samyar-menu-description"><?php _e( 'Kandopanel Help', SAMYAR_TEXT_DOMAIN ); ?></div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="info">
            <span class="samyar-menu-icon" uk-icon="info"></span>
            <div class="samyar-menu-title"><?php _e( 'info and plugins', SAMYAR_TEXT_DOMAIN ); ?></div>
            <div class="samyar-menu-description"><?php _e( 'info and plugins', SAMYAR_TEXT_DOMAIN ); ?></div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="spsync">
            <span class="samyar-menu-icon" uk-icon="refresh"></span>
            <div class="samyar-menu-title"><?php _e( 'smartpanel sync', SAMYAR_TEXT_DOMAIN ); ?></div>
            <div class="samyar-menu-description">همگامسازی کاربران اسمارت پنل</div>
        </a>
    </li>
    <li class="samyar-menu-item">
        <a href="#" data-toggle="backup">
            <span class="samyar-menu-icon" uk-icon="database"></span>
            <div class="samyar-menu-title"><?php _e( 'backup settings', SAMYAR_TEXT_DOMAIN ); ?></div>
            <div class="samyar-menu-description">برونبری و درونریزی تنظیمات</div>
        </a>
    </li>
</ul>
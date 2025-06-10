<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

$action = "";
$section = "";
if ( isset( $_GET['action'] ) ) {
	$action = $_GET['action'];
} else {
	$action = "dashboard";
}

if ( isset( $_GET['section'] ) ) {
	$section = $_GET['section'];
}
?>
<?php
$menus = kandopanel_menu_list();

foreach ($menus as $menu) {
    $action = isset($action) && !empty($action) ? $action : "dashboard";//اگر هیچ اکشنی نبود داشبرد هست
    $section = isset($section) && !empty($section) ? $section : "";//اگر هیچ سکشنی نبود خالی بزار
        if ($menu['enable']) {
            if ($menu['for_admin'] == 0 || ($menu['for_admin'] == 1 && kando_user_can($menu['access_key']))) {// اگر برای کاربر باشه یا برای مدیر باشه و کاربر هم مدیر باشه

                ?>
                <li <?php if (($action === $menu['action']) && ($section === $menu['section'])) : echo 'class="is-active"'; endif ?>>
                    <a href="<?= $menu['link'] ?>" data-wpel-link="internal"><?= $menu['name'] ?><?php if(isset($menu['numbers']) && $menu['numbers']>0 && samyar_is_admin()):?><span class="button button-default badge-error-orders"><?php echo $menu['numbers']; ?></span><?php endif; ?></a>
                </li>
            <?php }
        }

} ?>
<div class="tickets-navigation">
    <!--	<span class="button button-default">--><?php //echo $title ?><!--</span>-->


    <?php if (kando_user_can('send_ticket_to_user')) { ?>
        <a href="<?php echo esc_attr(home_url('dashboard/?action=tickets&section=new')) ?>"
           class="button button-light" data-wpel-link="internal"><?php _e("Send ticket", SAMYAR_TEXT_DOMAIN); ?></a>
    <?php } ?>

    <?php if (kando_is_normal_user()) { ?>
        <a href="<?php echo esc_attr(home_url('dashboard/?action=tickets&section=new')) ?>" class="button button-light"
           data-wpel-link="internal"><?php _e("Send ticket", SAMYAR_TEXT_DOMAIN); ?></a>
    <?php } ?>

    <?php if (kando_user_can('delete_update_ticket_message')) { ?>
        <?php if (isset($_GET['section']) && ($_GET['section'] === "answered" || $_GET['section'] === "closed")): ?>
            <a href="<?php echo esc_attr(home_url('dashboard/?action=tickets')) ?>"><span
                        class="button button-orange"><?php _e("Go to tickets pending response", SAMYAR_TEXT_DOMAIN); ?></span></a>
        <?php endif; ?>

        <?php if ((isset($_GET['section']) && ($_GET['section'] === "waiting" || $_GET['section'] === "closed")) || !isset($_GET['section'])): ?>
            <a href="<?php echo esc_attr(home_url('dashboard/?action=tickets&section=answered')) ?>"><span
                        class="button button-green"><?php _e("Go to answered tickets", SAMYAR_TEXT_DOMAIN); ?></span></a>
        <?php endif; ?>

        <?php if ((isset($_GET['section']) && ($_GET['section'] === "answered" || $_GET['section'] === "waiting")) || !isset($_GET['section'])): ?>
            <a href="<?php echo esc_attr(home_url('dashboard/?action=tickets&section=closed')) ?>"><span
                        class="button button-red"><?php _e("Go to closed tickets", SAMYAR_TEXT_DOMAIN); ?></span></a>
        <?php endif; ?>

        <a href="#" class="button button-blue kando-show-tickets-filter"
           data-wpel-link="internal"><?php _e("Filter", SAMYAR_TEXT_DOMAIN); ?></a>
    <?php } ?>


</div>
<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Order;
use samyar\Provider;
use samyar\Service;

?>

<?php
$options = settingsController::getInstance();
$enable_average_time = kando_get_option( 'enable-average-time',1);
$top_services = (new Service())->get_top_services();
?>
<div class="dashboard-posts-box dashboard-tickets-box">
    <div class="dashboard-posts-title-holder">
        <h5 class="dashboard-posts-title"><?php _e('Popular Services', SAMYAR_TEXT_DOMAIN); ?></h5>
    </div>
    <div class="dashboard-posts-list">
        <?php
        if (count($top_services) > 0):
            ?>

            <table class="shop_table shop_table_responsive">
                <thead>
                <tr>
                    <?php if(samyar_is_admin()): ?>
                        <th id="cb">
                            <input type="checkbox" value="1" class="kando-cb-checkbox" id="cb-select-all-1" name="cb-select-all-1">
                            <label class="kando-cb-label" for="cb-select-all-1"></label>
                        </th>
                    <?php endif; ?>
                    <th><span class="nobr"><?php _e('ID', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e('Name', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e('Description', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <?php if (samyar_is_admin()): ?>
                        <th><span class="nobr"><?php _e('Original Price', SAMYAR_TEXT_DOMAIN); ?></span></th>
                        <th><span class="nobr"><?php _e('Type', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <?php endif; ?>
                    <th><span class="nobr"><?php _e('Price per 1000', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e('Min/Max', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <?php if($enable_average_time==1){ ?>
                        <th><span class="nobr"><?php _e('Estimated Completion Time', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <?php } ?>
                    <th><span class="nobr"><?php _e('Status', SAMYAR_TEXT_DOMAIN); ?></span></th>

                    <th><span class="nobr"><?php _e('Actions', SAMYAR_TEXT_DOMAIN); ?></span></th>

                </tr>
                </thead>

                <tbody>

                <?php
                foreach ($top_services as $service):
                    include('../services/service.php');
                endforeach; ?>
                </tbody>
            </table>
        <?php
        else:
            ?>
            <span class="services-notfound"><?php _e('No services have been added yet.', SAMYAR_TEXT_DOMAIN); ?></span>
        <?php
        endif;
        ?>
    </div>
</div>
<script>
    jQuery(document).ready(function ($) {
        $(document).on("mouseover", ".custom-popup", function () {
            $(this).find('.popuptext').css("visibility", "visible");
            $(this).find('.popuptext').css("-webkit-animation", "fadeIn 1s");
            $(this).find('.popuptext').css("animation", "fadeIn 1s");
        });

        $(".custom-popup").mouseout(function(){
            $(this).find('.popuptext').css("visibility", "hidden");
            $(this).find('.popuptext').css("-webkit-animation", "fadeOut 1s");
            $(this).find('.popuptext').css("animation", "fadeOut 1s");
        });
    });

</script>
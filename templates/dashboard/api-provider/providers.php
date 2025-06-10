<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Provider;

?>
<div class="kando-buttons-wrapper">
    <!--    <span class="button button-default">API Providers</span>-->
    <a href="<?php echo esc_attr(home_url('dashboard/?action=providers&section=new')) ?>"
       class="button button-light add-api-provider" data-wpel-link="internal"><?php _e('Add Provider', SAMYAR_TEXT_DOMAIN); ?></a>

    <a href="<?php echo esc_attr(home_url('dashboard/?action=providers&section=new-service')) ?>"
       class="button button-light add-api-provider" data-wpel-link="internal"><?php _e('New Services', SAMYAR_TEXT_DOMAIN); ?></a>


    <a href="<?php echo esc_attr(home_url('dashboard/?action=providers&active=0')) ?>"
        class="button button-red" data-wpel-link="internal"><?php _e('Inactive Providers', SAMYAR_TEXT_DOMAIN); ?></a>
    <a href="<?php echo esc_attr(home_url('dashboard/?action=providers&active=1')) ?>"
        class="button button-green" data-wpel-link="internal"><?php _e('Active Providers', SAMYAR_TEXT_DOMAIN); ?></a>

</div>
<div class="dashboard-posts-box dashboard-tickets-box">
    <div class="dashboard-posts-title-holder">
        <i class="elegant-icon icon_link"></i>
        <h5 class="dashboard-posts-title"><?php _e('API Providers', SAMYAR_TEXT_DOMAIN); ?></h5>
    </div>
    <div class="dashboard-posts-list">
        <?php
        // * paginate
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;//Current page number

        $user_id = get_current_user_id();
        $items_per_page = get_user_meta($user_id, 'items_per_page', true);
        $items_per_page = $items_per_page ?: 30; // Default value 10


        $limit = $items_per_page; //Number of items to display

        $offset = ($limit * $paged) - $limit;

        $data_query = ['order' => 'DESC', 'order_by' => 'id', 'limit' => $limit, 'offset' => $offset];

        if (isset($_GET['active']) && $_GET['active'] == 1) {
            $data_query['status'] = 1;
        }

        if (isset($_GET['active']) && $_GET['active'] == 0) {
            $data_query['status'] = 0;
        }


        $providers = Provider::where($data_query);
        if ($providers):
            ?>

            <table class="shop_table shop_table_responsive">
                <thead>
                <tr>
                    <th><span class="nobr"><?php _e('ID', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e('Name', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e('Balance', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e('Description', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <th><span class="nobr"><?php _e('Last Sync', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <?php if (kando_user_can('update_provider_status')) { ?>
                        <th><span class="nobr"><?php _e('Auto Sync', SAMYAR_TEXT_DOMAIN); ?></span></th>
                        <th><span class="nobr"><?php _e('Group Status Check', SAMYAR_TEXT_DOMAIN); ?><span class=" button-orange btn-small"
                                                                                                           data-tooltip="<?php _e('Make sure this feature is enabled in the provider', SAMYAR_TEXT_DOMAIN); ?>"><i
                                            class="fal fa-info-circle"></i></span></span></th>
                        <th><span class="nobr"><?php _e('Status', SAMYAR_TEXT_DOMAIN); ?></span></th>
                    <?php } ?>
                    <th><span class="nobr"><?php _e('Actions', SAMYAR_TEXT_DOMAIN); ?></span></th>
                </tr>
                </thead>

                <tbody>
                <?php
                foreach ($providers as $provider):
                    ?>
                    <tr id="provider-<?php echo esc_attr($provider->id) ?>">
                        <td data-title="<?php _e('ID', SAMYAR_TEXT_DOMAIN); ?>">
                            <?php echo esc_attr($provider->id) ?>
                        </td>
                        <td data-title="<?php _e('Name', SAMYAR_TEXT_DOMAIN); ?>">
                            <?php echo esc_attr($provider->name) ?>
                        </td>
                        <td class="credit" data-title="<?php _e('Balance', SAMYAR_TEXT_DOMAIN); ?>">
                            <?php
                            $credit = "";
                            switch ($provider->base_currency) {
                                case "USD":
                                    if (!is_null($provider->balance)) {
                                        $credit = number_format($provider->balance, 2) . ' ' . __('USD', SAMYAR_TEXT_DOMAIN);
                                    }

                                    break;
                                case "IRT":

                                    if (!is_null($provider->balance)) {
                                        $credit = number_format($provider->balance, 0) . ' ' . __('Toman', SAMYAR_TEXT_DOMAIN);
                                    }
                                    break;
                                case "IRR":
                                    if (!is_null($provider->balance)) {
                                        $credit = number_format($provider->balance, 0) . ' ' . __('Rial', SAMYAR_TEXT_DOMAIN);
                                    }
                                    break;
                                default:
                                    if (!is_null($provider->balance)) {
                                        $credit = number_format($provider->balance, 0);
                                    }
                                    break;
                            }
                            ?>
                            <?php echo $credit ?>
                        </td>
                        <td data-title="<?php _e('Description', SAMYAR_TEXT_DOMAIN); ?>">
                            <?php echo esc_attr($provider->description) ?>
                        </td>
                        <td data-title="<?php _e('Last Sync', SAMYAR_TEXT_DOMAIN); ?>">
                            <?php
                            if ($provider->update_at) {
                                $date_format = get_option('date_format');
                                $time_format = get_option('time_format');
                                echo date_i18n($date_format . ' ' . $time_format, strtotime($provider->update_at));
                            } else {
                                echo __('Not Synced', SAMYAR_TEXT_DOMAIN);
                            }
                            ?>
                        </td>
                        <?php if (kando_user_can('update_provider_status')) { ?>
                            <td data-title="<?php _e('Auto Sync', SAMYAR_TEXT_DOMAIN); ?>">

                                <label class="custom-switch">
                                    <input type="checkbox" name="autosync-provider" data-type="autosync_provider"
                                           data-id="<?php echo esc_attr($provider->id) ?>"
                                           class="ajax-switch custom-switch-input"
                                           data-toggle="collapse"
                                           aria-expanded="false" <?php echo checked($provider->autosync, 1); ?>>
                                    <span class="custom-switch-indicator"></span>
                                </label>

                            </td>
                            <td data-title="<?php _e('Group Status Check', SAMYAR_TEXT_DOMAIN); ?>">

                                <label class="custom-switch">
                                    <input type="checkbox" name="multistatus-provider" data-type="multistatus_provider"
                                           data-id="<?php echo esc_attr($provider->id) ?>"
                                           class="ajax-switch custom-switch-input"
                                           data-toggle="collapse"
                                           aria-expanded="false" <?php echo checked($provider->multi_status, 1); ?>>
                                    <span class="custom-switch-indicator"></span>
                                </label>

                            </td>
                            <td data-title="<?php _e('Status', SAMYAR_TEXT_DOMAIN); ?>">

                                <label class="custom-switch">
                                    <input type="checkbox" name="disable-provider" data-type="provider"
                                           data-id="<?php echo esc_attr($provider->id) ?>"
                                           class="ajax-switch custom-switch-input"
                                           data-toggle="collapse"
                                           aria-expanded="false" <?php echo checked($provider->status, 1); ?>>
                                    <span class="custom-switch-indicator"></span>
                                </label>

                            </td>
                        <?php } ?>
                        <td data-title="<?php _e('Actions', SAMYAR_TEXT_DOMAIN); ?>">
                            <?php if (!is_null($provider->site_link)) { ?>
                                <a href="<?= esc_attr($provider->site_link) ?>" target="_blank"><span
                                            class="button button-orange btn-small"
                                            data-tooltip="<?php _e('Go to Provider Website', SAMYAR_TEXT_DOMAIN); ?>"><i
                                                class="fal fa-link"></i></span></a>
                            <?php } ?>
                            <?php if (kando_user_can('edit_provider')) { ?>
                                <a href="<?php echo esc_attr(home_url('dashboard/?action=providers&section=edit&id=' . esc_attr($provider->id))) ?>">
                                    <span class="button button-default btn-small" data-tooltip="<?php _e('Edit', SAMYAR_TEXT_DOMAIN); ?>"><i
                                                class="fal fa-edit"></i></span>
                                </a>
                            <?php } ?>

                            <?php if (kando_user_can('update_provider_balance')) { ?>
                                <span class="button button-violet btn-small sync-credit-provider"
                                      data-id="<?php echo esc_attr($provider->id) ?>" data-tooltip="<?php _e('Update Balance', SAMYAR_TEXT_DOMAIN); ?>"><i
                                            class="fal fa-dollar-sign"></i></span>
                            <?php } ?>

                            <?php if (kando_user_can('update_provider_sync')) { ?>
                                <a href="<?php echo esc_attr(home_url('dashboard/?action=providers&section=sync-services&id=' . esc_attr($provider->id))) ?>"><span
                                            class="button button-green btn-small"
                                            data-tooltip="<?php _e('Sync Services', SAMYAR_TEXT_DOMAIN); ?>"><i
                                                class="fal fa-sync"></i></span></a>
                            <?php } ?>

                            <?php if (kando_user_can('update_provider_services')) { ?>
                                <a href="<?php echo esc_attr(home_url('dashboard/?action=providers&section=service-list&id=' . esc_attr($provider->id))) ?>"><span
                                            class="button button-blue btn-small"
                                            data-tooltip="<?php _e('Service List', SAMYAR_TEXT_DOMAIN); ?>"><i
                                                class="fal fa-list"></i></span></a>
                            <?php } ?>

                            <?php if (kando_user_can('delete_provider')) { ?>
                                <span class="button button-aqua btn-small delete-provider"
                                      data-id="<?php echo esc_attr($provider->id) ?>" data-tooltip="<?php _e('Delete', SAMYAR_TEXT_DOMAIN); ?>"><i
                                            class="fal fa-trash"></i></span>

                            <?php } ?>

                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="table-footer-container">
                <div class="item-right">
                    <label>
                        <select name="kando_select_item_per_page">
                            <option value="10" <?php selected($items_per_page, 10); ?>>10</option>
                            <option value="25" <?php selected($items_per_page, 25); ?>>25</option>
                            <option value="50" <?php selected($items_per_page, 50); ?>>50</option>
                            <option value="100" <?php selected($items_per_page, 100); ?>>100</option>
                        </select>
                    </label>
                </div>
                <div class="item-center">
                    <?php
                    $total = Provider::count();
                    samyar_pagination($total, $limit, $paged)
                    ?>
                </div>
            </div>


        <?php
        else:
            ?>
            <span class="services-notfound"><?php _e('No providers have been added yet.', SAMYAR_TEXT_DOMAIN); ?></span>
        <?php
        endif;
        ?>
    </div>
    <a href="<?php echo esc_attr(home_url('dashboard/?action=providers&section=new')) ?>"
       class="dashboard-add-post-button elegant-icon icon_plus" data-wpel-link="internal"></a>
</div>
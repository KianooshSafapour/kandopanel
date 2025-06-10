<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Provider;

?>
<div class="tickets-navigation">
    <!--    <span class="button button-default">ارائه دهندگان API</span>-->
    <a href="<?php echo esc_attr(home_url('dashboard/?action=providers&section=new')) ?>"
       class="button button-light add-api-provider" data-wpel-link="internal">افزودن ارائه دهنده</a>
    <a href="<?php echo esc_attr(home_url('dashboard/?action=providers&active=0')) ?>"
       style="float: left;margin-right: 5px" class="button button-red" data-wpel-link="internal">ارائه دهندگان غیر
        فعال</a>
    <a href="<?php echo esc_attr(home_url('dashboard/?action=providers&active=1')) ?>"
       style="float: left;margin-right: 5px" class="button button-green" data-wpel-link="internal">ارائه دهندگان
        فعال</a>

</div>
<div class="dashboard-posts-box dashboard-tickets-box">
    <div class="dashboard-posts-title-holder">
        <i class="elegant-icon icon_link"></i>
        <h5 class="dashboard-posts-title">ارائه دهندگان API</h5>
    </div>
    <div class="dashboard-posts-list">
        <?php
        // * paginate
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;//شماره صفحه فعلی
        $limit = 10; //تعداد قابل نمایش
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
                    <th><span class="nobr">شناسه</span></th>
                    <th><span class="nobr">نام</span></th>
                    <th><span class="nobr">اعتبار</span></th>
                    <th><span class="nobr">توضیحات</span></th>
                    <th><span class="nobr">آخرین همگامسازی</span></th>
                    <?php if (kando_user_can('update_provider_status')) { ?>
                        <th><span class="nobr">همگامسازی خودکار</span></th>
                        <th><span class="nobr">بررسی وضعیت گروهی<span class=" button-orange btn-small"
                                                                      data-tooltip="از فعال بودن این ویژگی در ارائه دهنده مطمئن شوید"><i
                                            class="fal fa-info-circle"></i></span></span></th>
                        <th><span class="nobr">وضعیت</span></th>
                    <?php } ?>
                    <th><span class="nobr">عملیات ها</span></th>
                </tr>
                </thead>

                <tbody>
                <?php
                foreach ($providers as $provider):
                    ?>
                    <tr id="provider-<?php echo esc_attr($provider->id) ?>">
                        <td data-title="شناسه">
                            <?php echo esc_attr($provider->id) ?>
                        </td>
                        <td data-title="نام">
                            <?php echo esc_attr($provider->name) ?>
                        </td>
                        <td class="credit" data-title="اعتبار">
                            <?php
                            $credit = "";
                            switch ($provider->base_currency) {
                                case "USD":
                                    if (!is_null($provider->balance)) {
                                        $credit = number_format($provider->balance, 2) . ' دلار ';
                                    }

                                    break;
                                case "IRT":

                                    if (!is_null($provider->balance)) {
                                        $credit = number_format($provider->balance, 0) . ' تومان ';
                                    }
                                    break;
                                case "IRR":
                                    if (!is_null($provider->balance)) {
                                        $credit = number_format($provider->balance, 0) . ' ریال ';
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
                        <td data-title="توضیحات">
                            <?php echo esc_attr($provider->description) ?>
                        </td>
                        <td data-title="آخرین همگامسازی">
                            <?php
                            if ($provider->update_at) {
                                $date_format = get_option('date_format');
                                $time_format = get_option('time_format');
                                echo date_i18n($date_format . ' ' . $time_format, strtotime($provider->update_at));
                            } else {
                                echo 'انجام نشده';
                            }
                            ?>
                        </td>
                        <?php if (kando_user_can('update_provider_status')) { ?>
                            <td data-title="همگامسازی خودکار">

                                <label class="custom-switch">
                                    <input type="checkbox" name="autosync-provider" data-type="autosync_provider"
                                           data-id="<?php echo esc_attr($provider->id) ?>"
                                           class="ajax-switch custom-switch-input"
                                           data-toggle="collapse"
                                           aria-expanded="false" <?php echo checked($provider->autosync, 1); ?>>
                                    <span class="custom-switch-indicator"></span>
                                </label>

                            </td>
                            <td data-title="بررسی وضعیت گروهی">

                                <label class="custom-switch">
                                    <input type="checkbox" name="multistatus-provider" data-type="multistatus_provider"
                                           data-id="<?php echo esc_attr($provider->id) ?>"
                                           class="ajax-switch custom-switch-input"
                                           data-toggle="collapse"
                                           aria-expanded="false" <?php echo checked($provider->multi_status, 1); ?>>
                                    <span class="custom-switch-indicator"></span>
                                </label>

                            </td>
                            <td data-title="وضعیت">

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
                        <td data-title="عملیات ها">
                            <?php if (!is_null($provider->site_link)) { ?>
                                <a href="<?= esc_attr($provider->site_link) ?>" target="_blank"><span
                                            class="button button-orange btn-small"
                                            data-tooltip="رفتن به سایت ارائه دهنده"><i
                                                class="fal fa-link"></i></span></a>
                            <?php } ?>
                            <?php if (kando_user_can('edit_provider')) { ?>
                                <a href="<?php echo esc_attr(home_url('dashboard/?action=providers&section=edit&id=' . esc_attr($provider->id))) ?>">
                                    <span class="button button-default btn-small" data-tooltip="ویرایش"><i
                                                class="fal fa-edit"></i></span>
                                </a>
                            <?php } ?>

                            <?php if (kando_user_can('update_provider_balance')) { ?>
                                <span class="button button-violet btn-small sync-credit-provider"
                                      data-id="<?php echo esc_attr($provider->id) ?>" data-tooltip="بروزرسانی اعتبار"><i
                                            class="fal fa-dollar-sign"></i></span>
                            <?php } ?>

                            <?php if (kando_user_can('update_provider_sync')) { ?>
                                <a href="<?php echo esc_attr(home_url('dashboard/?action=providers&section=sync-services&id=' . esc_attr($provider->id))) ?>"><span
                                            class="button button-green btn-small"
                                            data-tooltip="همگام سازی سرویس ها"><i
                                                class="fal fa-sync"></i></span></a>
                            <?php } ?>

                            <?php if (kando_user_can('update_provider_services')) { ?>
                                <a href="<?php echo esc_attr(home_url('dashboard/?action=providers&section=service-list&id=' . esc_attr($provider->id))) ?>"><span
                                            class="button button-blue btn-small"
                                            data-tooltip="لیست خدمات"><i
                                                class="fal fa-list"></i></span></a>
                            <?php } ?>

                            <?php if (kando_user_can('delete_provider')) { ?>
                                <span class="button button-aqua btn-small delete-provider"
                                      data-id="<?php echo esc_attr($provider->id) ?>" data-tooltip="حذف"><i
                                            class="fal fa-trash"></i></span>

                            <?php } ?>

                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php
            $total = Provider::count();
            samyar_pagination($total, $limit, $paged)
            ?>
        <?php
        else:
            ?>
            <span class="services-notfound">تاکنون ارائه دهنده ای اضافه نشده است.</span>
        <?php
        endif;
        ?>
    </div>
    <a href="<?php echo esc_attr(home_url('dashboard/?action=providers&section=new')) ?>"
       class="dashboard-add-post-button elegant-icon icon_plus" data-wpel-link="internal"></a>
</div>

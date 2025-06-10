<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use samyar\Provider;
use samyar\Service;
use samyar\Category;
use samyar\Udisableservice;
use TenQuality\WP\Database\QueryBuilder;

$options = settingsController::getInstance();

?>

<div class="kt-row">
    <div class="column kt-col-xs-12">
        <?php kando_show_alerts('services'); ?>
    </div>
</div>
<div class="kando-buttons-wrapper">

    <?php if (kando_user_can('add_service')): ?>
        <a href="<?php echo esc_attr(home_url('dashboard/?action=services&section=new')) ?>" class="button button-light"
           data-wpel-link="internal"><?php _e("Add Service", SAMYAR_TEXT_DOMAIN); ?></a>
    <?php endif; ?>
    <?php if (kando_user_can('edit_service')): ?>
        <a href="#" class="button button-red kando-change-service-status"
           data-wpel-link="internal"><?php _e("Change Status/Delete/Category", SAMYAR_TEXT_DOMAIN); ?></a>
    <?php endif; ?>
    <?php if (kando_user_can('add_service')): ?>
        <a href="<?php echo esc_attr(home_url('dashboard/?action=service-tags')) ?>" class="button button-light"
           data-wpel-link="internal"><?php _e("Service Tags", SAMYAR_TEXT_DOMAIN); ?></a>
    <?php endif; ?>
</div>

<?php include(SAMYAR_DIR_VIEW . '/services/filter-box.php'); ?>
<div class="kando-services-box is-loading">
    <div class="categories-container"></div>
    <div class="samyar-form-loading" style="display: none;width: 100%;height: 100px;position: relative;"></div>
</div>

<script>
    jQuery(document).ready(function ($) {
        let currentPage = 1;
        let isLoading = false; // برای جلوگیری از درخواست‌های همزمان

        function loadCategories(page) {
            if (isLoading) return; // اگر در حال بارگذاری است، از ارسال درخواست جدید جلوگیری کن
            isLoading = true; // علامت بزن که در حال بارگذاری هستیم

            $.ajax({
                url: kando_data.ajaxurl,
                type: 'POST',
                data: {
                    action: 'kando_get_categories',
                    page: page
                },
                beforeSend: function () {
                    $('.samyar-form-loading').show(); // نمایش لودینگ
                },
                success: function (response) {
                    if (response.success) {
                        $('.categories-container').append(response.data.html);
                        currentPage = response.data.pagination.current_page;
                        const totalPages = response.data.pagination.total_pages;
                        if (currentPage < totalPages) {
                            isLoading = false;
                            loadCategories(currentPage + 1);
                        } else {
                            $('.samyar-form-loading').hide(); // پنهان کردن لودینگ
                        }
                    } else {
                        console.error('Error loading categories:', response.data.message);
                    }
                },
                complete: function () {
                    isLoading = false; // علامت بزن که بارگذاری تمام شده
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                    $('.samyar-form-loading').hide(); // پنهان کردن لودینگ در صورت خطا
                    isLoading = false;
                }
            });
        }

        loadCategories(currentPage); // بارگذاری اولیه

    });

    function persianToEnglish(num) {
        const persianDigits = '۰۱۲۳۴۵۶۷۸۹';
        const arabicDigits = '٠١٢٣٤٥٦٧٨٩';
        const digitsMap = Array.from({length: 10}, (_, i) => i.toString());
        return num.replace(/[۰-۹]/g, d => digitsMap[persianDigits.indexOf(d)])
            .replace(/[٠-٩]/g, d => digitsMap[arabicDigits.indexOf(d)]);
    }

    jQuery(document).ready(function ($) {
        function filterServices() {
            var platform = $('#sel_platforms').val();
            if (platform === null || platform === undefined || platform === '') {
                platform = 'all';
            }

            var category = $('#sel_category').val();
            if (category === null || category === undefined || category === '') {
                category = 'all';
            }

            var status = $('#activeService').val();
            if (status === null || status === undefined || status === '') {
                status = 'all';
            }

            var searchText = persianToEnglish($('#searchService').val().toLowerCase());

            $('.service-card,.service-category').each(function () {
                var card = $(this);
                var cardPlatform = card.data('platform');
                var cardCategory = card.data('category');
                var hasVisibleServices = false;

                card.find('.service-item, tr[data-service-id]').each(function () {
                    var item = $(this);
                    var itemCategory = item.data('category');
                    var itemStatus = item.data('status');
                    var serviceId = item.data('service-id').toString();
                    var serviceName = item.data('service-name').toLowerCase();
                    var isFavorite = item.data('fav') === 1;


                    var platformMatch = (platform === 'all' || cardPlatform == platform);
                    var activeMatch = (status === 'all' || itemStatus == status);
                    var categoryMatch = (category === 'all' || category === 'fav' || itemCategory == category); // تغییر اینجا
                    var searchMatch = (serviceId.includes(searchText) || serviceName.includes(searchText));
                    var favoriteMatch = (category !== 'fav' || isFavorite);

                    if (platformMatch && activeMatch && categoryMatch && searchMatch && favoriteMatch) {
                        item.show();
                        hasVisibleServices = true;
                    } else {
                        item.hide();
                    }
                });

                if (hasVisibleServices) {
                    card.show();
                } else {
                    card.hide();
                }
            });
        }

        $('#sel_platforms, #sel_category, #searchService, #activeService').on('change keyup', filterServices);

        $(document).on('click', '.favorite-btn', function (e) {
            var button = $(this);
            var serviceId = button.data('service-id');
            $.ajax({
                url: kando_data.ajaxurl,
                type: 'post',
                data: {action: 'kando_favorite_service', service_id: serviceId},
                success: function (response) {
                    kando_show_toast(response.data.message);
                    if (response.data.active === 1) {
                        button.addClass('active');
                    } else {
                        button.removeClass('active');
                    }

                },
                error: function () {
                    Swal.fire({
                        title: kando_data.langs.an_error,
                        icon: 'error',
                        html: response.data.message,
                        showCloseButton: true,
                        confirmButtonText: kando_data.langs.ok,
                    })
                }
            });
        });
    });

    /*
    const infoIcon = document.getElementById('infoIcon');
    const mainCategory = document.getElementById('mainCategory');

    infoIcon.addEventListener('mouseover', () => {
        mainCategory.classList.remove('hidden');
    });

    infoIcon.addEventListener('mouseout', () => {
        mainCategory.classList.add('hidden');
    });

    infoIcon.addEventListener('touchstart', () => {
        mainCategory.classList.remove('hidden');
    });

    infoIcon.addEventListener('touchend', () => {
        mainCategory.classList.add('hidden');
    });
*/
</script>
<div class="sticky_toolbar_footer mfoot_1">

    <svg xmlns="http://www.w3.org/2000/svg" width="1080" height="230" viewBox="0 0 1080 230">
        <path class="footer_svg"
              d="M1081,3811.44V3966H1V3811.44q42.5-8.97,85-17.95,7.5-.99,15-1.99c18.1-5.71,39.855-7.3,58-12.97l25-3.99c18.008-5.81,39.853-7.3,58-12.96q9.5-1.5,19-2.99v-1q7.5-.99,15-1.99c19.78-6.17,43.347-7.71,63-13.96q7.5-1.005,15-2v-0.99q5-.51,10-1c3.951-1.22,18.608-3.83,25-2,15.424,4.43,29.569,8.63,38,19.95q2,1.485,4,2.99v1.99c0.667,0.34,1.333.67,2,1q0.5,1.995,1,3.99h1c0.667,1.99,1.333,3.99,2,5.98h1v2.99h1v2h1q0.5,3.48,1,6.98h1v3.99h1v3.99h1v3.98h1q1,8.475,2,16.96l9,20.94,2,0.99q0.5,1.995,1,3.99h1c0.333,1,.667,2,1,2.99,0.667,0.34,1.333.67,2,1v2c1,0.66,2,1.33,3,1.99v1.99q4,3.495,8,6.98c1.667,2,3.334,3.99,5,5.99h2c0.667,0.99,1.333,1.99,2,2.99h2c0.667,1,1.333,1.99,2,2.99,1.333,0.33,2.667.67,4,1,0.333,0.66.667,1.33,1,1.99q4.5,1.5,9,2.99v1h2v1h3v0.99h2v1c2.666,0.33,5.334.67,8,1v1h4v0.99h7c3.45,0.98,23.246,2.35,28,1v-1h7v-0.99h4v-1h4v-1h4v-1l5-.99v-1h2v-1h3v-0.99c1.333-.34,2.667-0.67,4-1v-1h2c0.333-.66.667-1.33,1-1.99,1.333-.33,2.667-0.67,4-1,0.667-1,1.333-1.99,2-2.99h2c0.667-1,1.333-2,2-2.99h2c1.333-1.66,2.667-3.33,4-4.99l9-7.98v-1.99c1-.66,2-1.33,3-1.99v-2c0.667-.33,1.333-0.66,2-1v-1.99c0.667-.33,1.333-0.67,2-1q0.5-1.995,1-3.99l2-.99q0.5-1.995,1-3.99h1q0.5-1.995,1-3.99h1v-2.99h1q0.5-1.995,1-3.99h1c0.333-1.99.667-3.99,1-5.98h1v-5.99h1v-5.98h1v-4.99h1v-3.98h1v-3.99h1q0.5-3.99,1-7.98l10-20.94q2-1.5,4-2.99c0.333-1,.667-2,1-2.99h2l3-3.99h2c0.333-.67.667-1.33,1-2h2c0.333-.66.667-1.33,1-1.99,2-.67,4-1.33,6-2v-0.99h2v-1h3v-1h3v-0.99h3v-1h4v-1h5v-1c6.372-1.83,21.067.78,25,2q5,0.495,10,1c7.328,2.29,16.752,3.72,24,5.98q5,0.495,10,1c10.559,3.31,23.491,4.7,34,7.97q10,1.5,20,2.99c18.15,5.71,39.779,7.29,58,12.97q10,1.5,20,2.99c18.008,5.81,39.853,7.31,58,12.96q7.5,1,15,2c11.986,3.76,26.887,5.2,39,8.97,3.33,0.33,6.67.67,10,1,5.93,1.85,14.07,3.14,20,4.98h5C1052.99,3806.32,1067.89,3808.88,1081,3811.44Z"
              transform="translate(-1 -3735)"></path>
    </svg>
    <div class="toolbar_mobile">
        <div class="toolbar_col elm_t-custom"><a class="toolbar_item" href="<?php echo esc_attr(home_url('dashboard/?action=add-credit')) ?>"><i class="fal fa-coin"></i></a></div>
        <div class="toolbar_col elm_t-goup">
            <?php if (class_exists('wpnController')):
                $options = \wpnumbers\settingsController::getInstance();
                $wpn_link = esc_attr(kando_get_option('wpn-order-link-mobile', ""));
                ?>
                <a class="toolbar_item" href="<?= $wpn_link ?>"><i class="fal fa-phone-plus"></i></a>
            <?php endif; ?>
        </div>


        <div class="toolbar_col elm_t-cart is_middle"><a href="<?php echo esc_attr(home_url('dashboard/?action=orders&section=new')) ?>" class="toolbar_item"><i class="fal fa-shopping-cart"></i></a>
        </div>

        <div class="toolbar_col elm_t-cat">
            <?php if (function_exists('kandopanelWheelController_init')): ?>
                <a href="<?php echo esc_attr(home_url('dashboard/?action=lucky-wheel')) ?>" class="toolbar_item" data-class="open_categories_sidebar"><i class="fal fa-gifts"></i></a>
            <?php endif; ?>
        </div>

        <div class="toolbar_col elm_t-user"><a class="toolbar_item login_btn" href="<?php echo esc_attr(home_url('dashboard')) ?>"><i class="fal fa-user"></i></a></div>
    </div>
</div>
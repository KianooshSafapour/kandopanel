<?php
get_header();
$options      = settingsController::getInstance();
?>

    <header class="hero">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <div class="wrapper">
            <div class="hero-inner">
                <h1 class="hero-title">
                    <?php echo esc_attr($options->get_option('index-title', " فروشگاه خدمات شبکه های اجتماعی کندوپنل ")); ?>
                </h1>
                <div class="hero-text"><?php echo esc_attr($options->get_option('index-content', " حساب شبکه های اجتماعی شما می‌تواند رشد کند. درآمد شما می‌تواند چند برابر شود. فقط کافی است مسیر درست را بشناسید. کافی است از خدمات مناسب در مکان مناسب استفاده نمایید. ما در این مسیر همراه شما هستیم. ")); ?> </div>
                <div class="hero-buttons">
                    <?php if ( is_user_logged_in() ): ?>
                        <a href="<?php echo esc_attr( home_url( 'dashboard/?action=orders&section=new' ) ) ?>" class="button button-default" data-wpel-link="internal">ثبت سفارش</a>
                        <a href="<?php echo esc_attr( home_url( 'dashboard/?action=add-credit' ) ) ?>" class="button button-gray" data-wpel-link="internal">افزودن اعتبار</a>
                    <?php else: ?>
                        <button type="button" class="button kt-modal-button button-gray kt-login-button" data-modal="login">ورود</button>
                        <button type="button" class="button kt-modal-button button-default kt-register-button" data-modal="login">ثبت‌نام</button>
                    <?php endif; ?>


                </div>
            </div>

        </div>


    </header>

<?php
// Start the loop.
while ( have_posts() ) : the_post();

    // Include the page content template.
    the_content();

    // If comments are open or we have at least one comment, load up the comment template.
    if ( comments_open() || get_comments_number() ) {
        comments_template();
    }

    // End of the loop.
endwhile;
?>
<?php get_footer() ?>
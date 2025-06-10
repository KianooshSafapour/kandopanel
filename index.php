<?php
get_header();
$options = settingsController::getInstance();
?>

    <header class="hero">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <div class="wrapper">
            <div class="hero-inner">
                <h1 class="hero-title">
                    <?php echo esc_attr(kando_get_option('index-title', __('KandoPanel Social Media Services Store', SAMYAR_TEXT_DOMAIN))); ?>
                </h1>
                <div class="hero-text">
                    <?php echo esc_attr(kando_get_option('index-content', __('Your social media accounts can grow. Your income can multiply. All you need is to find the right path and use the right services in the right place. We are here to help you along the way.', SAMYAR_TEXT_DOMAIN))); ?>
                </div>
                <div class="hero-buttons">
                    <?php if (is_user_logged_in()): ?>
                        <a href="<?php echo esc_attr(home_url('dashboard/?action=orders&section=new')); ?>" class="button button-default" data-wpel-link="internal"><?php _e('Place Order', SAMYAR_TEXT_DOMAIN); ?></a>
                        <a href="<?php echo esc_attr(home_url('dashboard/?action=add-credit')); ?>" class="button button-gray" data-wpel-link="internal"><?php _e('Add funds', SAMYAR_TEXT_DOMAIN); ?></a>
                    <?php else: ?>
                        <button type="button" class="button kt-modal-button button-gray kt-login-button" data-modal="login"><?php _e('Login', SAMYAR_TEXT_DOMAIN); ?></button>
                        <button type="button" class="button kt-modal-button button-default kt-register-button" data-modal="register"><?php _e('Register', SAMYAR_TEXT_DOMAIN); ?></button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

<?php
// Start the loop.
while (have_posts()) : the_post();

    // Include the page content template.
    the_content();

    // If comments are open or we have at least one comment, load up the comment template.
    if (comments_open() || get_comments_number()) {
        comments_template();
    }

    // End of the loop.
endwhile;
?>
<?php get_footer(); ?>
<?php
/*
Template Name: Home
*/
get_header(); ?>

    <header class="hero">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <div class="wrapper">
            <div class="hero-inner">
                <h1 class="hero-title">
                    <?php _e('KandoPanel Social Media Services Store', SAMYAR_TEXT_DOMAIN); ?>
                </h1>
                <div class="hero-text">
                    <?php _e('Your social media accounts can grow. Your income can multiply. All you need is to find the right path and use the right services in the right place. We are here to help you along the way.', SAMYAR_TEXT_DOMAIN); ?>
                </div>
                <div class="hero-buttons">
                    <?php if (is_user_logged_in()): ?>
                        <a href="/academy/" class="button button-default" data-wpel-link="internal"><?php _e('Place Order', SAMYAR_TEXT_DOMAIN); ?></a>
                        <a href="/services/" class="button button-gray" data-wpel-link="internal"><?php _e('Recharge Account', SAMYAR_TEXT_DOMAIN); ?></a>
                    <?php else: ?>
                        <a href="/login/" class="button button-default" data-wpel-link="internal"><?php _e('Login', SAMYAR_TEXT_DOMAIN); ?></a>
                        <a href="/register/" class="button button-gray" data-wpel-link="internal"><?php _e('Register', SAMYAR_TEXT_DOMAIN); ?></a>
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
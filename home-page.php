<?php
/*
Template Name: home
*/
get_header() ?>

    <header class="hero">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <div class="wrapper">
            <div class="hero-inner">
                <h1 class="hero-title">
                    فروشگاه خدمات شبکه های اجتماعی کندوپنل
                </h1>
                <div class="hero-text">
                    حساب شبکه های اجتماعی شما می‌تواند رشد کند. درآمد شما می‌تواند چند برابر شود. فقط کافی است مسیر درست را بشناسید. کافی است از خدمات مناسب در مکان مناسب استفاده نمایید. ما
                    در این مسیر همراه شما هستیم.
                </div>
                <div class="hero-buttons">
					<?php if ( is_user_logged_in() ): ?>
                        <a href="/academy/" class="button button-default" data-wpel-link="internal">ثبت سفارش</a>
                        <a href="/services/" class="button button-gray" data-wpel-link="internal">شارژ حساب</a>
					<?php else: ?>
                        <a href="/academy/" class="button button-default" data-wpel-link="internal">ورود</a>
                        <a href="/services/" class="button button-gray" data-wpel-link="internal">ثبت نام</a>
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
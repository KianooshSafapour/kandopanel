<?php
get_header();
?>
    <div class="page-content-outer-holder">
        <div class="wrapper">
            <div class="page-content-holder">
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

            </div>
        </div>
    </div>
<?php get_footer() ?>
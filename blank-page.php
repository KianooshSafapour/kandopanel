<?php
/*
Template Name: blank page
*/
get_header();

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
get_footer();
<?php

/*
 Template Name: Homepage
 */

$args = array(
	'post_type'      => 'post',
	'posts_per_page' => -1
);

$query = new WP_Query($args);

get_header();

?>

<div class="wrapper homepage-wrapper" id="page-wrapper">

	<div class="" id="content" tabindex="-1">

		<div class="row">

			<main class="site-main" id="main">

				<?php
				while ( $query->have_posts() ) {
					$query->the_post();
					?>
                    <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

						<?php
                        the_title(
                            '<header class="entry-header"><h1 class="entry-title">',
                            '</h1></header><!-- .entry-header -->'
                        );

						echo get_the_post_thumbnail( $post->ID, 'large' );
						?>

                        <div class="entry-content">

							<?php
							the_content();
							understrap_link_pages();
							?>

                        </div><!-- .entry-content -->

                        <footer class="entry-footer">

							<?php understrap_edit_post_link(); ?>

                        </footer><!-- .entry-footer -->

                    </article><!-- #post-<?php the_ID(); ?> -->
                    <?php
				}
				wp_reset_query();
				?>

			</main>

		</div><!-- .row -->
        <div class="homepage-content">
            <?php the_content(); ?>
        </div>

	</div><!-- #content -->

</div><!-- #page-wrapper -->

<?php
get_footer();

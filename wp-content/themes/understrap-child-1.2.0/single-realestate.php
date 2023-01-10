<?php

get_header();

while ( have_posts() ) :
	the_post();

	?>

	<div class="single-real-estate-content-wrapper">

        <div class="single-real-estate-top-block">
            <div class="single-real-estate-image-wrapper">
                <img src="<?php echo get_field( 'thumbnail' )['url']; ?>" alt="Real Estate Thumbnail" />
            </div>
            <div class="single-real-estate-main-info">
                <h2 class="single-real-estate-name"><?php echo get_field( 'real_estate_name' ); ?></h2>
                <h4 class="single-real-estate-ecology">Ecology: <?php echo get_field( 'ecology' ); ?></h4>
				<h5 class="single-real-estate-area">Area: <?php echo get_the_terms( get_the_ID(), 'areas' )[0]->name; ?></h5>
				<span class="single-real-estate-coordinates"><b>Coordinates:</b> <?php echo get_field( 'coordinates' ); ?></span>
				<span class="single-real-estate-number-of-floors"><b>Number of Floors:</b> <?php echo get_field( 'number_of_floors' ); ?></span>
				<span class="single-real-estate-building-type"><b>Building Type:</b> <?php echo get_field( 'building_type' ); ?></span>
            </div>
        </div>

	</div>

<?php
endwhile;

get_footer();

?>

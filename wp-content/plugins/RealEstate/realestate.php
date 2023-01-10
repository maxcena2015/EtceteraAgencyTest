<?php
/*
Plugin Name: Real Estate
Plugin URI: http://google.com
Description: Plugin that create real estate CPT
Version: 1.0
Author: Maksim Levchenko
Author URI: http://google.com
*/

if ( ! function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

class RealEstate {

	public function __construct() {
	}

	public function register() {
		//enqueue css and js
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_front' ) );

		$this->register_cpt();
		$this->register_taxonomy();
		$this->register_shortcodes();
		$this->register_ajax();

		$this->real_estate_ecology_order();
	}

	static function activation() {
		//update rewrite rules
		flush_rewrite_rules();
	}

	static function deactivation() {
		//update rewrite rules
		flush_rewrite_rules();
	}

	public function enqueue_admin() {
		wp_enqueue_style( 'realEstateStyleAdmin', plugins_url( '/assets/admin/css/styles.css', __FILE__ ) );
		wp_enqueue_script( 'realEstateScriptAdmin', plugins_url( '/assets/admin/js/script.js', __FILE__ ) );
	}

	public function enqueue_front() {
		wp_enqueue_style( 'realEstateStyleFront', plugins_url( '/assets/front/css/styles.css', __FILE__ ) );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'realEstateScriptFront', plugins_url( '/assets/front/js/scripts.js', __FILE__ ), array( 'jquery' ) );
		wp_localize_script( 'realEstateScriptFront', 'refilter_ajax_object',
			array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}

	private function register_cpt() {
		add_action( 'init', array($this, 'real_estate_cpt' ) );
	}

	private function register_taxonomy() {
		add_action( 'init', array($this, 'real_estate_taxonomy' ), 0 );
	}

	private function register_shortcodes() {
		add_shortcode( 'refilter', array( $this, 'real_estate_filter' ) );
	}

	private function register_ajax() {
		add_action( "wp_ajax_real_estate_filter_results", array( $this, "real_estate_filter_results_callback" ) );
		add_action( "wp_ajax_nopriv_real_estate_filter_results", array( $this, "real_estate_filter_results_callback" ) );
    }

    private function real_estate_ecology_order() {
	    add_action( 'pre_get_posts', array( $this, 're_ecology_order' ) );
    }

	public function real_estate_filter_results_callback() {

	    $name         = ( $_POST['name'] ) ? sanitize_text_field( $_POST['name'] ) : '';
	    $coordinates  = ( $_POST['coordinates'] ) ? sanitize_text_field( $_POST['coordinates'] ) : '';
	    $floors       = ( $_POST['floors'] ) ? sanitize_text_field( $_POST['floors'] ) : '';
	    $buildingType = ( $_POST['building_type'] ) ? sanitize_text_field( $_POST['building_type'] ) : '';
	    $ecology      = ( $_POST['ecology'] ) ? sanitize_text_field( $_POST['ecology'] ) : '';

	    $paged = 1;
	    if ( $_POST['page'] ) {
            $paged = ( is_numeric( $_POST['page'] ) ) ? $_POST['page'] : $paged;
        }

	    $args = $this->re_filter_generate_args( $name, $coordinates, $buildingType, $ecology, $floors, $paged );

		$realEstateLoop = new WP_Query( $args );

		ob_start();

		if ( $realEstateLoop->have_posts() ):
            while ( $realEstateLoop->have_posts() ):
	            $realEstateLoop->the_post();
		?>

        <div class="real-estate-item">
            <img src="<?php echo get_field( 'thumbnail' )['url']; ?>" alt="Real Estate Thumb" />
            <h4><?php echo get_field( 'real_estate_name' ); ?></h4>
            <div><?php the_content(); ?></div>
            <a href="<?php echo get_the_permalink(); ?>">More</a>
        </div>

        <?php
            endwhile;
        else:
            ?>Sorry, no results.<?php
        endif;

		$total_pages = $realEstateLoop->max_num_pages;

		if ( $total_pages > 1 ) {

			$current_page = max( 1, $paged );

			?>
            <div class="real-estate-pagination"
                 data-name="<?php echo $name; ?>"
                 data-coordinates="<?php echo $coordinates; ?>"
                 data-floors="<?php echo $floors; ?>"
                 data-buldingType="<?php echo $buildingType; ?>"
                 data-ecology="<?php echo $ecology; ?>"
            >
            <?php

			$pagination = paginate_links( array(
				'base' => get_pagenum_link(1) . '%_%',
				'format' => '/page/%#%',
				'current' => $current_page,
				'total' => $total_pages,
				'prev_text'    => __('< Previous'),
				'next_text'    => __('Next >'),
			) );

            $pagination = str_replace ( get_site_url() . '/wp-admin/admin-ajax.php/page/', '', $pagination );

            echo $pagination;

			?>
            </div>
            <?php
		}

		$filterResult = ob_get_clean();
		echo $filterResult;

		wp_die();
	}

	private function re_filter_generate_args( $name, $coordinates, $buildingType, $ecology, $floors, $paged ) : array
    {

		$metaQuery = array(
			'relation'      => 'AND',
			array(
				'key'       => 'real_estate_name',
				'value'     => $name,
				'compare'   => 'LIKE'
			),
			array(
				'key'       => 'coordinates',
				'value'     => $coordinates,
				'compare'   => 'LIKE'
			),
			array(
				'key'       => 'building_type',
				'value'     => $buildingType,
				'compare'   => 'LIKE'
			),
			array(
				'key'       => 'ecology',
				'value'     => $ecology,
				'compare'   => 'LIKE'
			),
		);

		if ( $floors ) {
			$metaQuery[] = array(
				'key'       => 'number_of_floors',
				'value'     => $floors,
				'compare'   => '='
			);
		}

		$args = array(
			'post_type'      => 'realestate',
			'posts_per_page' => 5,
			'paged'          => $paged,
			'meta_query'     => $metaQuery,
		);

		return $args;
	}

	public function real_estate_filter( $atts ): string {

		ob_start();

		?>

		<h2>Filter Real Estates</h2>
		<div class="real-estate-filter">
			<form class="real-estate-filter-form">
				<div class="filter-block">
					<label for="real-estate-name">Name: </label>
					<input type="text" name="real-estate-name" id="real-estate-name" />
				</div>
				<div class="filter-block">
					<label for="real-estate-coordinates">Coordinates: </label>
					<input type="text" name="real-estate-coordinates" id="real-estate-coordinates" />
				</div>
				<div class="filter-block">
					<label for="real-estate-floors">Number of Floors: </label>
					<input type="number" name="real-estate-floors" id="real-estate-floors" />
				</div>
				<div class="filter-block">
					<div class="filter-block-radio-button">
						<input type="radio" id="real-estate-building-type-any"
						       name="real-estate-building-type" value="" checked="checked">
						<label for="real-estate-building-type-any">Any</label>
					</div>

					<div class="filter-block-radio-button">
						<input type="radio" id="real-estate-building-type-panel"
						       name="real-estate-building-type" value="panel">
						<label for="real-estate-building-type-panel">Panel</label>
					</div>

					<div class="filter-block-radio-button">
						<input type="radio" id="real-estate-building-type-brick"
						       name="real-estate-building-type" value="brick">
						<label for="real-estate-building-type-brick">Brick</label>
					</div>

					<div class="filter-block-radio-button">
						<input type="radio" id="real-estate-building-type-foam-block"
						       name="real-estate-building-type" value="foam Block">
						<label for="real-estate-building-type-foam-block">Foam Block</label>
					</div>
				</div>
				<div class="filter-block">
					<label for="real-estate-ecology">Ecology: </label>
					<select name="real-estate-ecology" id="real-estate-ecology">
                        <option value="">Any</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
					</select>
				</div>
			</form>
			<button class="real-estate-filter-btn btn btn-primary">Filter</button>
		</div>
		<div class="real-estate-filter-results"></div>

		<?php

		return ob_get_clean();
	}

	public function real_estate_cpt() {

		register_post_type( 'realEstate',
			array(
				'labels' => array(
					'name'          => __( 'Real Estates', '' ),
					'singular_name' => __( 'Real State', '' ),
				),
				'public'      => true,
				'has_archive' => true,
				'taxonomies'  =>array( 'areas' ),
				'supports'    => array( 'title', 'editor' ),
			)
		);

	}

	public function re_ecology_order( $query ) {
		if ( in_array( $query->get('post_type'), array( 'realestate' ) ) ) {
			$query->set( 'meta_key', 'ecology' );
			$query->set( 'orderby', 'meta_value' );
			$query->set( 'order', 'DESC' );
			return;
		}
	}

	public function real_estate_taxonomy() {

		$labels = array(
			'name'              => _x( 'Areas', 'taxonomy general name' ),
			'singular_name'     => _x( 'Area', 'taxonomy general name' ),
			'search_items'      => __( 'Search Areas' ),
			'all_items'         => __( 'All Areas' ),
			'parent_item'       => __( 'Parent Area' ),
			'parent_item_colon' => __( 'Parent Area:' ),
			'edit_item'         => __( 'Edit Area' ),
			'update_item'       => __( 'Update Area' ),
			'add_new_item'      => __( 'Add New Area' ),
			'new_item_name'     => __( 'New Area Name' ),
			'menu_name'         => __( 'Areas' ),
		);

		register_taxonomy( 'areas', 'realEstate', array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_in_rest'      => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'area' ),
		) );

	}

}

if ( class_exists( 'RealEstate' ) ) {
	$realEstate = new RealEstate();
	$realEstate->register();
	register_activation_hook( __FILE__, array( $realEstate, 'activation' ) );
	register_deactivation_hook( __FILE__, array( $realEstate, 'deactivation' ) );
}


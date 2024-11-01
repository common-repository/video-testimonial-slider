<?php
/**
 * Plugin Name:       Video Testimonial slider
 * Plugin URI:        https://wordpress.org/plugins/video-testimonial-slider/
 * Description:       Video Testimonial Slider plugin for WordPress website. Using plugin to display client Review and Testimonial with video popup through shortcode.
 * Version:           1.1
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Sumanta Dhank
 * Author URI:        https://itsumanta.wordpress.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       sdvts
 */

if ( ! defined( 'ABSPATH' ) ) {
    header("Location: /"); // to redirect home page
	die( 'Invalid request.' ); 

}



// settings page function here
include_once('inc/functions.php');
/**
 * vts enqueue scripts and styles
 */
function sdvts_enqueue_scripts() {
	wp_enqueue_style( 'swiper-min', plugins_url('css/swiper.min.css', __FILE__) );
	wp_enqueue_style( 'vts-style', plugins_url('css/vts-style.css', __FILE__) );


    wp_enqueue_script( 'swiper-min', plugins_url('js/swiper.min.js', __FILE__), array(), '3.3.1', true );
    wp_enqueue_script( 'bootstrap-min', plugins_url('js/bootstrap.min.js', __FILE__), array(), '4.0.0', true );
    wp_enqueue_script( 'vts-script', plugins_url('js/vts-script.js', __FILE__), array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'sdvts_enqueue_scripts' );

 // custom css for admin settings page
 function sdvts_css_and_js() {
    wp_enqueue_style('vts-admin-style', plugins_url('/css/vts-admin-style.css',__FILE__ ), false, '1.0.0' );
}
add_action('admin_enqueue_scripts', 'sdvts_css_and_js');

/**
 * create admin Testimonials Post Type
 */
if ( ! function_exists('sdvts_custom_post_type') ) {

    // Register Custom Post Type
    function sdvts_custom_post_type() {
    
        $labels = array(
            'name'                  => _x( 'Testimonials', 'Post Type General Name', 'vts' ),
            'singular_name'         => _x( 'Testimonial Type', 'Post Type Singular Name', 'vts' ),
            'menu_name'             => __( 'Testimonials', 'vts' ),
            'name_admin_bar'        => __( 'Testimonial', 'vts' ),
            'archives'              => __( 'Item Archives', 'vts' ),
            'attributes'            => __( 'Item Attributes', 'vts' ),
            'parent_item_colon'     => __( 'Parent Item:', 'vts' ),
            'all_items'             => __( 'All Items', 'vts' ),
            'add_new_item'          => __( 'Add New Item', 'vts' ),
            'add_new'               => __( 'Add New', 'vts' ),
            'new_item'              => __( 'New Item', 'vts' ),
            'edit_item'             => __( 'Edit Item', 'vts' ),
            'update_item'           => __( 'Update Item', 'vts' ),
            'view_item'             => __( 'View Item', 'vts' ),
            'view_items'            => __( 'View Items', 'vts' ),
            'search_items'          => __( 'Search Item', 'vts' ),
            'not_found'             => __( 'Not found', 'vts' ),
            'not_found_in_trash'    => __( 'Not found in Trash', 'vts' ),
            'featured_image'        => __( 'Featured Image', 'vts' ),
            'set_featured_image'    => __( 'Set featured image', 'vts' ),
            'remove_featured_image' => __( 'Remove featured image', 'vts' ),
            'use_featured_image'    => __( 'Use as featured image', 'vts' ),
            'insert_into_item'      => __( 'Insert into item', 'vts' ),
            'uploaded_to_this_item' => __( 'Uploaded to this item', 'vts' ),
            'items_list'            => __( 'Items list', 'vts' ),
            'items_list_navigation' => __( 'Items list navigation', 'vts' ),
            'filter_items_list'     => __( 'Filter items list', 'vts' ),
        );
        $args = array(
            'label'                 => __( 'Testimonial Type', 'vts' ),
            'description'           => __( 'Testimonial Description', 'vts' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'show_in_admin_bar'     => false,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );
        register_post_type( 'testimonial', $args );
    
    }
    add_action( 'init', 'sdvts_custom_post_type', 0 );
    
}


// Adding Meta Boxes in testomonial page
function sdvts_add_custom_box() {
	$screens = [ 'testimonial' ];
	foreach ( $screens as $screen ) {
		add_meta_box(
			'meta_boxes_for_video_testimonial_slider',                 // Unique ID
			'Meta Boxes For Video Testimonial Slider',      // Box title
			'sdvts_custom_box_html',  // Content callback, must be of type callable
			$screen                            // Post type
		);
	}
}
add_action( 'add_meta_boxes', 'sdvts_add_custom_box' );

// Adding Meta Boxes input fiealds testomonial page
function sdvts_custom_box_html( $post ) {
    $designation = get_post_meta( $post->ID, 'designation', true );
    $country = get_post_meta( $post->ID, 'country', true );
    $star_rating = get_post_meta( $post->ID, 'star_rating', true );
    $video_url = get_post_meta( $post->ID, 'video_url', true );
	?>
        <table class="form-table">
            <tbody>
                <tr>
                    <th class="label"><label for="designation">Designation</label></th>
                    <td class="value"><input style="width: 100%" id="designation" name="designation" type="text"
                            value="<?php echo esc_attr($designation); ?>"></td>
                </tr>
                <tr>
                    <th class="label"><label for="country">Country</label></th>
                    <td class="value"><select id="country" name="country">
                            <option value="Afghanistan" <?php selected( $country, 'Afghanistan' ); ?>>Afghanistan</option>
                            <option value="Argentina"<?php selected( $country, 'Argentina' ); ?>>Argentina</option>
                            <option value="Australia"<?php selected( $country, 'Australia' ); ?>>Australia</option>
                            <option value="Bangladesh"<?php selected( $country, 'Bangladesh' ); ?>>Bangladesh</option>
                            <option value="India"<?php selected( $country, 'India' ); ?>>India</option>
                            <option value="Japan"<?php selected( $country, 'Japan' ); ?>>Japan</option>
                            <option value="Nepal"<?php selected( $country, 'Nepal' ); ?>>Nepal</option>
                            <option value="New Zealand"<?php selected( $country, 'New Zealand' ); ?>>New Zealand</option>
                            <option value="Pakistan"<?php selected( $country, 'Pakistan' ); ?>>Pakistan</option>
                            <option value="Russia"<?php selected( $country, 'Russia' ); ?>>Russia</option>
                            <option value="Singapore"<?php selected( $country, 'Singapore' ); ?>>Singapore</option>
                            <option value="South Korea"<?php selected( $country, 'South Korea' ); ?>>South Korea</option>
                            <option value="Sri Lanka"<?php selected( $country, 'Sri Lanka' ); ?>>Sri Lanka</option>
                            <option value="Turkey"<?php selected( $country, 'Turkey' ); ?>>Turkey</option>
                            <option value="UK"<?php selected( $country, 'UK' ); ?>>UK</option>
                            <option value="US"<?php selected( $country, 'US' ); ?>>US</option>
                            <option value="Ukraine"<?php selected( $country, 'Ukraine' ); ?>>Ukraine</option>
                        </select></td>
                </tr>
                <tr>
                    <th class="label"><label for="star_rating">Star Rating</label></th>
                    <td class="value"><select id="star_rating" name="star_rating">
                            <option value="1"<?php selected( $star_rating, '1' ); ?>>1</option>
                            <option value="2"<?php selected( $star_rating, '2' ); ?>>2</option>
                            <option value="3"<?php selected( $star_rating, '3' ); ?>>3</option>
                            <option value="4"<?php selected( $star_rating, '4' ); ?>>4</option>
                            <option value="5"<?php selected( $star_rating, '5' ); ?>>5</option>
                        </select></td>
                </tr>
                <tr>
                    <th class="label"><label for="video_url">Video URL</label></th>
                    <td class="value"><input style="width: 100%" id="video_url" name="video_url" type="url" value="<?php echo esc_attr($video_url); ?>"></td>
                </tr>
            </tbody>
        </table>

    <?php
}

// save the metabox value 
function sdvts_save_postdata( $post_id ) {
	if ( array_key_exists( 'designation', $_POST ) || array_key_exists( 'country', $_POST ) || array_key_exists( 'star_rating', $_POST ) || array_key_exists( 'video_url', $_POST ) ) {
		update_post_meta(
			$post_id,
			'designation',
			sanitize_text_field( $_POST['designation'] )
		);
        update_post_meta(
			$post_id,
			'country',
			sanitize_text_field( $_POST['country'] )
		);
        update_post_meta(
			$post_id,
			'star_rating',
			sanitize_text_field( $_POST['star_rating'] )
		);
        update_post_meta(
			$post_id,
			'video_url',
			sanitize_text_field( $_POST['video_url'] )
		);
	}
}
add_action( 'save_post', 'sdvts_save_postdata' );





/**
 * vts post loop
 */

remove_filter( 'the_excerpt', 'wpautop' ); // to remove p tag from excerpt

function sdvts_custom_excerpt_length( $length ) {
    return get_option( 'display_number' );
}
add_filter( 'excerpt_length', 'sdvts_custom_excerpt_length', 999 );
function sdvts_testimonials_loop(){
    ?>
<div class="swiper-container">
    <div class="swiper-wrapper">
        <?php
    // WP_Query arguments
    $args = array(
        'post_type'      => array( 'testimonial' ),
        'post_status'    => array( 'publish' ),
        'post_per_page'  => 3
    );

    // The Query
    $vts_query = new WP_Query( $args );

    // The Loop
    if ( $vts_query->have_posts() ) {
        while ( $vts_query->have_posts() ) {
            $vts_query->the_post();
            // do something
            ?>

        <div class="swiper-slide">
            <div class="swiper-slide-container">
                <div class="img-container"
                    style="background: url('<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(),'full'));  ?>') center center no-repeat;">

                    <div class="flag">
                        <img src="<?php

                $flag = get_post_meta( get_the_ID(), 'country', true );
                
                if($flag =='Afghanistan'){
                    echo esc_url(plugins_url('img/flag/af-flag.gif', __FILE__)); 
                }elseif($flag =='Argentina'){
                    echo esc_url(plugins_url('img/flag/ar-flag.gif', __FILE__)); 
                }elseif($flag =='Australia'){
                    echo esc_url(plugins_url('img/flag/as-flag.gif', __FILE__)); 
                }elseif($flag =='Bangladesh'){
                    echo esc_url(plugins_url('img/flag/bg-flag.gif', __FILE__)); 
                }elseif($flag =='India'){
                    echo esc_url(plugins_url('img/flag/in-flag.gif', __FILE__)); 
                }elseif($flag =='Japan'){
                    echo esc_url(plugins_url('img/flag/ja-flag.gif', __FILE__)); 
                }elseif($flag =='Nepal'){
                    echo esc_url(plugins_url('img/flag/np-flag.gif', __FILE__)); 
                }elseif($flag =='New Zealand'){
                    echo esc_url(plugins_url('img/flag/nz-flag.gif', __FILE__)); 
                }elseif($flag =='Pakistan'){
                    echo esc_url(plugins_url('img/flag/pk-flag.gif', __FILE__)); 
                }elseif($flag =='Russia'){
                    echo esc_url(plugins_url('img/flag/rs-flag.gif', __FILE__)); 
                }elseif($flag =='Singapore'){
                    echo esc_url(plugins_url('img/flag/sn-flag.gif', __FILE__)); 
                }elseif($flag =='South Korea'){
                    echo esc_url(plugins_url('img/flag/ks-flag.gif', __FILE__)); 
                }elseif($flag =='Sri Lanka'){
                    echo esc_url(plugins_url('img/flag/ce-flag.gif', __FILE__));
                }elseif($flag =='Turkey'){
                    echo esc_url(plugins_url('img/flag/tu-flag.gif', __FILE__)); 
                }elseif($flag =='UK'){
                    echo esc_url(plugins_url('img/flag/uk-flag.gif', __FILE__)); 
                }elseif($flag =='US'){
                    echo esc_url(plugins_url('img/flag/us-flag.gif', __FILE__)); 
                }elseif($flag =='Ukraine'){
                    echo esc_url(plugins_url('img/flag/up-flag.gif', __FILE__));  
                }else{
                    echo esc_url(plugins_url('img/flag/in-flag.gif', __FILE__)); 
                }
                
                ?>" height="auto" width="30px">
                    </div>
                    <div class="review">
                        <div class="star-rating">
                            <?php
                        $rating = get_post_meta( get_the_ID(), 'star_rating', true );
                        if($rating ==1){
                            echo "<div class='star'>★</div>";
                        }elseif($rating ==2){
                            echo "<div class='star'>★</div><div class='star'>★</div>";
                        }elseif($rating ==3){
                            echo "<div class='star'>★</div><div class='star'>★</div><div class='star'>★</div>";
                        }elseif($rating ==4){
                            echo "<div class='star'>★</div><div class='star'>★</div><div class='star'>★</div><div class='star'>★</div>";
                        }elseif($rating ==5){
                            echo "<div class='star'>★</div><div class='star'>★</div><div class='star'>★</div><div class='star'>★</div><div class='star'>★</div>";
                        }else{
                            echo "<div class='star'>No Rating</div>";
                        }
                    
                    ?>
                        </div>
                    </div>
                    <div class="name-video">
                        <div class="title">
                            <strong><?php the_title(); ?></strong>
                            <?php echo esc_attr(get_post_meta( get_the_ID(), 'designation', true )); ?>
                        </div>
                        <div class="video-btn">
                            <button class="video-play-button"
                                data-url="<?php echo esc_url(get_post_meta( get_the_ID(), 'video_url', true )); ?>?rel=0&autoplay=1"
                                data-bs-toggle="modal" data-bs-target="#myModal" title="Play Video Testimonial">
                                <span></span>
                            </button>

                        </div>
                    </div>

                </div>
                <p class="quote"><?php the_excerpt(); ?></p>

            </div>
        </div>

        <?php }
    } else {
        echo "No testimonial found";
    }

    // Restore original Post Data
    wp_reset_postdata();
    ?>

    </div>
</div>
<!-- VIDEO MODAL -->

<div class="modal youtube-video" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="video-container">
          <iframe allow="autoplay" id="youtubevideo" width="640" height="360" frameborder="0" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- VIDEO MODAL -->
<?php
}

/**
 * vts post function short code
 */
function sdvts_custom_shortcode() {
	add_shortcode( 'vts_slider', 'sdvts_testimonials_loop' );
}
add_action( 'init', 'sdvts_custom_shortcode' );

/**
 *  Redirect to settings page once the plugin is activated
 */

register_activation_hook(__FILE__, 'sdvts_plugin_activate');

function sdvts_plugin_activate() {
add_option('sdvts_plugin_do_activation_redirect', true);
}

function sdvts_plugin_redirect() {
if (get_option('sdvts_plugin_do_activation_redirect', false)) {
    delete_option('sdvts_plugin_do_activation_redirect');
    if(!isset($_GET['activate-multi']))
    {
        wp_redirect("edit.php?post_type=testimonial&page=vts-setings-page");
    }
 }
}
add_action('admin_init', 'sdvts_plugin_redirect');

?>


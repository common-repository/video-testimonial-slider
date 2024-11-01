<?php
/**
 * Adds a submenu page under a custom post type parent.
 */

function add_dynamic_css_sdvts() { ?>
<style  type="text/css" media="all">
.star-rating .star {
    background-color: <?php echo esc_attr(get_option( 'star_color' )); ?>;
}

.video-play-button span {
border-left: 15px solid <?php echo esc_attr(get_option( 'btn_color' )); ?>;
}
</style>
<?php }
add_action( 'wp_head', 'add_dynamic_css_sdvts' );


/**
 * Display  setting page on admin sidebar.
 */
function sdvts_register_setting_page() {
    add_submenu_page(
        'edit.php?post_type=testimonial',
        __( 'Settings', 'vts' ),
        __( 'Settings', 'vts' ),
        'manage_options',
        'vts-setings-page',
        'sdvts_setings_page'
    );
}
add_action('admin_menu', 'sdvts_register_setting_page');
/**
 * Display callback for the submenu page.
 */

 
function sdvts_setings_page() { 
    ?>
<div class="wrap vts-wrap">
    <div class="vts-main">
        <h1><?php _e( 'Testimonial Settings', 'vts' ); ?></h1>
        <p><?php _e( 'Shortcode for display client Review and Testimonial with video popup: [vts_slider]', 'vts' ); ?>
        </p>
        <form action="options.php" method="post">
            <?php wp_nonce_field('update-options'); ?>

            <table class="form-table" role="presentation">

                <tbody>
                    <tr>
                        <th scope="row"><label name="star_color" for="star_color">Star Background Color : </label></th>
                        <td><input type="color" name="star_color" value="<?php echo esc_attr(get_option( 'star_color' )); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label name="btn_color" for="btn_color">Video Play button color : </label></th>
                        <td><input type="color" name="btn_color" value="<?php echo esc_attr(get_option( 'btn_color' )); ?>" />
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><label name="display_number" for="display_number">Number of word  : </label></th>
                        <td><input type="number" name="display_number" value="<?php echo esc_attr(get_option( 'display_number' )); ?>" />
                            <p class="description">How many word display on a quote</p>
                        </td>
                    </tr>

                </tbody>
            </table>
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="star_color, btn_color, display_number," />
            <input type="submit" name="submit" class="button button-primary"
                value="<?php _e( 'SAVE CHANGES', 'vts' ); ?>" />
        </form >      
    </div>
    
</div>
<?php
}
?>
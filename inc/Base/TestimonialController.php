<?php

/**
 * @package CRivasPlugin
 */

namespace Inc\Base;

use Inc\Base\BaseController;

class TestimonialController extends BaseController
{

    public function register()
    {

        if (!$this->activated('testimonial_manager')) {
            return;
        }

        add_action('init', array($this, 'testimonial_cpt'));

        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));

        add_action('save_post', array($this, 'save_meta_box'));
    }

    public function testimonial_cpt()
    {
        $labels = [
            'name' => 'Testimonials',
            'singular_name' => 'Testimonial',

        ];
        $args = [
            'labels' => $labels,
            'public' => true,
            'has_archive' => false,
            'menu_icon' => 'dashicons-testimonial',
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'supports' => array('title', 'editor'),
        ];
        register_post_type('testimonial', $args);
    }

    public function add_meta_boxes()
    {
        add_meta_box(
            'testimonial_author',
            'Testimonial Options',
            array($this, 'render_features_box'),
            'testimonial',
            'side',
            'default'
        );
    }

    public function render_features_box($post)
    {
        wp_nonce_field('crivas_testimonial', 'crivas_testimonial_nonce');

        $data = get_post_meta($post->ID, '_crivas_testimonial_key', true);

        $name = isset($data['name']) ? $data['name'] : '';
        $email = isset($data['email']) ? $data['email'] : '';
        $approved = isset($data['approved']) ? $data['approved'] : false;
        $featured = isset($data['featured']) ? $data['featured'] : false;

        ?>
            <p>
                <label for="crivas_testimonial_author">Testimonial Author</label>
                <input type="text" id="crivas_testimonial_author" name="crivas_testimonial_author" class="widefat" value="<?php echo esc_attr($name); ?>">
            </p>
            <p>
                <label for="crivas_testimonial_email">Testimonial email</label>
                <input type="text" id="crivas_testimonial_email" name="crivas_testimonial_email" class="widefat" value="<?php echo esc_attr($email); ?>">
            </p>
            <div class="meta-container">
                <label class="meta-label w-50 text-left" for="crivas_testimonial_approved">Approved</label>
                <div class="text-right w-50 inline">
                    <div class="ui-toggle inline"><input type="checkbox" id="crivas_testimonial_approved" name="crivas_testimonial_approved" value="1" <?php echo $approved ? 'checked' : ''; ?>>
                        <label for="crivas_testimonial_approved"><div></div></label>
                    </div>
                </div>
            </div>
            <div class="meta-container">
                <label class="meta-label w-50 text-left" for="crivas_testimonial_featured">Featured</label>
                <div class="text-right w-50 inline">
                    <div class="ui-toggle inline"><input type="checkbox" id="crivas_testimonial_featured" name="crivas_testimonial_featured" value="1" <?php echo $featured ? 'checked' : ''; ?>>
                        <label for="crivas_testimonial_featured"><div></div></label>
                    </div>
                </div>
            </div>
        <?php

    }

    public function save_meta_box($post_id)
    {
        if (!isset($_POST['crivas_testimonial_nonce'])) {
            return $post_id;
        }

        $nonce = $_POST['crivas_testimonial_nonce'];

        if (!wp_verify_nonce($nonce, 'crivas_testimonial')) {
            return $post_id;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        $data = [
            'name' => sanitize_text_field($_POST['crivas_testimonial_author']),
            'email' => sanitize_text_field($_POST['crivas_testimonial_email']),
            'approved' => $_POST['crivas_testimonial_approved'] ? 1 : 0,
            'featured' => $_POST['crivas_testimonial_featured'] ? 1 : 0,
        ];

        update_post_meta($post_id, '_crivas_testimonial_key', $data);

    }

}

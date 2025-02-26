<?php
/*
Plugin Name: My Custom Offers Widget
Description: A widget to display offers data from a PHP array.
*/

function my_custom_offers_widget_enqueue_styles() {
    wp_enqueue_style('my-custom-offers-widget-styles', plugin_dir_url(__FILE__) . 'style.css');
}
add_action('wp_enqueue_scripts', 'my_custom_offers_widget_enqueue_styles');

class My_Custom_Offers_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'my_custom_offers_widget',
            __('Custom Offers Widget', 'text_domain'),
            array('description' => __('Displays offers from an array.', 'text_domain'))
        );
    }

    public function widget($args, $instance) {
        $offers = include plugin_dir_path(__FILE__) . 'offers-data.php';
        $allowed_offers = get_option('my_custom_offers_widget_allowed_offers', []);
        if (!is_array($allowed_offers)) {
            $allowed_offers = [];
        }

        if (empty($offers) || empty($allowed_offers)) {
            echo '<p>No offers available.</p>';
            return;
        }

        echo $args['before_widget'];
        echo '<div class="a9x3p_cpm-widget-style-5">';
        echo '<div class="a9x3p_cr-rating-widget-content">';

        $rating = 5.0;
        $minRating = 3.8;

        foreach ($offers as $key => $offer) {
            if (!in_array($key, $allowed_offers, true)) {
                continue;
            }

            $imageSrc = "https://cdn.cdndating.net/images/" . esc_attr($key) . ".png";
            $offerLinkURL = site_url() . "/out/offer.php?id=" . esc_attr($offer['linkID']) . "&o=" . urlencode($key) . "&t=dating";

            if ($rating > $minRating) {
                $rating -= rand(1, 20) / 10;
                $rating = max($rating, $minRating);
            }

            echo '<div class="a9x3p_review-item a9x3p_with-logo">';
            echo '<div class="a9x3p_offer-label"> Best Of The Month </div>';
            echo '<div class="a9x3p_inner-container">';
            echo '<div class="a9x3p_offer-logo a9x3p_partner-link">';
            echo '<img src="' . esc_url($imageSrc) . '" width="72" height="72" class="a9x3p_cr-logotype-thumbnail">';
            echo '</div>';
            echo '<div class="a9x3p_offer-info">';
            echo '<div class="a9x3p_offer-title a9x3p_partner-link">' . esc_html($offer['brandName']) . '</div>';
            echo '<div class="a9x3p_offer-rating"> Score: <span>' . number_format($rating, 1) . '/5</span></div>';
            echo '</div>';
            echo '<a href="' . esc_url($offerLinkURL) . '" class="a9x3p_cr-btn a9x3p_small-rounded a9x3p_partner-link">Visit</a>';
            echo '</div>';
            echo '</div>';
        }

        echo '</div>';
        echo '</div>';
        echo $args['after_widget'];
    }

    public function form($instance) {
        $offers = include plugin_dir_path(__FILE__) . 'offers-data.php';
        $allowed_offers = get_option('my_custom_offers_widget_allowed_offers', []);
        if (!is_array($allowed_offers)) {
            $allowed_offers = [];
        }

        echo '<p>';
        echo '<label for="' . $this->get_field_id('allowed_offers') . '">' . __('Select Offers to Display:', 'text_domain') . '</label>';
        echo '<br>';
        foreach ($offers as $key => $offer) {
            $checked = in_array($key, $allowed_offers, true) ? 'checked' : '';
            echo '<input type="checkbox" name="' . $this->get_field_name('allowed_offers') . '[]" value="' . esc_attr($key) . '" ' . $checked . '> ' . esc_html($offer['brandName']) . '<br>';
        }
        echo '</p>';
    }

    public function update($new_instance, $old_instance) {
        $allowed_offers = isset($new_instance['allowed_offers']) && is_array($new_instance['allowed_offers'])
            ? array_map('sanitize_text_field', $new_instance['allowed_offers'])
            : [];
        update_option('my_custom_offers_widget_allowed_offers', $allowed_offers);
        return $old_instance;
    }
}

function register_my_custom_offers_widget() {
    register_widget('My_Custom_Offers_Widget');
}
add_action('widgets_init', 'register_my_custom_offers_widget');

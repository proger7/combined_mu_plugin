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

        echo $args['before_widget'];

        echo '<div class="mybrides_cpm-widget-style-5">';
        echo '<div class="mybrides_cr-rating-widget-content">';

        $rating = 5.0;
        $minRating = 3.8;

        foreach ($offers as $key => $offer) {
            $imageSrc = "https://cdn.cdndating.net/images/" . esc_attr($key) . ".png";
            $offerLinkURL = site_url() . "/out/offer.php?id=" . esc_attr($offer['linkID']) . "&o=" . urlencode($key) . "&t=dating";

            if ($rating > $minRating) {
                $rating -= rand(1, 20) / 10;
                $rating = max($rating, $minRating);
            }

            echo '<div class="mybrides_review-item mybrides_with-logo">';
            echo '<div class="mybrides_offer-label"> Best Of The Month </div>';
            echo '<div class="mybrides_inner-container">';
            echo '<div class="mybrides_offer-logo mybrides_partner-link">';
            echo '<img src="' . esc_url($imageSrc) . '" width="72" height="72" class="mybrides_cr-logotype-thumbnail">';
            echo '</div>';
            echo '<div class="mybrides_offer-info">';
            echo '<div class="mybrides_offer-title mybrides_partner-link">' . esc_html($offer['brandName']) . '</div>';
            echo '<div class="mybrides_offer-rating"> Score: <span>' . number_format($rating, 1) . '/5</span></div>';
            echo '</div>';
            echo '<a href="' . esc_url($offerLinkURL) . '" class="mybrides_cr-btn mybrides_small-rounded mybrides_partner-link">Visit</a>';
            echo '</div>';
            echo '</div>';
        }

        echo '</div>';
        echo '</div>';

        echo $args['after_widget'];
    }
}

function register_my_custom_offers_widget() {
    register_widget('My_Custom_Offers_Widget');
}
add_action('widgets_init', 'register_my_custom_offers_widget');

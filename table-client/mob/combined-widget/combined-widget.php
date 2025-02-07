<?php
/*
Plugin Name: Combined Widget
Description: A widget to display offers and profiles data from a PHP array.
*/

function combined_widget_enqueue_scripts() {
    wp_enqueue_style('combined-offers-style', site_url('/table-client/mob/combined-widget/style_combined.css'));
    wp_enqueue_script('combined-filter', site_url('/table-client/mob/combined-widget/filter.js'), array('jquery'), null, true);
    wp_localize_script('combined-filter', 'ajax_params', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'combined_widget_enqueue_scripts');

function combined_offers_widget($allowed_offers = []) {
    $offers = include plugin_dir_path(__FILE__) . 'offers-data1.php';

    if (empty($offers)) {
        echo '<p>No offers available.</p>';
        return;
    }

    if (!is_array($allowed_offers) || empty($allowed_offers)) {
        echo '<p>No offers selected.</p>';
        return;
    }

    echo '<div class="mybrides_cpm-widget-style-5">';
    echo '<div class="mybrides_cr-rating-widget-content">';

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
}


function combined_profiles_widget() {
    $data = include plugin_dir_path(__FILE__) . 'offers-data2.php';
    $models = $data['models'];
    $tags = array_unique(array_column($models, 'Tag'));

    echo '<div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_snippet_wrapper">';
    echo '<div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_snippet_title">TOP RATED PROFILES</div>';
    echo '<div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_snippet_filter">';
    echo '<div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_filter">';
    foreach ($tags as $tag) {
        echo '<div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_radio" data-tag="' . esc_attr($tag) . '">' . esc_html($tag) . '</div>';
    }
    echo '</div>';
    echo '<div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_snippet_girls" id="filtered-models">';
    foreach ($models as $key => $model) {
        echo render_model_html($key, $model);
    }
    echo '</div>';
    echo '</div>';
    echo '</div>';
}

function render_model_html($key, $model) {
    $imageUrl = "https://cdn.cdndating.net/images/models/{$key}1.png";
    $profileLink = site_url() . "/profile.php?name=" . urlencode($key) . "&tag=" . urlencode($model['Tag']);
    return '<div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_girl" data-tag="' . esc_attr($model['Tag']) . '">
                <div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_image">
                    <picture _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_header_img">
                        <img _ngcontent-themailorderbride-com-c8="" alt="' . esc_attr($model['Name']) . '" src="' . esc_url($imageUrl) . '" class="ng-lazyloaded">
                    </picture>
                </div>
                <div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_info">
                    <div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_name">' . esc_html($model['Name']) . '</div>
                    <div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_place">' . esc_html($model['Location']) . '</div>
                    <div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_position">' . esc_html($model['Occupation']) . ', ' . esc_html($model['Age']) . '</div>
                    <a _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_send_msg" href="' . esc_url($profileLink) . '">Send Message</a>
                </div>
            </div>';
}

function filter_models_ajax() {
    $data = include plugin_dir_path(__FILE__) . 'offers-data2.php';
    $models = $data['models'];
    $tag = isset($_POST['tag']) ? sanitize_text_field($_POST['tag']) : '';
    $filtered = array_filter($models, fn($model) => $model['Tag'] === $tag);
    foreach ($filtered as $key => $model) {
        echo render_model_html($key, $model);
    }
    wp_die();
}
add_action('wp_ajax_filter_models', 'filter_models_ajax');
add_action('wp_ajax_nopriv_filter_models', 'filter_models_ajax');


class Combined_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct('combined_widget', 'Combined Widget', array('description' => __('A combined widget for offers and profiles.')));
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        $allowed_offers = get_option('combined_widget_allowed_offers', []);
        if (!is_array($allowed_offers)) {
            $allowed_offers = [];
        }

        echo '<div class="offers-section">';
        combined_offers_widget($allowed_offers);
        echo '</div>';

        echo '<div class="profiles-section">';
        combined_profiles_widget();
        echo '</div>';

        echo $args['after_widget'];
    }

    public function form($instance) {
        $offers = include plugin_dir_path(__FILE__) . 'offers-data1.php';
        $allowed_offers = get_option('combined_widget_allowed_offers', []);
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
        update_option('combined_widget_allowed_offers', $allowed_offers);
        return $old_instance;
    }
}

function register_combined_widget() {
    register_widget('Combined_Widget');
}
add_action('widgets_init', 'register_combined_widget');

<?php
/*
Plugin Name: My Custom Profiles Widget
Description: A widget to display profiles from offers-data.php.
*/

function my_custom_profiles_widget_enqueue_styles() {
    wp_enqueue_style('my-custom-profiles-widget-styles', plugin_dir_url(__FILE__) . 'style.css');
    wp_enqueue_script('my-custom-profiles-widget-script', plugin_dir_url(__FILE__) . 'filter.js', array('jquery'), null, true);
    wp_localize_script('my-custom-profiles-widget-script', 'ajax_params', array('ajax_url' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'my_custom_profiles_widget_enqueue_styles');

function filter_models_ajax() {
    $data = include plugin_dir_path(__FILE__) . 'offers-data.php';
    $models = isset($data['models']) ? $data['models'] : [];
    $tag = isset($_POST['tag']) ? sanitize_text_field($_POST['tag']) : '';

    if (!$tag || empty($models)) {
        wp_die();
    }

    $filtered = array_filter($models, function($model) use ($tag) {
        return isset($model['Tag']) && $model['Tag'] === $tag;
    });

    $filtered = array_slice($filtered, 0, 3);

    foreach ($filtered as $key => $model) {
        echo render_model_html($key, $model);
    }
    wp_die();
}
add_action('wp_ajax_filter_models', 'filter_models_ajax');
add_action('wp_ajax_nopriv_filter_models', 'filter_models_ajax');

function render_model_html($key, $model) {
    $imageUrl = "https://cdn.cdndating.net/images/models/{$key}1.png";
    $profileLink = site_url() . "/profile.php?name=" . urlencode($key) . "&tag=" . urlencode($model['Tag']);
    return '<div _ngcontent-themailorderbride-com-c8="" class="g1r5y_girl" data-tag="' . esc_attr($model['Tag']) . '">
                <div _ngcontent-themailorderbride-com-c8="" class="g1r5y_image">
                    <picture _ngcontent-themailorderbride-com-c8="" class="g1r5y_header_img">
                        <img _ngcontent-themailorderbride-com-c8="" alt="' . esc_attr($model['Name']) . '" src="' . esc_url($imageUrl) . '" class="ng-lazyloaded">
                    </picture>
                </div>
                <div _ngcontent-themailorderbride-com-c8="" class="g1r5y_info">
                    <div _ngcontent-themailorderbride-com-c8="" class="g1r5y_name">' . esc_html($model['Name']) . '</div>
                    <div _ngcontent-themailorderbride-com-c8="" class="g1r5y_place">' . esc_html($model['Location']) . '</div>
                    <div _ngcontent-themailorderbride-com-c8="" class="g1r5y_position">' . esc_html($model['Occupation']) . ', ' . esc_html($model['Age']) . '</div>
                    <a _ngcontent-themailorderbride-com-c8="" class="g1r5y_send_msg" href="' . esc_url($profileLink) . '">Send Message</a>
                </div>
            </div>';
}

class My_Custom_Profiles_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'my_custom_profiles_widget',
            __('Custom Profiles Widget', 'text_domain'),
            array('description' => __('Displays profiles from an array.', 'text_domain'))
        );
    }

    public function widget($args, $instance) {
        $data = include plugin_dir_path(__FILE__) . 'offers-data.php';
        $models = isset($data['models']) ? $data['models'] : [];
        $tags = array_unique(array_column($models, 'Tag'));

        echo $args['before_widget'];
        echo '<div _ngcontent-themailorderbride-com-c8="" class="g1r5y_snippet_wrapper">';
        echo '<div _ngcontent-themailorderbride-com-c8="" class="g1r5y_snippet_title">TOP RATED PROFILES</div>';
        echo '<div _ngcontent-themailorderbride-com-c8="" class="g1r5y_snippet_filter">';
        echo '<div _ngcontent-themailorderbride-com-c8="" class="g1r5y_filter">';
        foreach ($tags as $tag) {
            echo '<div _ngcontent-themailorderbride-com-c8="" class="g1r5y_radio" data-tag="' . esc_attr($tag) . '">' . esc_html($tag) . '</div>';
        }
        echo '</div>';
        echo '<div _ngcontent-themailorderbride-com-c8="" class="g1r5y_snippet_girls" id="filtered-models">';
        foreach ($models as $key => $model) {
            echo render_model_html($key, $model);
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo $args['after_widget'];
    }
}

function register_my_custom_profiles_widget() {
    register_widget('My_Custom_Profiles_Widget');
}
add_action('widgets_init', 'register_my_custom_profiles_widget');

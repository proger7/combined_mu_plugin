<?php
/*
Plugin Name: My Custom Profiles Widget
Description: A widget to display profiles from offers-data.php.
*/

function my_custom_profiles_widget_enqueue_styles() {
    wp_enqueue_style('my-custom-profiles-widget-styles', plugin_dir_url(__FILE__) . 'style.css');
}
add_action('wp_enqueue_scripts', 'my_custom_profiles_widget_enqueue_styles');

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
        $models = $data['models'];

        echo $args['before_widget'];

        echo '<div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_snippet_wrapper">';
        echo '<div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_snippet_title">TOP RATED PROFILES</div>';
        echo '<div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_snippet_filter">';
        echo '<div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_filter">';
        echo '<div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_radio theamailorderbride_active ng-star-inserted">RUSSIA </div>';
        echo '<div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_radio ng-star-inserted">UKRAINE </div>';
        echo '<div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_radio ng-star-inserted">ASIA </div>';
        echo '<div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_radio ng-star-inserted">LATIN </div>';
        echo '</div>';
        echo '<div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_snippet_girls">';

        foreach ($models as $key => $model) {
            $i = 1;
            $imageUrl = "https://cdn.cdndating.net/images/models/{$key}{$i}.png";
            $profileLink = site_url() . "/profile.php?name=" . urlencode($key) . "&tag=" . urlencode($model['Tag']);

            echo '<div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_girl ng-star-inserted">';
            echo '<div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_image">';
            echo '<picture _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_header_img">';
            echo '<img _ngcontent-themailorderbride-com-c8="" alt="' . esc_attr($model['Name']) . '" src="' . esc_url($imageUrl) . '" class="ng-lazyloaded">';
            echo '</picture>';
            echo '</div>';
            echo '<div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_info">';
            echo '<div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_name">' . esc_html($model['Name']) . '</div>';
            echo '<div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_place">' . esc_html($model['Location']) . '</div>';
            echo '<div _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_position">' . esc_html($model['Occupation']) . ', ' . esc_html($model['Age']) . '</div>';
            echo '<a _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_send_msg" rel="nofollow noopener" target="_blank" href="' . esc_url($profileLink) . '">';
            echo '<svg _ngcontent-themailorderbride-com-c8="" height="14" viewBox="0 0 19 14" width="19" class="theamailorderbride_snipcss0-6-20-21">
                            <defs _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_snipcss0-7-21-22">
                                <path _ngcontent-themailorderbride-com-c8="" d="M176.27 6514c.954 0 1.73.75 1.73 1.67v10.66c0 .92-.776 1.67-1.73 1.67h-15.54c-.954 0-1.73-.75-1.73-1.67v-10.66c0-.92.776-1.67 1.73-1.67zm-4.639 7l5.117 4.938v-9.876zm-3.096 1.28l7.328-7.072h-14.72zm-7.398 4.502h14.716l-5.113-4.928-1.766 1.702a.644.644 0 0 1-.883.001l-1.812-1.73zm-.885-10.726v9.882l5.142-4.962z" id="lehoa"></path>
                            </defs>
                            <g _ngcontent-themailorderbride-com-c8="" class="theamailorderbride_snipcss0-7-21-23">
                                <g _ngcontent-themailorderbride-com-c8="" clip-path="url(#clip-3F218ABA-BE53-473A-A105-5DFF1E6DD12C)" transform="translate(-159 -6514)" class="theamailorderbride_snipcss0-8-23-24">
                                    <use _ngcontent-themailorderbride-com-c8="" xlink:href="#lehoa" fill="#fff" class="theamailorderbride_snipcss0-9-24-25"></use>
                                </g>
                            </g>
                        </svg>';
            echo '<span _ngcontent-themailorderbride-com-c8="">Send Message</span>';
            echo '</a>';
            echo '</div>';
            echo '</div>';
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

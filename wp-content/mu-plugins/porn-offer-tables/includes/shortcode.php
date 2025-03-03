<?php

if (!defined('ABSPATH')) exit;

add_shortcode('display_porn_tables', 'porn_offer_tables_shortcode');

function porn_offer_tables_shortcode($atts) {
    $data = include __DIR__ . '/../data/porn-offers-data.php';

    $atts = shortcode_atts([
        'tag' => '',
        'limit' => 10,
        'style' => 'default',
    ], $atts);

    $style = $atts['style'];
    $styleNumber = preg_replace('/[^0-9]/', '', $style);
    $pornOffers = $data['porn' . $styleNumber] ?? [];
    $atts['limit'] = max(1, (int)$atts['limit']);

    foreach ($pornOffers as &$offer) {
        $offer['labels'] = [];
        if (isset($offer['bonus_sites']) && $offer['bonus_sites'] > 0) {
            $offer['labels'][] = '$' . $offer['bonus_sites'] . ' Bonus Sites';
        }
        foreach ($offer as $key => $value) {
            if ($value === 'yes' && !in_array($key, ['brandName', 'description', 'price', 'oldPrice', 'discount', 'link', 'logo', 'linkID', 'Tag', 'labels', 'bonus_sites'], true)) {
                $label = ucwords(str_replace('_', ' ', $key));
                $offer['labels'][] = $label;
            }
        }
    }

    $filteredOffers = array_filter($pornOffers, function ($offer) use ($atts) {
        if (empty($offer['linkID']) || empty($offer['brandName']) || empty($offer['labels']) || empty($offer['Tag'])) {
            return false;
        }
        $attsTag = trim($atts['tag']);
        if (!empty($attsTag) && strcasecmp($attsTag, $offer['Tag']) !== 0) {
            return false;
        }
        return true;
    });

    if (empty($filteredOffers)) {
        return '<p>No porn offers found for the specified tag.</p>';
    }

    $filteredOffers = array_map('unserialize', array_unique(array_map('serialize', $filteredOffers)));
    $keys = array_keys($filteredOffers);
    shuffle($keys);
    $keys = array_slice($keys, 0, $atts['limit']);
    $filteredOffers = array_intersect_key($filteredOffers, array_flip($keys));

    porn_offers_table_css($style);

    $post_id = get_the_ID();
    $sidebar_value = get_post_meta($post_id, '_generate-sidebar-layout-meta', true);
    $sidebar_value = !empty($sidebar_value) ? sanitize_title($sidebar_value) : 'default';

    $sidebar_columns = [
        'default' => 2,
        'right-sidebar' => 2,
        'left-sidebar' => 2,
        'no-sidebar' => 3,
        'both-sidebars' => 1,
        'both-left' => 1,
        'both-right' => 1
    ];

    $columns = $sidebar_columns[$sidebar_value] ?? 2;

    if ($style === 'porn1') {
        $output = '<div id="pages-content" class="prn1_d_thumbs-item sort-wrapper" data-columns="' . esc_attr($columns) . '" data-default-columns="' . esc_attr($columns) . '">';
        $output .= '<div id="page-content" class="prn1_d_page-content" data-url="/">';

        $classes = ['prn1_d_flash', 'prn1_d_bonus', 'prn1_d_downloads', 'prn1_d_life'];

        foreach ($filteredOffers as $arr_key => $offer) {
            $offerLinkURL = site_url() . "/out/offer.php?id=" . esc_attr($offer['linkID']) . "&o=" . urlencode($arr_key) . "&t=dating";
            $offerPageURL = "/porn-discounts/" . sanitize_title($offer['brandName']) . "/";

            $output .= '<div class="prn1_d_thumb">';
            $output .= '<div class="prn1_d_item-fix">';
            $output .= '<div class="prn1_d_item">';
            
            $output .= '<div class="prn1_d_img-holder">';
            $output .= '<a href="' . esc_url($offerPageURL) . '">';
            $output .= '<img class="prn1_d_img" loading="lazy" src="' . esc_url($offer['logo']) . '" alt="' . esc_attr($offer['brandName']) . '" width="500" height="280">';
            $output .= '</a>';
            
            $output .= '<div class="prn1_d_content-discount-thumb">' . esc_html($offer['discount']) . '</div>';
            
            $output .= '<div class="prn1_d_content-status">';
            foreach ($offer['labels'] as $index => $label) {
                $class = $classes[$index] ?? '';
                $output .= '<span class="' . esc_attr($class) . '">' . esc_html($label);
                $output .= '<div class="prn1_d_popup-card">' . esc_html($label) . '</div>';
                $output .= '</span>';
            }
            $output .= '</div>';
            
            $output .= '</div>';
            
            $output .= '<div class="prn1_d_content">';
            $output .= '<div class="prn1_d_text">';
            $output .= '<a class="prn1_d_title" href="' . esc_url($offerPageURL) . '">' . esc_html($offer['brandName']) . '</a>';
            $output .= '<span class="prn1_d_descrip">' . esc_html($offer['description']) . '</span>';
            $output .= '</div>';
            
            $output .= '<div class="prn1_d_price">';
            $output .= '<span class="prn1_d_now">$' . esc_html($offer['price']) . '</span>';
            $output .= '<span class="prn1_d_before">$' . esc_html($offer['oldPrice']) . '</span>';
            $output .= '</div>';
            
            $output .= '</div>';
            
            $output .= '</div>';
            
            $output .= '<div class="prn1_d_row-links">';
            $output .= '<a class="prn1_d_btn-thumb prn1_d_buy" href="' . esc_url($offerLinkURL) . '" target="_blank" rel="nofollow">Buy Now</a>';
            $output .= '<a href="' . esc_url($offerPageURL) . '" class="prn1_d_btn-thumb prn1_d_now">View Deal</a>';
            $output .= '</div>';
            
            $output .= '</div>';
            $output .= '</div>';
        }

        $output .= '</div>';
        $output .= '</div>';
    }

    return $output;
}

if (!function_exists('porn_offers_table_css')) {
    function porn_offers_table_css($style) {
        $handle = "porn-style-css-$style";
        $css_path = plugin_dir_path(__FILE__) . "../assets/css/{$style}.css";
        $css_url = plugin_dir_url(__FILE__) . "../assets/css/{$style}.css";

        if (file_exists($css_path)) {
            $version = filemtime($css_path);
            if (!wp_style_is($handle, 'enqueued')) {
                wp_enqueue_style($handle, $css_url, [], $version);
            }
        }
    }
}

function porn_table_dynamic_columns() {
    ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function updateColumns() {
                let container = document.querySelector("#pages-content");
                if (container) {
                    let defaultColumns = container.getAttribute("data-default-columns");
                    let newColumns = window.innerWidth < 986 ? 1 : defaultColumns;
                    container.setAttribute("data-columns", newColumns);
                }
            }

            window.addEventListener("resize", updateColumns);
            updateColumns();
        });
    </script>
    <?php
}
add_action('wp_footer', 'porn_table_dynamic_columns');

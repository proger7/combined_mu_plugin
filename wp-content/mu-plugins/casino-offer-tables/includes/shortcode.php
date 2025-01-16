<?php

if ( ! defined( 'ABSPATH' ) ) exit;

add_shortcode('display_casino_tables', 'casino_offer_tables_shortcode');

function casino_offer_tables_shortcode($atts) {
    $data = include __DIR__ . '/../data/casino-offers-data.php';

    $style = $atts['style'];

    $atts = shortcode_atts([
        'tag' => '',
        'limit' => 10,
        'style' => 'default',
    ], $atts);

    $styleNumber = preg_replace('/[^0-9]/', '', $atts['style']);
    $casinoOffers = $data['casino' . $styleNumber];

    $atts['limit'] = (int)$atts['limit'] > 0 ? (int)$atts['limit'] : 10;


    $filteredOffers = array_filter($casinoOffers, function ($offer) use ($atts) {
        if (!isset($offer['Tag'])) {
            return false;
        }
        $tags = is_array($offer['Tag']) ? $offer['Tag'] : explode(',', $offer['Tag']);
        return empty($atts['tag']) || in_array($atts['tag'], $tags);
    });


    if (empty($filteredOffers)) {
        return 'No casino offers found for the specified tag.';
    }

    $keys = array_keys($filteredOffers);
    shuffle($keys);
    $keys = array_slice($keys, 0, $atts['limit']);
    $filteredOffers = array_intersect_key($filteredOffers, array_flip($keys));

    $output = '';

    enqueue_offers_table_css($style);

    if ($style === 'casino1') {

            $output .= '<div class="event_cas_grw-brand-table-box event_cas_style-1">';

            $count = 1;
            foreach ($filteredOffers as $arr_key => $offer) {
                $offerLinkURL = site_url() . "/out/offer.php?id=" . esc_attr($offer['linkID']) . "&o=" . urlencode($arr_key) . "&t=dating";

                $output .= '<div class="event_cas_brand-card">';
                $output .= '<div class="event_cas_logo-box">';
                $output .= '<div class="event_cas_order-number">' . $count . '</div>'; 

                $output .= '<a href="' . esc_url($offerLinkURL) . '" target="_blank" rel="nofollow">';
                $output .= '<img width="400" height="200" src="' . esc_url($offer['logo']) . '" class="event_cas_casino-logo" alt="' . esc_attr($offer['brandName']) . '" decoding="async">';
                $output .= '</a>';

                $output .= '<div class="event_cas_title">' . esc_html($offer['brandName']) . '</div>';
                $output .= '</div>';
                $output .= '<div class="event_cas_bonus">' . esc_html($offer['bonus']) . '</div>';
                $output .= '<div class="event_cas_rating-review-box">';
                $output .= '<div class="event_cas_rating-box event_cas_good">';
                $output .= '<strong>' . esc_html($offer['rating']) . '</strong>'; 
                $output .= '<span>/5</span>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '<ul class="event_cas_features">';
                $bulletPoints = preg_split('/\r\n|\r|\n/', trim($offer['bulletPoints']));
                foreach ($bulletPoints as $feature) {
                    $output .= '<li>' . esc_html($feature) . '</li>';
                }
                $output .= '</ul>';
                $output .= '<div class="event_cas_buttons">';
                $output .= '<a href="' . esc_url($offerLinkURL) . '" class="event_cas_site" target="_blank" rel="nofollow" data-ga-event="affiliate_click" data-ga-location="casinoTable-Button" data-ga-brand="' . esc_attr($offer['brandName']) . '"> Play Now </a>';
                $output .= '</div>';
                $output .= '</div>';
                $count++;
            }

            $output .= '</div>';

    } elseif ($style === 'casino2') {

                $output .= '<div class="toplist-poker-compact__offers">';

                foreach ($filteredOffers as $arr_key => $offer) {
                    $offerLinkURL = site_url() . "/out/offer.php?id=" . esc_attr($offer['linkID']) . "&o=" . urlencode($arr_key) . "&t=dating";

                    $output .= '<div class="toplist-poker-compact__offer" data-id="' . esc_attr($offer['linkID']) . '" data-offer-name="' . esc_attr($offer['brandName']) . '">';
                    $output .= '<div class="toplist-poker-compact__offer-wrapper">';
                    $output .= '<div class="toplist-poker-compact__offer-inner">';

                    $output .= '<div class="toplist-poker-compact__offer-logo-wrapper">';
                    $output .= '<div class="toplist-poker-compact__offer-label"></div>';
                    $output .= '<a href="' . esc_url($offerLinkURL) . '" class="toplist-poker-compact__offer-logo" title="' . esc_attr($offer['brandName']) . '" target="_blank" rel="nofollow sponsored">';
                    $output .= '<div class="toplist-poker-compact__offer-logo-inner">';
                    $output .= '<img alt="Logo" src="' . esc_url($offer['logo']) . '">';
                    $output .= '</div>';
                    $output .= '</a>';
                    $output .= '</div>';

                    $output .= '<div class="toplist-poker-compact__offer-head">';
                    $output .= '<div class="toplist-poker-compact__offer-brand-name">' . esc_html($offer['brandName']) . '</div>';
                    $output .= '<a href="' . esc_url($offerLinkURL) . '" class="toplist-poker-compact__offer-title">';
                    $output .= '<p>' . esc_html($offer['bonus']) . '</p>';
                    $output .= '</a>';
                    $output .= '</div>';

                    $output .= '<div class="toplist-poker-compact__offer-body snipcss0-4-4-14">';
                    $output .= '<div class="toplist-poker-compact__offer-key-features snipcss0-5-14-15">';
                    $output .= '<ul class="snipcss0-6-15-16">';
                    $bulletPoints = preg_split('/\r\n|\r|\n/', trim($offer['bulletPoints']));
                    foreach ($bulletPoints as $feature) {
                        $output .= '<li class="principales-list-item snipcss0-7-16-17"><span class="list-check-icon snipcss0-8-17-18"></span>' . esc_html($feature) . '</li>';
                    }
                    $output .= '</ul>';
                    $output .= '</div>';
                    $output .= '</div>';

                    $output .= '<div class="toplist-poker-compact__offer-extra snipcss0-4-4-23">';
                    $output .= '<div class="toplist-poker-compact__offer-rating-review-wrapper snipcss0-5-23-24">';
                    $output .= '<div class="toplist-poker-compact__offer-rating-wrapper snipcss0-6-24-25">';
                    $output .= '<div class="toplist-poker-compact__offer-rating-star snipcss0-7-25-26"></div>';
                    $output .= '<div class="toplist-poker-compact__offer-rating snipcss0-7-25-27">' . esc_html($offer['rating']) . '/<span class="snipcss0-8-27-28">10</span></div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '<div class="toplist-poker-compact__offer-rakeback snipcss0-5-23-29">No Rakeback</div>';
                    $output .= '<a href="' . esc_url($offerLinkURL) . '" class="toplist-poker-compact__offer-cta-btn snipcss0-5-23-30" target="_blank" rel="nofollow sponsored">';
                    $output .= '<div class="toplist-poker-compact__offer-cta-btn-icon snipcss0-6-30-31"></div>Sign Up';
                    $output .= '</a>';
                    $output .= '</div>';

                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                }

                $output .= '</div>';

    }

    return $output;
}


if ( ! function_exists( 'enqueue_offers_table_css' ) ) {
    function enqueue_offers_table_css($style) {
        $handle = "casino-style-css-$style";
        $css_url = plugin_dir_url(__FILE__) . "../assets/css/{$style}.css";

        if (!wp_style_is($handle, 'enqueued') && file_exists(plugin_dir_path(__FILE__) . "../assets/css/{$style}.css")) {
            wp_enqueue_style($handle, $css_url, [], '1.0.0');
        }
    }
}
<?php

if ( ! defined( 'ABSPATH' ) ) exit;

add_shortcode('display_casino_tables', 'casino_offer_tables_shortcode');

function casino_offer_tables_shortcode($atts) {
    $data = include __DIR__ . '/../data/casino-offers-data.php';
    $casinoOffers = $data['casino'];

    $style = $atts['style'];

    $atts = shortcode_atts([
        'tag' => '',
        'limit' => 10,
        'style' => 'default',
    ], $atts);


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

    if ($style === 'casino1') {

        $output .= '<div class="event_cas_grw-brand-table-box event_cas_style-1">';

        $count = 1;
        foreach ($filteredOffers as $offer) {
            $output .= '<div class="event_cas_brand-card">';
            $output .= '<div class="event_cas_logo-box">';
            $output .= '<div class="event_cas_order-number">' . $count . '</div>'; 

            $output .= '<img width="400" height="200" src="' . esc_url($offer['logo']) . '" class="event_cas_casino-logo" alt="' . esc_attr($offer['brandName']) . '" decoding="async">';

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
            $output .= '<a href="' . esc_url($offer['link']) . '" class="event_cas_site" target="_blank" rel="nofollow" data-ga-event="affiliate_click" data-ga-location="casinoTable-Button" data-ga-brand="' . esc_attr($offer['brandName']) . '"> Play Now </a>';
            $output .= '</div>';
            $output .= '</div>';
            $count++;
        }

        $output .= '</div>';

    }

    return $output;
}

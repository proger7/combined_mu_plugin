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
        if (
            !isset($offer['Tag'], $offer['linkID'], $offer['brandName'], $offer['rating'], $offer['bonus'], $offer['bulletPoints']) ||
            !is_numeric($offer['rating']) || 
            (float)$offer['rating'] < 0 || 
            (float)$offer['rating'] > 10
        ) {
            return false;
        }

        $tags = array_map('trim', is_array($offer['Tag']) ? $offer['Tag'] : explode(',', $offer['Tag']));
        $attsTag = trim($atts['tag']);

        if (!empty($attsTag) && !in_array($attsTag, $tags)) {
            return false;
        }

        return true;
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

                $output .= '<div class="newhorrizon_toplist-poker-compact__offers">';

                foreach ($filteredOffers as $arr_key => $offer) {
                    $offerLinkURL = site_url() . "/out/offer.php?id=" . esc_attr($offer['linkID']) . "&o=" . urlencode($arr_key) . "&t=dating";

                    $output .= '<div class="newhorrizon_toplist-poker-compact__offer" data-id="' . esc_attr($offer['linkID']) . '" data-offer-name="' . esc_attr($offer['brandName']) . '">';
                    $output .= '<div class="newhorrizon_toplist-poker-compact__offer-wrapper">';
                    $output .= '<div class="newhorrizon_toplist-poker-compact__offer-inner">';

                    $output .= '<div class="newhorrizon_toplist-poker-compact__offer-logo-wrapper">';
                    $output .= '<div class="newhorrizon_toplist-poker-compact__offer-label"></div>';
                    $output .= '<a href="' . esc_url($offerLinkURL) . '" class="newhorrizon_toplist-poker-compact__offer-logo" title="' . esc_attr($offer['brandName']) . '" target="_blank" rel="nofollow sponsored">';
                    $output .= '<div class="newhorrizon_toplist-poker-compact__offer-logo-inner">';
                    $output .= '<img alt="Logo" src="' . esc_url($offer['logo']) . '">';
                    $output .= '</div>';
                    $output .= '</a>';
                    $output .= '</div>';

                    $output .= '<div class="newhorrizon_toplist-poker-compact__offer-head">';
                    $output .= '<div class="newhorrizon_toplist-poker-compact__offer-brand-name">' . esc_html($offer['brandName']) . '</div>';
                    $output .= '<a href="' . esc_url($offerLinkURL) . '" class="newhorrizon_toplist-poker-compact__offer-title">';
                    $output .= '<p>' . esc_html($offer['bonus']) . '</p>';
                    $output .= '</a>';
                    $output .= '</div>';

                    $output .= '<div class="newhorrizon_toplist-poker-compact__offer-body">';
                    $output .= '<div class="newhorrizon_toplist-poker-compact__offer-key-features">';
                    $output .= '<ul>';
                    $bulletPoints = preg_split('/\r\n|\r|\n/', trim($offer['bulletPoints']));
                    foreach ($bulletPoints as $feature) {
                        $output .= '<li class="newhorrizon_principales-list-item"><span class="newhorrizon_list-check-icon"></span>' . esc_html($feature) . '</li>';
                    }
                    $output .= '</ul>';
                    $output .= '</div>';
                    $output .= '</div>';

                    $output .= '<div class="newhorrizon_toplist-poker-compact__offer-extra">';
                    $output .= '<div class="newhorrizon_toplist-poker-compact__offer-rating-review-wrapper">';
                    $output .= '<div class="newhorrizon_toplist-poker-compact__offer-rating-wrapper">';
                    $output .= '<div class="newhorrizon_toplist-poker-compact__offer-rating-star"></div>';
                    $output .= '<div class="newhorrizon_toplist-poker-compact__offer-rating">' . esc_html($offer['rating']) . '/<span>10</span></div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '<div class="newhorrizon_toplist-poker-compact__offer-rakeback">No Rakeback</div>';
                    $output .= '<a href="' . esc_url($offerLinkURL) . '" class="newhorrizon_toplist-poker-compact__offer-cta-btn" target="_blank" rel="nofollow sponsored">';
                    $output .= '<div class="newhorrizon_toplist-poker-compact__offer-cta-btn-icon"></div>Sign Up';
                    $output .= '</a>';
                    $output .= '</div>';

                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                }

                $output .= '</div>';


    } elseif ($style === 'casino3') {

        $output .= '<div class="stjamestheatre_brands-collection">';

        $count = 1;
        foreach ($filteredOffers as $arr_key => $offer) {
            $offerLinkURL = site_url() . "/out/offer.php?id=" . esc_attr($offer['linkID']) . "&o=" . urlencode($arr_key) . "&t=dating";

            $output .= '<div class="stjamestheatre_brands-collection__item">';
            $output .= '<div class="stjamestheatre_brands-collection__num">' . $count . '</div>';
            $output .= '<a href="' . esc_url($offerLinkURL) . '" class="stjamestheatre_brands-collection__logo" target="_blank" rel="nofollow">';
            $output .= '<img decoding="async" src="' . esc_url($offer['logo']) . '" alt="' . esc_attr($offer['brandName']) . '">';
            $output .= '</a>';

            $output .= '<div class="stjamestheatre_brands-collection__content">';
            $output .= '<div class="stjamestheatre_brands-collection__title">' . esc_html($offer['brandName']) . '</div>';
            $output .= '<div class="stjamestheatre_brands-collection__bonus">' . esc_html($offer['bonus']) . '</div>';
            $output .= '</div>';

            $output .= '<div class="stjamestheatre_brands-collection__rating">';
            $output .= '<div class="stjamestheatre_brands-collection__rating__label">Rating: ' . esc_html($offer['rating']) . '/5</div>';
            $output .= '<div class="stjamestheatre_brands-collection__rating__stars">';
            for ($i = 1; $i <= 5; $i++) {
                $output .= '<span class="stjamestheatre_style-star">' . ($i <= floor($offer['rating']) ? '★' : '☆') . '</span>';
            }
            $output .= '</div>';
            $output .= '</div>';

            $output .= '<a href="' . esc_url($offerLinkURL) . '" class="stjamestheatre_brands-collection__btn" target="_blank" rel="nofollow"> Play now </a>';
            $output .= '</div>';

            $count++;
        }

        $output .= '</div>';

    } elseif ($style === 'casino4') {

        $output = '<div class="cardplayer_toplist-cardplayer__offers snipcss-ZdxVN">';

        $count = 1;
        foreach ($filteredOffers as $arr_key => $offer) {
            $offerLinkURL = site_url() . "/out/offer.php?id=" . esc_attr($offer['linkID']) . "&o=" . urlencode($arr_key) . "&t=dating";

            $output .= '<div class="cardplayer_toplist-cardplayer__offer" data-offer-name="' . esc_attr($offer['brandName']) . '">';
            $output .= '<div class="cardplayer_toplist-cardplayer__offer-inner">';
            $output .= '<div class="cardplayer_toplist-cardplayer__offer-logo-wrapper">';
            $output .= '<a class="cardplayer_toplist-cardplayer__offer-logo" href="' . esc_url($offerLinkURL) . '" target="_blank" rel="nofollow sponsored">';
            $output .= '<img alt="' . esc_attr($offer['brandName']) . ' Logo" src="' . esc_url($offer['logo']) . '">';
            $output .= '</a>';
            $output .= '</div>';
            $output .= '<div class="cardplayer_toplist-cardplayer__offer-rating">';
            $output .= '<div class="cardplayer_toplist-cardplayer__offer-rating-score">' . esc_html($offer['rating']) . '</div>';
            $output .= '<div class="cardplayer_toplist-cardplayer__offer-rating-max">/ 10</div>';
            $output .= '</div>';
            $output .= '<div class="cardplayer_toplist-cardplayer__offer-brand-name-wrapper">';
            $output .= '<div class="cardplayer_toplist-cardplayer__offer-position"># ' . $count . '</div>';
            $output .= '<div class="cardplayer_toplist-cardplayer__brand-name">' . esc_html($offer['brandName']) . '</div>';
            $output .= '</div>';
            $output .= '<div class="cardplayer_toplist-cardplayer__offer-title">';
            $output .= '<p>' . esc_html($offer['bonus']) . '</p>';
            $output .= '</div>';
            $output .= '<ul class="cardplayer_toplist-cardplayer__offer-key-features">';
            $bulletPoints = preg_split('/\r\n|\r|\n/', trim($offer['bulletPoints']));
            foreach ($bulletPoints as $feature) {
                if (!empty($feature)) {
                    $output .= '<li class="cardplayer_principales-list-item"><span class="cardplayer_list-check-icon"></span>' . esc_html($feature) . '</li>';
                }
            }
            $output .= '</ul>';
            $output .= '<div class="cardplayer_toplist-cardplayer__offer-actions">';
            $output .= '<a class="cardplayer_toplist-cardplayer__offer-cta-btn" href="' . esc_url($offerLinkURL) . '" target="_blank" rel="nofollow sponsored"> Play Now </a>';
            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';

            $count++;
        }

        $output .= '</div>';

        return $output;

    } elseif ($style === 'casino5') {

            $output = '<div class="endoflifecareambitions_css-xd7n3k snipcss-kbt4b">';

            foreach ($filteredOffers as $arr_key => $offer) {
                $offerLinkURL = site_url() . "/out/offer.php?id=" . esc_attr($offer['linkID']) . "&o=" . urlencode($arr_key) . "&t=dating";

                $output .= '<div class="endoflifecareambitions_css-1e84buh endoflifecareambitions_style-L4Uw9" onclick="window.open(\'' . esc_url($offerLinkURL) . '\', \'_blank\');" id="endoflifecareambitions_style-L4Uw9">';
                $output .= '<div class="endoflifecareambitions_css-h9u7nh">';
                $output .= '<div class="group endoflifecareambitions_css-oxdvdj">';
                $output .= '<div class="endoflifecareambitions_css-11kqtnt">';
                $output .= '<div class="endoflifecareambitions_css-0"><img alt="' . esc_attr($offer['brandName']) . ' Logo" class="endoflifecareambitions_css-1x39tyh" data-nimg="1" decoding="async" height="100" loading="lazy" src="' . esc_url($offer['logo']) . '" style="color:transparent" width="200"></div>';
                $output .= '</div>';
                $output .= '<div class="endoflifecareambitions_css-5656ht">';
                $output .= '<div class="endoflifecareambitions_css-17xwonx">';
                $output .= '<div class="endoflifecareambitions_css-18b9jja">';
                $output .= '<div class="endoflifecareambitions_css-1ood773">' . esc_html($offer['brandName']) . '</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '<div class="endoflifecareambitions_css-1r2us4v">';
                $output .= '<div class="endoflifecareambitions_css-hd5v0">';
                $output .= '<div class="endoflifecareambitions_css-uauz28">';

                $bulletPoints = preg_split('/\r\n|\r|\n/', trim($offer['bulletPoints']));
                foreach ($bulletPoints as $feature) {
                    if (!empty($feature)) {
                        $output .= '<div><svg class="endoflifecareambitions_css-1gg81p8" fill="currentColor" height="1em" stroke="currentColor" stroke-width="0" viewBox="0 0 512 512" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z"></path></svg> ' . esc_html($feature) . '</div>';
                    }
                }

                $output .= '</div>';
                $output .= '</div>';
                $output .= '<div class="endoflifecareambitions_css-il5spi"></div>';
                $output .= '</div>';
                $output .= '<div class="endoflifecareambitions_css-866mno">';
                $output .= '<div class="endoflifecareambitions_css-12vzzte">';
                $output .= '<div class="endoflifecareambitions_css-1c4nzka">Our Score</div>';
                $output .= '<div class="endoflifecareambitions_css-xbf2mi"><span>' . esc_html($offer['rating']) . '</span></div>';
                $output .= '</div>';
                $output .= '<div class="endoflifecareambitions_css-1scg9ky">';
                $output .= '<div>';
                $output .= '<div id="endoflifecareambitions_style-wCVFy" class="endoflifecareambitions_style-wCVFy">';

                $rating = floatval($offer['rating']);
                $fullStars = floor($rating / 2);
                $halfStar = ($rating % 2) >= 0.5;

                for ($i = 0; $i < 5; $i++) {
                    if ($i < $fullStars) {
                        $output .= '<span class="endoflifecareambitions_style-itfUx" style="color: rgb(255, 215, 0);"><svg fill="currentColor" height="1em" stroke="currentColor" stroke-width="0" viewBox="0 0 576 512" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path></svg></span>';
                    } elseif ($i === $fullStars && $halfStar) {
                        $output .= '<span class="endoflifecareambitions_style-itfUx" style="color: rgb(255, 215, 0);"><svg fill="currentColor" height="1em" stroke="currentColor" stroke-width="0" viewBox="0 0 576 512" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path></svg></span>';
                    } else {
                        $output .= '<span class="endoflifecareambitions_style-itfUx" style="color: gray;"><svg fill="currentColor" height="1em" stroke="currentColor" stroke-width="0" viewBox="0 0 576 512" width="1em" xmlns="http://www.w3.org/2000/svg"><path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path></svg></span>';
                    }
                }

                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '<div class="endoflifecareambitions_css-zjr4vk"><button class="endoflifecareambitions_css-rgftw8">GET BONUS</button></div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
            }

            $output .= '</div>';

            return $output;

    } elseif ($style === 'casino6') {

                $output = '<div class="bigpotential_jbs_y-9qj bigpotential_kb_c-qth bigpotential_snipcss-hPgoh">';

                $count = 1;

                foreach ($filteredOffers as $arr_key => $offer) {
                    $offerLinkURL = site_url() . "/out/offer.php?id=" . esc_attr($offer['linkID']) . "&o=" . urlencode($arr_key) . "&t=dating";

                    $output .= '<div class="bigpotential_jn_wx-sta">';
                    $output .= '<div class="bigpotential_p_oka-yvo">';

                    if ($count === 1) {
                        $output .= '<span class="bigpotential_ba-gf-h9a"><span class="bigpotential_lg_dk-942"><span>Best UK Casino Games</span></span><span class="bigpotential_ba-gf-a14" style="border-top-color:#334dfe"></span></span>';
                    }

                    $output .= '<div class="bigpotential_r_lak-en7">';
                    $output .= '<div class="bigpotential_jbs_y-y2r">' . esc_html($count) . '</div>';
                    $output .= '<figure><img fetchpriority="high" decoding="async" width="800" height="540" src="https://casinocdn.co.uk/images/' . esc_attr($arr_key) . '.png" class="bigpotential_rg_jas-dod bigpotential_m_jo-img-h2b"></figure>';
                    $output .= '</div>';

                    $output .= '<div class="bigpotential_jbs_y-9ak">';
                    $output .= '<div class="bigpotential_ez_o-s16">';
                    $output .= '<h3 class="bigpotential_lg_dk-fvg bigpotential_m_jo-h3-e1z"><a href="' . esc_url($offerLinkURL) . '" class="bigpotential_m_jo-a-jy3" target="_blank">' . esc_html($offer['brandName']) . '</a></h3>';
                    $output .= '<div class="bigpotential_jbs_y-e34">';

                    $bulletPoints = preg_split('/\r\n|\r|\n/', trim($offer['bulletPoints']));
                    foreach ($bulletPoints as $feature) {
                        if (!empty($feature)) {
                            $output .= '✔️ ' . esc_html($feature) . '<br>';
                        }
                    }

                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';

                    $output .= '<div class="bigpotential_jbs_y-sxz">';
                    $output .= '<div><a href="' . esc_url($offerLinkURL) . '" class="bigpotential_gfj_a-i5n bigpotential_m_jo-a-jy3" target="_blank">' . esc_html($offer['bonus']) . '</a></div>';
                    $output .= '</div>';

                    $output .= '</div>';
                    $output .= '</div>';

                    $count++;
                }

                $output .= '</div>';

                return $output;


    }

    return $output;
}


if (!function_exists('enqueue_offers_table_css')) {
    function enqueue_offers_table_css($style) {
        $handle = "casino-style-css-$style";
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

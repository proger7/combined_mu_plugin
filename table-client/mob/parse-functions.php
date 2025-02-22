<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'customDisplayModelsApp' ) ) {
    function customDisplayModelsApp($atts) {

        $data = include __DIR__ . '/offers-data.php';
        $modelsArray = $data['models'];
        $offersArray = $data['offers'];
        $brandsArray = $data['brands'];

        $atts = shortcode_atts([
            'tag' => '',
            'offer' => '',
            'limit' => 10,
            'style' => 'site1',
        ], $atts);

        $atts['limit'] = (int)$atts['limit'] > 0 ? (int)$atts['limit'] : 10;

        custom_mi_enqueue_models_app_css($atts['style']);

        $style = $atts['style'];

        $filteredModels = array_filter($modelsArray, function ($model) use ($atts) {
            $tags = is_array($model['Tag']) ? $model['Tag'] : explode(',', $model['Tag']);
            return empty($atts['tag']) || in_array($atts['tag'], $tags);
        });

        if (empty($filteredModels)) {
            return 'No models found for the specified tag.';
        }

        $keys = array_keys($filteredModels);
        shuffle($keys);
        $keys = array_slice($keys, 0, $atts['limit']);
        $filteredModels = array_intersect_key($filteredModels, array_flip($keys));

        $offers = array_filter(array_map('trim', explode(',', $atts['offer'])), function ($offer) use ($offersArray) {
            return isset($offersArray[$offer]);
        });

        $getOfferDetails = function($offers, $brandsArray, $offersArray) {
            if (!empty($offers)) {
                $randomOfferKey = $offers[array_rand($offers)];
                $offerName = isset($brandsArray[$randomOfferKey]) ? $brandsArray[$randomOfferKey]['brandName'] : '';
                $offerLink = isset($offersArray[$randomOfferKey]['linkID']) ? "/out/offer.php?linkID={$offersArray[$randomOfferKey]['linkID']}" : '';
                return [
                    'key' => $randomOfferKey,
                    'name' => $offerName,
                    'link' => $offerLink,
                ];
            }
            return [
                'key' => '',
                'name' => '',
                'link' => '',
            ];
        };

        $output = '';

        if ($style == 'site1') {

            $count = count($filteredModels);
            $columns = $count > 3 ? 3 : $count;
            $width = 100 / $columns;

            $output = '<div class="g5oXi5dh9a_tns-ovh">';
            $output .= '<div class="g5oXi5dh9a_tns-inner" id="g5oXi5dh9a_tns1-iw">';
            $output .= '<div class="g5oXi5dh9a_profiles-slider g5oXi5dh9a_tns-slider g5oXi5dh9a_tns-subpixel g5oXi5dh9a_tns-horizontal g5oXi5dh9a_style-91lpw" id="g5oXi5dh9a_tns1" style="--item-width-site1: ' . $width . '%;">';

            foreach ($filteredModels as $key => $model) {

                $offerDetails = $getOfferDetails($offers, $brandsArray, $offersArray);
                $imageUrl = "https://cdn.cdndating.net/images/models/{$key}1.png";

                $output .= '<div class="g5oXi5dh9a_tns-item">';
                $output .= '<div class="g5oXi5dh9a_profile-item">';
                $output .= '<div class="g5oXi5dh9a_profile-image-wrapper">';
                $output .= '<div class="g5oXi5dh9a_profile-label">';
                $output .= '<div class="g5oXi5dh9a_icon"><svg width="32" height="32" viewBox="0 0 32 32" fill="#2fc85a" xmlns="http://www.w3.org/2000/svg"><rect x="7.95898" y="7" width="15.9179" height="17" fill="white"></rect><path fill-rule="evenodd" clip-rule="evenodd" d="M16.7185 0.350103L18.7624 2.69534L21.8192 1.39198C22.3144 1.18226 22.8848 1.45229 23.0429 1.96625L23.9756 4.98883L27.2911 5.04778C27.8271 5.05634 28.2466 5.53474 28.1804 6.06986L27.8114 9.21575L30.8171 10.6258C31.272 10.84 31.4691 11.3846 31.2559 11.8423C30.8462 12.6956 30.1043 13.7955 29.6024 14.6425L31.7793 17.1624C32.1308 17.5701 32.0525 18.2007 31.615 18.5103L29.0432 20.3371L30.0121 23.5275C30.1688 24.0478 29.8433 24.5856 29.3154 24.6905L26.2313 25.3079L25.8265 28.6168C25.7576 29.1834 25.1925 29.5497 24.6534 29.3836L21.6464 28.6982L19.9378 31.5543C19.6606 32.0192 19.0418 32.1416 18.6111 31.8184L16.0854 29.9233L13.368 31.8347C12.9229 32.147 12.3171 32.0012 12.0516 31.5291L10.5149 28.7698L7.25444 29.4062C6.70013 29.5124 6.19104 29.0956 6.17179 28.5335L5.88971 25.4371L2.65832 24.6864C2.12953 24.5645 1.82775 24.0122 1.99834 23.4987L3.01159 20.5013L0.362717 18.4932C-0.0939854 18.1471 -0.122641 17.4716 0.295107 17.0859L2.3834 14.8167L0.77554 11.8994C0.511817 11.4228 0.719124 10.8265 1.21478 10.6123L4.10409 9.36517L3.81619 6.04151C3.76694 5.46814 4.25409 4.99378 4.81735 5.04869L7.88532 5.09054L8.96663 1.937C9.14976 1.40143 9.76317 1.16245 10.2579 1.42394L13.0716 2.7291L15.334 0.292046C15.7178 -0.122456 16.3724 -0.0891516 16.7185 0.350103ZM8.53142 16.3487C7.3216 15.1326 9.1614 13.2829 10.3717 14.499L14.4471 18.5958L21.5837 10.6442C22.725 9.36922 24.657 11.1159 23.5153 12.3918L15.5042 21.3173C15.0184 21.9177 14.1206 21.9667 13.5744 21.4172L8.53142 16.3487Z" fill="#2fc85a"></path></svg></div>';
                $output .= '</div>';
                $output .= '<span class="g5oXi5dh9a_partner-link"><img src="' . esc_url($imageUrl) . '" width="330" height="220" class="g5oXi5dh9a_profile-image g5oXi5dh9a_lazyloaded" alt="' . esc_attr($model['Name']) . '"></span>';
                $output .= '</div>';
                $output .= '<div class="g5oXi5dh9a_profile-item-content">';
                $output .= '<div class="g5oXi5dh9a_profile-name">';
                $output .= '<span class="g5oXi5dh9a_partner-link">' . esc_html($model['Name']) . ', ' . esc_html($model['Age']) . '</span>';
                $output .= '</div>';
                $output .= '<div class="g5oXi5dh9a_profile-offer-online">';
                $output .= '<span class="g5oXi5dh9a_partner-link">Online at ' . esc_html($offerDetails['name']) . '</span>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
            }

            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';

        } elseif ($style == 'site2') {

            $output = '<div class="ydfj43Hfdh347_profiles-grid">';

            foreach ($filteredModels as $key => $model) {
                $offerDetails = $getOfferDetails($offers, $brandsArray, $offersArray);
                $link = $offerDetails['link'];
                $offerName = $offerDetails['name'];

                $output .= '<div class="ydfj43Hfdh347_profile-grid-item">';
                $output .= '<div class="ydfj43Hfdh347_tns-outer">';
                $output .= '<div class="ydfj43Hfdh347_tns-controls"><button type="button" data-controls="prev">‹</button><button type="button" data-controls="next">›</button></div>';
                $output .= '<div class="ydfj43Hfdh347_tns-visually-hidden">slide <span>1</span> of 5</div>';
                $output .= '<div id="tns1-mw" class="ydfj43Hfdh347_tns-ovh ydfj43Hfdh347_tns-ah ydfj43Hfdh347_style-oWeJE">';
                $output .= '<div id="tns1-iw">';
                $output .= '<div class="ydfj43Hfdh347_profile-top-side ydfj43Hfdh347_tns-slider ydfj43Hfdh347_tns-subpixel ydfj43Hfdh347_tns-horizontal ydfj43Hfdh347_style-99FO2" id="tns1">';

                for ($i = 1; $i <= 4; $i++) {
                    $imageUrl = "https://cdn.cdndating.net/images/models/{$key}{$i}.png";
                    $output .= '<div class="ydfj43Hfdh347_item ydfj43Hfdh347_tns-item">';
                    $output .= '<img src="' . esc_url($imageUrl) . '" width="230" height="280" class="ydfj43Hfdh347_loaded ydfj43Hfdh347_lazyloaded">';
                    if ($i == 4) {
                        $output .= '<div class="ydfj43Hfdh347_more">' . esc_html($model['Name']) . ' has more photos!<br>Do you want to watch?';
                        $output .= '<div class="ydfj43Hfdh347_profile-all-photos-button ydfj43Hfdh347_partner-link"><a href="' . esc_url($link) . '" class="ydfj43Hfdh347_profile-button ydfj43Hfdh347_partner-link-view">View photos</a></div>';
                        $output .= '</div>';
                    }
                    $output .= '</div>';
                }

                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '<div class="ydfj43Hfdh347_tns-nav">';
                for ($i = 0; $i < 5; $i++) {
                    $output .= '<button type="button" class="' . ($i == 0 ? 'ydfj43Hfdh347_tns-nav-active' : '') . '"></button>';
                }
                $output .= '</div>';
                $output .= '</div>';
                $output .= '<div class="ydfj43Hfdh347_profile-bottom-side">';
                $output .= '<div class="ydfj43Hfdh347_profile-info">';
                $output .= '<div class="ydfj43Hfdh347_profile-name">';
                $output .= '<span class="ydfj43Hfdh347_partner-link">' . esc_html($model['Name']) . ', ' . esc_html($model['Age']) . '</span>';
                $output .= '</div>';
                $output .= '<div class="ydfj43Hfdh347_profile-location">' . esc_html($model['Occupation']) . '</div>';
                $output .= '<div class="ydfj43Hfdh347_profile-website"> From: <span class="ydfj43Hfdh347_profile-website-link ydfj43Hfdh347_partner-link">' . esc_html($model['Location']) . '</span></div>';
                $output .= '</div>';
                $output .= '<a href="' . esc_url($link) . '" class="ydfj43Hfdh347_profile-button ydfj43Hfdh347_partner-link">Visit Profile</a>';
                $output .= '</div>';
                $output .= '</div>';
            }

            $output .= '</div>';


        } elseif ($style == 'site3') {

                $output = '<div class="hiero347Gdsfh_reviews-list">';
                $currentIndex = 0;

                foreach ($filteredModels as $key => $model) {
                    $offerDetails = $getOfferDetails($offers, $brandsArray, $offersArray);
                    $link = $offerDetails['link'];
                    $offerName = $offerDetails['name'];
                    $imageUrl = "https://cdn.cdndating.net/images/models/{$key}1.png";

                    $popularClass = $currentIndex === 0 ? 'hiero347Gdsfh_review-item-popular' : '';
                    $popularRibbon = $currentIndex === 0 ? '<div class="hiero347Gdsfh_review-item-ribbon"><span>Most Popular Choice</span></div>' : '';

                    $output .= '<div class="hiero347Gdsfh_review-item ' . esc_attr($popularClass) . '">';
                    $output .= $popularRibbon;
                    $output .= '<div class="hiero347Gdsfh_review-item-grid">';
                    $output .= '<div class="hiero347Gdsfh_review-item-column">';
                    $output .= '<div class="hiero347Gdsfh_logo hiero347Gdsfh_partner-link">';
                    $output .= '<img src="' . esc_url($imageUrl) . '" width="240" height="300" class="hiero347Gdsfh_lazyloaded" alt="' . esc_attr($model['Name']) . '">';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '<div class="hiero347Gdsfh_review-item-column hiero347Gdsfh_review-item-column-content">';
                    $output .= '<div class="hiero347Gdsfh_review-item-info">';
                    $output .= '<a href="' . esc_url($link) . '" class="hiero347Gdsfh_review-title">' . esc_html($model['Name']) . '</a>';
                    $output .= '<div class="hiero347Gdsfh_cr-rating-stars"><div class="hiero347Gdsfh_fill" style="width: 100%;"></div></div>';
                    $output .= '<p>' . esc_html($model['Interests']) . '</p>';
                    $output .= '</div>';
                    $output .= '<div class="hiero347Gdsfh_review-item-bottom">';
                    $output .= '<div class="hiero347Gdsfh_review-item-average-age">Average Girls Age <div class="hiero347Gdsfh_review-item-average-age-count">' . esc_html($model['Age']) . '</div></div>';
                    $output .= '<div class="hiero347Gdsfh_review-item-rating">Our Score <div class="hiero347Gdsfh_review-item-overall-rating"><div>5.0</div></div></div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '<div class="hiero347Gdsfh_review-item-column hiero347Gdsfh_review-item-column-action">';
                    $output .= '<div class="hiero347Gdsfh_review-item-buttons">';
                    $output .= '<a href="' . esc_url($link) . '" class="hiero347Gdsfh_cr-btn hiero347Gdsfh_square hiero347Gdsfh_partner-link">Visit Site</a>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $currentIndex++;
                }

                $output .= '</div>';


        } elseif ($style == 'site4') {

                $output = '<div class="yfg6Ghh54ffj48_profiles-grid">';

                foreach ($filteredModels as $key => $model) {
                    $offerDetails = $getOfferDetails($offers, $brandsArray, $offersArray);
                    $link = $offerDetails['link'];
                    $offerName = $offerDetails['name'];

                    $output .= '<div class="yfg6Ghh54ffj48_profile-grid-item">';
                    $output .= '<div class="yfg6Ghh54ffj48_tns-outer">';
                    $output .= '<div class="yfg6Ghh54ffj48_tns-controls">';
                    $output .= '<button type="button" data-controls="prev">‹</button>';
                    $output .= '<button type="button" data-controls="next">›</button>';
                    $output .= '</div>';
                    $output .= '<div class="yfg6Ghh54ffj48_tns-visually-hidden">slide <span>1</span> of 5</div>';
                    $output .= '<div id="tns1-mw" class="yfg6Ghh54ffj48_tns-ovh yfg6Ghh54ffj48_tns-ah style-qZdYU">';
                    $output .= '<div id="tns1-iw">';
                    $output .= '<div class="yfg6Ghh54ffj48_profile-top-side yfg6Ghh54ffj48_tns-slider yfg6Ghh54ffj48_tns-subpixel yfg6Ghh54ffj48_tns-horizontal style-YQhZ3" id="tns1">';

                    for ($i = 1; $i <= 4; $i++) {
                        $imageUrl = "https://cdn.cdndating.net/images/models/{$key}{$i}.png";

                        $output .= '<div class="yfg6Ghh54ffj48_item yfg6Ghh54ffj48_tns-item">';
                        $output .= '<img src="' . esc_url($imageUrl) . '" width="230" height="280" class="yfg6Ghh54ffj48_loaded yfg6Ghh54ffj48_lazyloaded">';
                        if ($i == 4) {
                            $output .= '<div class="yfg6Ghh54ffj48_more"> ' . esc_html($model['Name']) . ' has more photos!<br>Do you want to watch? <div class="yfg6Ghh54ffj48_profile-all-photos-button yfg6Ghh54ffj48_partner-link"><a href="' . esc_url($link) . '" target="_blank" class="yfg6Ghh54ffj48_profile-button yfg6Ghh54ffj48_partner-link-view"> View photos </a></div></div>';
                        }
                        $output .= '</div>';
                    }

                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '<div class="yfg6Ghh54ffj48_tns-nav">';
                    for ($i = 0; $i < 5; $i++) {
                        $output .= '<button type="button" style="' . ($i == 0 ? '' : '') . '" class="' . ($i == 0 ? 'yfg6Ghh54ffj48_tns-nav-active' : '') . '"></button>';
                    }
                    $output .= '</div>';
                    $output .= '</div>';

                    $output .= '<div class="yfg6Ghh54ffj48_profile-bottom-side">';
                    $output .= '<div class="yfg6Ghh54ffj48_profile-info">';
                    $output .= '<div class="yfg6Ghh54ffj48_profile-name">';
                    $output .= '<span class="yfg6Ghh54ffj48_partner-link">' . esc_html($model['Name']) . ', ' . esc_html($model['Age']) . '</span>';
                    $output .= '</div>';
                    $output .= '<div class="yfg6Ghh54ffj48_profile-location">' . esc_html($model['Location']) . '</div>';
                    $output .= '<div class="yfg6Ghh54ffj48_profile-website"> From: <span class="yfg6Ghh54ffj48_profile-website-link yfg6Ghh54ffj48_partner-link">' . esc_html($offerName) . '</span></div>';
                    $output .= '</div>';
                    $output .= '<a href="' . esc_url($link) . '" class="yfg6Ghh54ffj48_profile-button yfg6Ghh54ffj48_partner-link"> Find Me </a>';
                    $output .= '</div>';

                    $output .= '</div>';
                }

                $output .= '</div>';

        }

        return $output;
    }
}

add_shortcode('display_models_app', 'customDisplayModelsApp');



/**
 * Enqueue CSS for the models app.
 *
 * @param string $style The style file name.
 */
if ( ! function_exists( 'custom_mi_enqueue_models_app_css' ) ) {
    function custom_mi_enqueue_models_app_css($style) {
        $handle = "offers-brand-table-css-$style";
        $css_url = site_url() . "/table-client/mob/inc/{$style}.css";

        if (!wp_style_is($handle, 'enqueued') && file_exists(ABSPATH . "table-client/mob/inc/{$style}.css")) {
            wp_enqueue_style($handle, $css_url, array(), '1.0.0');
        }
    }
}



if ( ! function_exists( 'customUpdatedTables' ) ) {
    function customUpdatedTables($atts) {
        global $externalTableSettings, $isCloakActive, $updatedOffersArray;

        if (empty($updatedOffersArray)) {
            $updatedOffersArray = include __DIR__ . '/offers-data.php';
            $updatedOffersArray = $updatedOffersArray['offers'];
        }

        $atts = shortcode_atts(array(
            'offers' => 'povr',
            'tag' => '',
            'style' => 'style1',
        ), $atts);

        if (!$isCloakActive || ($isCloakActive && !cloakIPChecker())) {
            enqueue_offers_table_css($atts['style']);

            $offerKeys = array_map('trim', explode(',', $atts['offers']));
            $filteredOffersArray = array_filter($updatedOffersArray, function($key) use ($offerKeys) {
                return in_array($key, $offerKeys);
            }, ARRAY_FILTER_USE_KEY);

            return customUpdatedTableLayouts($atts, $filteredOffersArray);
        }

        return '';
    }

    add_shortcode('new_table', 'customUpdatedTables');
}

if ( ! function_exists( 'customUpdatedTableLayouts' ) ) {
    function customUpdatedTableLayouts($atts, $updatedOffersArray) {
        $style = $atts['style'];
        $tableHTML = '';

        enqueue_offers_table_css($style);

        if ($style == 'style1') {
                $tableHTML .= '<div class="sdJ8dsh97_cr-table-style-23 sdJ8dsh97_cr-rating-table ' . esc_attr($atts['style']) . '">';
                $tableHTML .= '<div class="sdJ8dsh97_table-head">
                                    <div class="sdJ8dsh97_editors-choice">Casual Dating Site</div>
                                    <div class="sdJ8dsh97_rating-meta">
                                        <div class="sdJ8dsh97_reviews-updated">
                                            <svg width="18" height="25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.5967 6.77552c.2198.21967.2198.57582 0 .79549L9.23738 15.9254c-.2198.2197-.57617.2197-.79597 0l-4.00703-4.0046c-.2198-.2197-.2198-.5759 0-.7955l.7428-.7424c.21981-.2197.57617-.2197.79597 0l2.86625 2.8645 7.2185-7.21424c.2198-.21967.5762-.21967.796 0l.7428.74236Z" fill="#4BBB8B"></path>
                                                <path d="M17.5604 12.6105c.2487 0 .4515.2016.4391.4499-.0884 1.7656-.6956 3.4699-1.7505 4.8972-1.1442 1.5482-2.7549 2.6891-4.5957 3.255-1.84079.566-3.81463.5273-5.63176-.1105-1.81713-.6377-3.38181-1.8409-4.46434-3.4328-1.082524-1.592-1.6258656-3.4888-1.55025419-5.4121C.0825572 10.3338.773139 8.48545 1.97731 6.9833c1.20416-1.50215 2.85848-2.57892 4.72007-3.07222 1.71622-.45478 3.52522-.39157 5.20042.17627.2355.07983.3484.34247.2569.57354l-.1658.4184c-.0915.23108-.3528.34288-.589.26514-1.40588-.46278-2.91938-.50921-4.35632-.12844-1.58236.41931-2.98853 1.33456-4.01207 2.61139-1.02354 1.27682-1.61053 2.84802-1.6748 4.48282-.06427 1.6348.39757 3.2471 1.31772 4.6002.92014 1.3532 2.25012 2.3759 3.79468 2.918 1.54456.5421 3.22233.575 4.78699.0939 1.5647-.481 2.9338-1.4508 3.9064-2.7668.8832-1.195 1.3972-2.6185 1.4842-4.0952.0146-.2481.2148-.4498.4635-.4498h.4502Z" fill="#4BBB8B"></path>
                                            </svg>
                                            Updated for November 2024
                                        </div>
                                    </div>
                                </div>';

                $tableHTML .= '<div class="sdJ8dsh97_reviews-list sdJ8dsh97_set-positions">';
                $isFirst = true;
                $rating = 5.0;

                foreach ($updatedOffersArray as $arr_key => $offer) {
                    $highlightClass = $isFirst ? 'sdJ8dsh97_highlight' : '';
                    $imageSrc = "https://cdn.cdndating.net/images/" . esc_attr($arr_key) . ".png";
                    $userRating = mt_rand(80, 100) / 10;

                    $offerLinkURL = site_url() . "/out/offer.php?id=" . esc_attr($offer['linkID']) . "&o=" . urlencode($arr_key) . "&t=dating";

                    $tableHTML .= '<div class="sdJ8dsh97_review-item ' . $highlightClass . '" data-position="' . esc_attr($arr_key) . '">';
                    $tableHTML .= '<div class="sdJ8dsh97_review-item-logo sdJ8dsh97_type-logo sdJ8dsh97_partner-link sdJ8dsh97_data-' . esc_attr($arr_key) . '-reviews-table">';
                    $tableHTML .= '<img decoding="async" src="' . esc_url($imageSrc) . '" width="180" height="60" alt="' . esc_attr($offer['brandName']) . ' Logo" class="sdJ8dsh97_cr-logotype-logo ls-is-cached lazyloaded">';
                    $tableHTML .= '</div>';

                    $tableHTML .= '<div class="sdJ8dsh97_review-info-block sdJ8dsh97_rating-block">';
                    $tableHTML .= '<div class="sdJ8dsh97_review-info-block-label">Our score</div>';
                    $tableHTML .= '<div class="sdJ8dsh97_rating">';
                    $tableHTML .= '<div class="sdJ8dsh97_cr-rating-number">' . number_format($rating, 1) . '</div>';
                    $tableHTML .= '<div class="sdJ8dsh97_cr-rating-stars" title="Our Score"><div class="sdJ8dsh97_fill" style="width: ' . esc_attr(($rating / 5) * 100) . '%"></div></div>';
                    $tableHTML .= '</div></div>';

                    $tableHTML .= '<div class="sdJ8dsh97_review-info-block sdJ8dsh97_user-rating-block">';
                    $tableHTML .= '<div class="sdJ8dsh97_review-info-block-label">User Rating</div>';
                    $tableHTML .= '<div class="sdJ8dsh97_user-rating">' . number_format($userRating, 1) . '</div>';
                    $tableHTML .= '</div>';

                    $tableHTML .= '<div class="sdJ8dsh97_review-buttons">';
                    $tableHTML .= '<a target="_blank" href="' . esc_url($offerLinkURL) . '" class="sdJ8dsh97_cr-btn sdJ8dsh97_small-rounded sdJ8dsh97_default-size sdJ8dsh97_site-btn sdJ8dsh97_partner-link sdJ8dsh97_data-' . esc_attr($arr_key) . '-reviews-table">Visit Site</a>';
                    $tableHTML .= '<a href="https://example.com?linkID=' . esc_attr($offer['linkID']) . '" class="sdJ8dsh97_review-link sdJ8dsh97_cr-btn sdJ8dsh97_cr-btn-plain sdJ8dsh97_small-rounded sdJ8dsh97_default-size">Read Review</a>';
                    $tableHTML .= '</div></div>';

                    $isFirst = false;
                    $rating -= 0.5;
                    if ($rating < 4.0) $rating = 4.0;
                }

                $tableHTML .= '</div></div>';
        } elseif ($style == 'style2') {
                $randomVisitors = rand(1000, 3000);
                $tableHTML .= '<div class="isd8Hgh34j_cr-table-style-15 isd8Hgh34j_cr-rating-table">';
                $tableHTML .= '<div class="isd8Hgh34j_table-head">';
                $tableHTML .= '<div class="isd8Hgh34j_visitors-wrapper">
                                    <span class="isd8Hgh34j_review-visitors"><span>' . $randomVisitors . '</span> people visited this site today
                                        <svg width="11" height="14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.875 0c-3.126 1.72-2.75 6.562-2.75 6.562S2.75 6.125 2.75 4.156C1.11 5.064 0 6.81 0 8.75 0 11.65 2.462 14 5.5 14S11 11.65 11 8.75C11 4.484 6.875 3.61 6.875 0zm-.892 12.191c-1.105.263-2.224-.379-2.5-1.434-.276-1.055.397-2.124 1.502-2.387 2.668-.635 3.003-2.067 3.003-2.067s1.33 5.094-2.005 5.888z" fill="#fff"></path>
                                        </svg>
                                    </span>
                                </div>';
                $tableHTML .= '<div class="isd8Hgh34j_reviews-updated">
                                    <svg width="26" height="26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="m13.584.284 1.66 1.906 2.484-1.059a.742.742 0 0 1 .994.467l.758 2.455 2.694.048a.743.743 0 0 1 .723.83l-.3 2.557 2.442 1.145c.37.175.53.617.356.989-.332.693-.935 1.587-1.343 2.275l1.769 2.047a.75.75 0 0 1-.134 1.096l-2.09 1.484.788 2.592a.744.744 0 0 1-.566.945l-2.506.502-.329 2.688a.744.744 0 0 1-.953.623l-2.443-.557-1.389 2.32a.74.74 0 0 1-1.078.215l-2.052-1.54-2.208 1.554a.737.737 0 0 1-1.07-.249l-1.248-2.242-2.649.517a.742.742 0 0 1-.88-.709l-.229-2.515-2.625-.61a.746.746 0 0 1-.536-.965l.823-2.436-2.152-1.631a.748.748 0 0 1-.055-1.144l1.697-1.843L.63 9.669a.746.746 0 0 1 .357-1.047L3.335 7.61 3.1 4.91a.747.747 0 0 1 .813-.807l2.493.034.878-2.562a.741.741 0 0 1 1.05-.417l2.286 1.06 1.838-1.98a.739.739 0 0 1 1.125.047Zm-6.652 13c-.983-.989.512-2.492 1.495-1.504l3.311 3.33 5.799-6.462c.927-1.036 2.497.384 1.57 1.42l-6.51 7.252a1.054 1.054 0 0 1-1.568.081l-4.097-4.118Z" fill="#ED8A0A"></path>
                                    </svg> Updated for ' . esc_html( date_i18n( 'F Y' ) ) . '
                                </div>';

                $tableHTML .= '<div class="isd8Hgh34j_cpm-ajax-info isd8Hgh34j_cpm-advertiser-disclosure"></div></div>';
                $tableHTML .= '<div class="isd8Hgh34j_reviews-list">';

                $itemIndex = 0;
                foreach ($updatedOffersArray as $arr_key => $offer) {
                    $highlightClass = $itemIndex == 0 ? 'isd8Hgh34j_highlight' : '';
                    $imageSrc = "https://cdn.cdndating.net/images/" . esc_attr($arr_key) . ".png";
                    $userRating = mt_rand(40, 50) / 10;
                    $rating = mt_rand(14, 20) / 2;
                    $offerLinkURL = site_url() . "/out/offer.php?id=" . esc_attr($offer['linkID']) . "&o=" . urlencode($arr_key) . "&t=dating";
                    $siteLabel = !empty($offer['siteLabel']) 
                                    ? esc_html($offer['siteLabel']) 
                                    : sprintf(__('Featured Site - %s', 'text-domain'), date_i18n('F Y'));


                    $tableHTML .= '<div class="isd8Hgh34j_review-item ' . $highlightClass . '">';

                    if ($itemIndex == 0) {
                        $tableHTML .= '<div class="isd8Hgh34j_review-site-label isd8Hgh34j_mobile-only">'.$siteLabel.'</div>';
                    }

                    $tableHTML .= '<div class="isd8Hgh34j_review-logo isd8Hgh34j_partner-link"><img src="' . esc_url($imageSrc) . '" width="180" height="60" class="isd8Hgh34j_cr-logotype-logo isd8Hgh34j_lazyloaded"></div>';
                    

                    $tableHTML .= '<div class="isd8Hgh34j_review-description isd8Hgh34j_inner-container isd8Hgh34j_mobile-only">';
                    if (!empty($offer['bulletPoints'])) {
                        $bulletPoints = preg_split('/\r\n|\r|\n/', trim($offer['bulletPoints']));
                        $tableHTML .= '<p>' . esc_html(implode(', ', $bulletPoints)) . '</p>';
                    }
                    $tableHTML .= '</div>';


                    $tableHTML .= '<div class="isd8Hgh34j_review-rating isd8Hgh34j_inner-container">
                                        <div class="isd8Hgh34j_cr-rating-stars" title="User Rating">
                                            <div class="isd8Hgh34j_fill" style="width: ' . esc_attr(($userRating / 5) * 100) . '%"></div>
                                        </div>
                                        ' . number_format($userRating, 1) . '/5 rating
                                    </div>';
                    $tableHTML .= '<div class="isd8Hgh34j_review-score isd8Hgh34j_inner-container">
                                        <div class="isd8Hgh34j_score-box">
                                            <div class="isd8Hgh34j_cr-rating-number">' . number_format($rating, 1) . '</div>
                                            <span class="isd8Hgh34j_our-score">Our score</span>
                                        </div>
                                        <div class="isd8Hgh34j_cr-rating-stars" title="Our Score">
                                            <div class="isd8Hgh34j_fill" style="width: ' . esc_attr(($rating / 10) * 100) . '%"></div>
                                        </div>
                                    </div>';
                    $tableHTML .= '<div class="isd8Hgh34j_review-buttons">
                                        <a href="' . esc_url($offerLinkURL) . '" target="_blank" class="isd8Hgh34j_cr-btn isd8Hgh34j_partner-link">Visit Site</a>
                                    </div>';
                    $tableHTML .= '</div>';

                    $itemIndex++;
                }

                $tableHTML .= '</div></div>';
        } elseif ($style == 'single1') {
                $randomVisitors = rand(1000, 3000);
                $tableHTML .= '<div class="оГЕр5оргпг9ор_cr-table-style-15 оГЕр5оргпг9ор_cr-rating-table">';
                $tableHTML .= '<div class="оГЕр5оргпг9ор_table-head">';
                $tableHTML .= '<div class="оГЕр5оргпг9ор_visitors-wrapper">
                                    <span class="оГЕр5оргпг9ор_review-visitors"><span>' . $randomVisitors . '</span> people visited this site today
                                        <svg width="11" height="14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.875 0c-3.126 1.72-2.75 6.562-2.75 6.562S2.75 6.125 2.75 4.156C1.11 5.064 0 6.81 0 8.75 0 11.65 2.462 14 5.5 14S11 11.65 11 8.75C11 4.484 6.875 3.61 6.875 0zm-.892 12.191c-1.105.263-2.224-.379-2.5-1.434-.276-1.055.397-2.124 1.502-2.387 2.668-.635 3.003-2.067 3.003-2.067s1.33 5.094-2.005 5.888z" fill="#fff"></path>
                                        </svg>
                                    </span>
                                </div>';
                $tableHTML .= '<div class="оГЕр5оргпг9ор_reviews-updated">
                                    <svg width="26" height="26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="m13.584.284 1.66 1.906 2.484-1.059a.742.742 0 0 1 .994.467l.758 2.455 2.694.048a.743.743 0 0 1 .723.83l-.3 2.557 2.442 1.145c.37.175.53.617.356.989-.332.693-.935 1.587-1.343 2.275l1.769 2.047a.75.75 0 0 1-.134 1.096l-2.09 1.484.788 2.592a.744.744 0 0 1-.566.945l-2.506.502-.329 2.688a.744.744 0 0 1-.953.623l-2.443-.557-1.389 2.32a.74.74 0 0 1-1.078.215l-2.052-1.54-2.208 1.554a.737.737 0 0 1-1.07-.249l-1.248-2.242-2.649.517a.742.742 0 0 1-.88-.709l-.229-2.515-2.625-.61a.746.746 0 0 1-.536-.965l.823-2.436-2.152-1.631a.748.748 0 0 1-.055-1.144l1.697-1.843L.63 9.669a.746.746 0 0 1 .357-1.047L3.335 7.61 3.1 4.91a.747.747 0 0 1 .813-.807l2.493.034.878-2.562a.741.741 0 0 1 1.05-.417l2.286 1.06 1.838-1.98a.739.739 0 0 1 1.125.047Zm-6.652 13c-.983-.989.512-2.492 1.495-1.504l3.311 3.33 5.799-6.462c.927-1.036 2.497.384 1.57 1.42l-6.51 7.252a1.054 1.054 0 0 1-1.568.081l-4.097-4.118Z" fill="#ED8A0A"></path>
                                    </svg> Updated for ' . esc_html( date_i18n( 'F Y' ) ) . '
                                </div>';
                $tableHTML .= '<div class="оГЕр5оргпг9ор_cpm-ajax-info оГЕр5оргпг9ор_cpm-advertiser-disclosure"></div></div>';
                $tableHTML .= '<div class="оГЕр5оргпг9ор_reviews-list">';

                $elementIndex = 0;
                foreach ($updatedOffersArray as $arr_key => $offer) {
                    $highlightClass = $elementIndex == 0 ? 'оГЕр5оргпг9ор_highlight' : '';
                    $imageSrc = "https://cdn.cdndating.net/images/" . esc_attr($arr_key) . ".png";
                    $userRating = mt_rand(40, 50) / 10;
                    $rating = mt_rand(14, 20) / 2;
                    $offerLinkURL = site_url() . "/out/offer.php?id=" . esc_attr($offer['linkID']) . "&o=" . urlencode($arr_key) . "&t=dating";
                    $siteLabel = !empty($offer['siteLabel']) 
                                    ? esc_html($offer['siteLabel']) 
                                    : sprintf(__('Featured Site - %s', 'text-domain'), date_i18n('F Y'));


                    $tableHTML .= '<div class="оГЕр5оргпг9ор_review-item ' . $highlightClass . '">';
                    if ($elementIndex == 0) {
                        $tableHTML .= '<div class="оГЕр5оргпг9ор_review-site-label">'.$siteLabel.'</div>';
                    }
                    $tableHTML .= '<div class="оГЕр5оргпг9ор_review-logo оГЕр5оргпг9ор_partner-link"><img src="' . esc_url($imageSrc) . '" width="180" height="60" class="оГЕр5оргпг9ор_cr-logotype-logo оГЕр5оргпг9ор_lazyloaded"></div>';
                    
                    $tableHTML .= '<div class="оГЕр5оргпг9ор_review-description оГЕр5оргпг9ор_inner-container оГЕр5оргпг9ор_mobile-only">';
                    if (!empty($offer['bulletPoints'])) {
                        $bulletPoints = preg_split('/\r\n|\r|\n/', trim($offer['bulletPoints']));
                        $tableHTML .= '<p>' . esc_html(implode(', ', $bulletPoints)) . '</p>';
                    }
                    $tableHTML .= '</div>';

                    $tableHTML .= '<div class="оГЕр5оргпг9ор_review-rating оГЕр5оргпг9ор_inner-container">
                                        <div class="оГЕр5оргпг9ор_cr-rating-stars" title="User Rating">
                                            <div class="оГЕр5оргпг9ор_fill" style="width: ' . esc_attr(($userRating / 5) * 100) . '%"></div>
                                        </div>
                                        ' . number_format($userRating, 1) . '/5 rating
                                    </div>';
                    $tableHTML .= '<div class="оГЕр5оргпг9ор_review-score оГЕр5оргпг9ор_inner-container">
                                        <div class="оГЕр5оргпг9ор_score-box">
                                            <div class="оГЕр5оргпг9ор_cr-rating-number">' . number_format($rating, 1) . '</div>
                                            <span class="оГЕр5оргпг9ор_our-score">Our score</span>
                                        </div>
                                        <div class="оГЕр5оргпг9ор_cr-rating-stars" title="Our Score">
                                            <div class="оГЕр5оргпг9ор_fill" style="width: ' . esc_attr(($rating / 10) * 100) . '%"></div>
                                        </div>
                                    </div>';
                    $tableHTML .= '<div class="оГЕр5оргпг9ор_review-buttons">
                                        <a href="' . esc_url($offerLinkURL) . '" target="_blank" class="оГЕр5оргпг9ор_cr-btn оГЕр5оргпг9ор_partner-link">Visit Site</a>
                                    </div>';
                    $tableHTML .= '</div>';

                    $elementIndex++;
                }
                $tableHTML .= '</div></div>';
        } elseif ($style == 'style3') {
            $tableHTML .= '<div class="jUfg678Gghhhtg_isd8Hgh34j_cr-table-style-45 jUfg678Gghhhtg_isd8Hgh34j_cr-rating-table">';
            foreach ($updatedOffersArray as $arr_key => $offer) {
                $highlightClass = $arr_key == 0 ? 'jUfg678Gghhhtg_has-review' : '';
                $imageSrc = "https://cdn.cdndating.net/images/" . esc_attr($arr_key) . ".png";
                $userRating = mt_rand(40, 50) / 10;
                $ratingPercentage = esc_attr(($userRating / 5) * 100);
                $ratingFormatted = number_format($userRating, 1);
                $offerLinkURL = site_url() . "/out/offer.php?id=" . esc_attr($offer['linkID']) . "&o=" . urlencode($arr_key) . "&t=dating";

                $tableHTML .= '<div class="jUfg678Gghhhtg_review-item ' . $highlightClass . ' jUfg678Gghhhtg_snipcss-xGlZY">';
                $tableHTML .= '<div class="jUfg678Gghhhtg_review-logo">';
                $tableHTML .= '<figure class="jUfg678Gghhhtg_partner-link jUfg678Gghhhtg_data-1566-reviews-table">';
                $tableHTML .= '<img decoding="async" src="' . esc_url($imageSrc) . '" width="130" height="62" alt="' . esc_attr($offer['brandName'] ?? '') . '" class="jUfg678Gghhhtg_cr-logotype-logo jUfg678Gghhhtg_ls-is-cached jUfg678Gghhhtg_lazyloaded">';
                $tableHTML .= '<figcaption>' . esc_html($offer['brandName'] ?? '') . '</figcaption>';
                $tableHTML .= '</figure>';
                $tableHTML .= '</div>';
                $tableHTML .= '<div class="jUfg678Gghhhtg_cr-rating-stars" title="Our Score">';
                $tableHTML .= '<div class="jUfg678Gghhhtg_fill" style="width: ' . $ratingPercentage . '%"></div>';
                $tableHTML .= '</div>';
                $tableHTML .= '<div class="jUfg678Gghhhtg_cr-rating-number">' . $ratingFormatted . '</div>';
                $tableHTML .= '<a href="' . esc_url($offerLinkURL) . '" class="jUfg678Gghhhtg_cr-btn jUfg678Gghhhtg_square jUfg678Gghhhtg_default-size jUfg678Gghhhtg_site-btn jUfg678Gghhhtg_partner-link jUfg678Gghhhtg_data-1566-reviews-table" target="_blank">Visit Site</a>';
                $tableHTML .= '</div>';
            }
            $tableHTML .= '</div>';
        } elseif ($style == 'style4') {

                $newOffersArray = include __DIR__ . '/offers-mail-bride-data.php';

                $atts = shortcode_atts([
                    'offers' => '',
                ], $atts);

                $offerKeys = array_filter(array_map('trim', explode(',', $atts['offers'])));
                $filteredOffersArray = array_intersect_key($newOffersArray['brands'], array_flip($offerKeys));

                if (empty($filteredOffersArray)) {
                    return '<p>No offers found for the specified keys.</p>';
                }

                $tableHTML = '<div class="iOh7jgh9hhtUk_review-table-wrapper">';
                foreach ($filteredOffersArray as $arr_key => $offer) {
                    $highlightClass = $arr_key === "sofia-date" ? 'iOh7jgh9hhtUk_highlight-review' : '';
                    $imageSrc = "https://cdn.cdndating.net/images/" . esc_attr($arr_key) . ".png";
                    $ratingFormatted = number_format($offer['rating'], 1);
                    $offerLinkURL = site_url() . "/out/offer.php?id=" . esc_attr($offer['linkID']) . "&o=" . urlencode($arr_key) . "&t=dating";

                    $tableHTML .= '<div class="iOh7jgh9hhtUk_review-item ' . esc_attr($highlightClass) . ' iOh7jgh9hhtUk_snipcss0-0-0-1">';
                    $tableHTML .= '    <a href="' . esc_url($offerLinkURL) . '" target="_blank" class="iOh7jgh9hhtUk_review-image iOh7jgh9hhtUk_partner-link iOh7jgh9hhtUk_data-339-reviews-table iOh7jgh9hhtUk_snipcss0-1-1-2">';

                    $tableHTML .= '        <img decoding="async" src="' . esc_url($imageSrc) . '" width="245" height="300" alt="' . esc_attr($offer['brandName']) . ' Logo" class="iOh7jgh9hhtUk_cr-logotype-thumbnail iOh7jgh9hhtUk_lazyloaded iOh7jgh9hhtUk_snipcss0-2-2-3">';

                    $tableHTML .= '    </a>';
                    $tableHTML .= '    <div class="iOh7jgh9hhtUk_review-info iOh7jgh9hhtUk_snipcss0-1-1-4">';
                    $tableHTML .= '        <div class="iOh7jgh9hhtUk_review-name-rating iOh7jgh9hhtUk_snipcss0-2-4-5">';
                    $tableHTML .= '            <div class="iOh7jgh9hhtUk_review-name iOh7jgh9hhtUk_partner-link iOh7jgh9hhtUk_data-339-reviews-table iOh7jgh9hhtUk_snipcss0-3-5-6">' . esc_html($offer['brandName']) . '</div>';
                    $tableHTML .= '            <div class="iOh7jgh9hhtUk_review-rating iOh7jgh9hhtUk_snipcss0-3-5-7">';
                    $tableHTML .= '                <div class="iOh7jgh9hhtUk_cr-rating-number iOh7jgh9hhtUk_snipcss0-4-7-8">' . esc_html($ratingFormatted) . '</div>';
                    $tableHTML .= '                <svg width="15" height="20" viewBox="0 0 15 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="iOh7jgh9hhtUk_snipcss0-4-7-9">';
                    $tableHTML .= '                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.23321 15.4298C4.33232 15.4764 4.44065 15.5003 4.55029 15.5C4.66963 15.4926 4.78533 15.4564 4.88727 15.3943L7.991 13.7787L11.0947 15.3943C11.2164 15.4559 11.3529 15.4827 11.489 15.4716C11.6252 15.4606 11.7555 15.4121 11.8655 15.3317C11.9754 15.2513 12.0607 15.1421 12.1117 15.0164C12.1628 14.8906 12.1775 14.7532 12.1544 14.6196L11.5736 11.2078L14.0787 8.7822C14.1769 8.687 14.2463 8.56645 14.2791 8.43416C14.3119 8.30187 14.3068 8.16311 14.2644 8.03354C14.2219 7.90397 14.1439 7.78876 14.039 7.70091C13.9341 7.61306 13.8066 7.55607 13.6708 7.53637L10.2079 7.03452L8.65165 3.91775C8.59197 3.79276 8.49779 3.68715 8.38006 3.61321C8.26233 3.53926 8.12588 3.5 7.98656 3.5C7.84725 3.5 7.71079 3.53926 7.59306 3.61321C7.47533 3.68715 7.38115 3.79276 7.32148 3.91775L5.77405 7.03452L2.32005 7.53197C2.18427 7.55167 2.05674 7.60866 1.95185 7.69651C1.84697 7.78436 1.76891 7.89957 1.72649 8.02914C1.68406 8.1587 1.67897 8.29746 1.71177 8.42975C1.74457 8.56205 1.81397 8.6826 1.91213 8.7778L4.41728 11.1946L3.82757 14.6196C3.80511 14.7261 3.80691 14.8363 3.83285 14.9421C3.85878 15.0478 3.90818 15.1465 3.97745 15.2309C4.04672 15.3153 4.1341 15.3832 4.23321 15.4298Z" fill="#F1C862"></path>';
                    $tableHTML .= '                </svg>';
                    $tableHTML .= '            </div>';
                    $tableHTML .= '        </div>';
                    $tableHTML .= '        <button class="iOh7jgh9hhtUk_cr-btn iOh7jgh9hhtUk_square iOh7jgh9hhtUk_big-size iOh7jgh9hhtUk_review-mobile-button iOh7jgh9hhtUk_partner-link iOh7jgh9hhtUk_data-339-reviews-table iOh7jgh9hhtUk_snipcss0-2-4-10" type="button">Visit Site</button>';
                    $tableHTML .= '        <div class="iOh7jgh9hhtUk_review-pros-cons iOh7jgh9hhtUk_snipcss0-2-4-11">';
                    $tableHTML .= '            <ul class="iOh7jgh9hhtUk_cr-cpm_offer_pros-list iOh7jgh9hhtUk_snipcss0-3-11-12">';
                    foreach ($offer['pros'] as $pro) {
                        $tableHTML .= '                <li class="iOh7jgh9hhtUk_snipcss0-4-12-13">' . esc_html($pro) . '</li>';
                    }
                    $tableHTML .= '            </ul>';
                    $tableHTML .= '            <ul class="iOh7jgh9hhtUk_cr-cpm_offer_cons-list iOh7jgh9hhtUk_snipcss0-3-11-16">';
                    foreach ($offer['cons'] as $con) {
                        $tableHTML .= '                <li class="iOh7jgh9hhtUk_snipcss0-4-16-17">' . esc_html($con) . '</li>';
                    }
                    $tableHTML .= '            </ul>';
                    $tableHTML .= '        </div>';
                    $tableHTML .= '        <div class="iOh7jgh9hhtUk_review-special-offer iOh7jgh9hhtUk_partner-link iOh7jgh9hhtUk_data-339-reviews-table iOh7jgh9hhtUk_snipcss0-2-4-19"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="16" viewBox="0 0 14 16" fill="none" class="snipcss0-3-19-20">
                        <path d="M6.25782 3.98155H1.99336C1.70327 3.98155 1.42513 4.09676 1.22013 4.3019C1.01511 4.50693 0.899902 4.78505 0.899902 5.07501V6.93388C0.899902 7.09496 1.03036 7.22554 1.19145 7.22554H6.29413L6.25782 3.98155Z" fill="#F02E73"></path>
                        <path d="M11.9803 3.98155H7.71582V7.22535H12.8185L12.8186 7.22548C12.8959 7.22548 12.9701 7.19472 13.0247 7.14005C13.0794 7.08537 13.1102 7.01118 13.1102 6.9338V5.07493C13.1103 4.7785 12.9901 4.49478 12.7771 4.28865C12.5641 4.0824 12.2766 3.97161 11.9802 3.98148L11.9803 3.98155Z" fill="#F02E73"></path>
                        <path d="M6.25744 8.31911H1.51904V12.3793C1.51904 12.6692 1.63425 12.9474 1.83927 13.1525C2.04441 13.3575 2.32254 13.4727 2.6125 13.4727H6.25744V8.31911Z" fill="#F02E73"></path>
                        <path d="M7.71582 8.31911V13.4727H11.3608C11.6507 13.4727 11.9289 13.3575 12.134 13.1525C12.339 12.9473 12.4542 12.6692 12.4542 12.3793V8.31911H7.71582Z" fill="#F02E73"></path>
                        <path d="M10.3401 0.511648C10.1712 0.511282 10.0027 0.528489 9.83718 0.562659C9.30423 0.61123 8.80378 0.839806 8.41813 1.21092C8.03261 1.58191 7.78486 2.07312 7.71582 2.60386C7.71765 2.67805 7.74987 2.74823 7.80503 2.79789C7.86019 2.84756 7.93341 2.87221 8.00749 2.86623H10.1215C10.7631 2.86623 11.8274 2.72772 11.8274 1.78731H11.8273C11.8113 1.41644 11.6424 1.06863 11.3605 0.826881C11.0787 0.585125 10.7093 0.471009 10.3401 0.511654L10.3401 0.511648Z" fill="#F02E73"></path>
                        <path d="M6.25781 2.6038C6.18935 2.07538 5.94368 1.58576 5.56109 1.21502C5.17838 0.844273 4.68133 0.614335 4.15107 0.562599C3.98559 0.528427 3.81707 0.511223 3.64802 0.511588C3.27434 0.462164 2.897 0.57224 2.60852 0.814971C2.32003 1.0577 2.14699 1.41062 2.13184 1.78724C2.13184 2.72767 3.19611 2.86616 3.83756 2.86616H6.02447C6.2578 2.86616 6.2578 2.60379 6.2578 2.60379L6.25781 2.6038Z" fill="#F02E73"></path>
                    </svg>';
                    $tableHTML .= '            ' . esc_html($offer['shortDescription']) . '';
                    $tableHTML .= '        </div>';
                    $tableHTML .= '        <div class="iOh7jgh9hhtUk_review-buttons iOh7jgh9hhtUk_snipcss0-2-4-21">';
                    $tableHTML .= '            <a href="' . esc_url($offerLinkURL) . '" class="iOh7jgh9hhtUk_cr-btn iOh7jgh9hhtUk_square iOh7jgh9hhtUk_big-size iOh7jgh9hhtUk_partner-link iOh7jgh9hhtUk_data-339-reviews-table iOh7jgh9hhtUk_snipcss0-3-21-22" target="_blank">Visit Site</a>';
                    $tableHTML .= '        </div>';
                    $tableHTML .= '    </div>';
                    $tableHTML .= '</div>';
                }
                $tableHTML .= '</div>';


                return $tableHTML;

        } elseif ($style == 'style5') {

            $updatedOffersArray = include __DIR__ . '/offers-hookupguru-data.php';
            $tableHTML = '<div class="ad_wbc_all_reviews ad_wbc_snipcss-J8FO5" show-banner="false" data-v-ef4df5c3="" data-v-5fde7f3a="">';
            $ratings = [];
            for ($i = 5.0; $i >= 3.6; $i -= 0.2) {
                $ratings[] = number_format($i, 1);
            }
            $ratingIndex = 0;

            $scoreOptions = [];
            for ($i = 7.0; $i <= 10.0; $i += 0.1) {
                $scoreOptions[] = number_format($i, 1);
            }

            foreach ($updatedOffersArray as $arr_key => $offer) {
                $highlightClass = $arr_key == 0 ? 'ad_wbc_highlight-offer' : '';
                $signUpLink = '/sign-up';
                $reviewLink = esc_url($offer['readReviewLink']);
                $currentRating = $ratings[$ratingIndex];
                $ratingIndex = ($ratingIndex + 1) % count($ratings);
                $randomScore = $scoreOptions[array_rand($scoreOptions)];
                $offerPageLink = site_url() . "/out/offer.php?id=" . esc_attr($offer['linkID']) . "&o=" . urlencode($arr_key) . "&t=dating";

                $tableHTML .= '<div class="ad_wbc_post_preview ' . $highlightClass . '" data-v-5fde7f3a="" data-v-de82ba65="">';
                $tableHTML .= '<a href="' . esc_url($offerPageLink) . '" class="ad_wbc_webcam ad_wbc_post_img_pr" data-v-de82ba65="">';
                $tableHTML .= '<div class="ad_wbc_filter" data-v-de82ba65="">';
                $tableHTML .= '<div data-text="' . esc_attr($offer['brandName']) . '" class="ad_wbc_title_logo" data-v-de82ba65="">' . esc_html($offer['brandName']) . '</div>';
                $tableHTML .= '</div>';
                $tableHTML .= '</a>';
                $tableHTML .= '<div class="ad_wbc_info" data-v-de82ba65="">';
                $tableHTML .= '<div class="ad_wbc_first_block" data-v-de82ba65="">';
                $tableHTML .= '<a href="' . esc_url($offerPageLink) . '" class="ad_wbc_title" data-v-de82ba65="">' . esc_html($offer['brandName']) . '</a>';
                $tableHTML .= '<div class="ad_wbc_stars-wrapper" data-v-de82ba65="" data-v-d9c24a74="">';
                $tableHTML .= '<div class="ad_wbc_info" data-v-d9c24a74="">';
                $tableHTML .= '<div class="ad_wbc_score" data-v-d9c24a74="">' . $randomScore . '</div>';
                $tableHTML .= '<div class="ad_wbc_stars" data-v-d9c24a74="">';

                $fullStars = 0;

                if ($randomScore >= 9.0 && $randomScore <= 9.5) {
                    $fullStars = 4;
                } elseif ($randomScore > 9.5) {
                    $fullStars = 5;
                } elseif ($randomScore >= 8.0 && $randomScore < 9.0) {
                    $fullStars = 3;
                } elseif ($randomScore >= 7.0 && $randomScore < 8.0) {
                    $fullStars = 2;
                } elseif ($randomScore < 7.0) {
                    $fullStars = 1;
                }

                for ($i = 0; $i < 5; $i++) {
                    if ($i < $fullStars) {
                        $tableHTML .= '<span data-v-d9c24a74="" class="ad_wbc_full"></span>';
                    } else {
                        $tableHTML .= '<span data-v-d9c24a74="" class="ad_wbc_empty"></span>';
                    }
                }

                $tableHTML .= '</div>';
                $tableHTML .= '</div>';
                $tableHTML .= '</div>';
                $tableHTML .= '</div>';
                $tableHTML .= '<div class="ad_wbc_second_block" data-v-de82ba65="">';
                $tableHTML .= '<a class="ad_wbc_btn_pink ad_wbc_external_link" target="_blank" href=' . $signUpLink . ' data-v-de82ba65="">Sign Up</a>';
                $tableHTML .= '</div>';
                $tableHTML .= '</div>';
                $tableHTML .= '<div class="ad_wbc_info_second" data-v-de82ba65="">';
                $tableHTML .= '<div class="ad_wbc_block ad_wbc_online" data-v-de82ba65="">';
                $tableHTML .= '<div class="ad_wbc_header" data-v-de82ba65="">Users Online</div>';
                $tableHTML .= '<div class="ad_wbc_text" data-v-de82ba65="">&nbsp;' . esc_html($offer['usersOnline']) . '</div>';
                $tableHTML .= '</div>';
                $tableHTML .= '<div class="ad_wbc_block ad_wbc_rate" data-v-de82ba65="">';
                $tableHTML .= '<div class="ad_wbc_header" data-v-de82ba65="">Hookup Rate</div>';
                $tableHTML .= '<div class="ad_wbc_text" data-v-de82ba65="">' . esc_html($offer['hookupRate']) . '<span class="ad_wbc_percent" data-v-de82ba65="">%</span></div>';
                $tableHTML .= '</div>';
                $tableHTML .= '<div class="ad_wbc_block ad_wbc_gender" data-v-de82ba65="">';
                $tableHTML .= '<div class="ad_wbc_header" data-v-de82ba65="">Gender Rating</div>';
                $tableHTML .= '<div class="ad_wbc_text" data-v-de82ba65="">';
                $tableHTML .= '<div class="ad_wbc_men" data-v-de82ba65="">&nbsp;' . esc_html($offer['genderRatingMale']) . '<span class="ad_wbc_percent" data-v-de82ba65="">%</span></div>';
                $tableHTML .= '<div class="ad_wbc_women" data-v-de82ba65="">&nbsp;' . esc_html($offer['genderRatingFemale']) . '<span class="ad_wbc_percent" data-v-de82ba65="">%</span></div>';
                $tableHTML .= '</div>';
                $tableHTML .= '</div>';
                $tableHTML .= '<div class="ad_wbc_block ad_wbc_safety" data-v-de82ba65="">';
                $tableHTML .= '<div class="ad_wbc_header" data-v-de82ba65="">Safety</div>';
                $tableHTML .= '<div class="ad_wbc_text" data-v-de82ba65="">' . $currentRating . '<span class="ad_wbc_score" data-v-de82ba65=""> / 5.0</span></div>';
                $tableHTML .= '</div>';
                $tableHTML .= '</div>';
                $tableHTML .= '</div>';
            }
            $tableHTML .= '</div>';

        } elseif ($style == 'top1') {
            
            $updatedOffersArray = include __DIR__ . '/offers-aimojo-data.php';

            $atts = shortcode_atts([
                'tag' => '',
                'style' => 'top1',
            ], $atts);

            $filteredOffersArray = array_filter($updatedOffersArray, function ($offer) use ($atts) {
                if (empty($atts['tag'])) {
                    return true;
                }
                $tags = isset($offer['Tag']) ? (is_array($offer['Tag']) ? $offer['Tag'] : explode(',', $offer['Tag'])) : [];
                return in_array($atts['tag'], $tags);
            });

            $count = count($filteredOffersArray);
            $columns = $count > 3 ? 3 : $count;
            $width = 100 / $columns;

            $tableHTML = '<div class="wGuu8hjkhgjj_comparison-wrapper wGuu8hjkhgjj_snipcss0-0-0-1 wGuu8hjkhgjj_snipcss-vno3X" style="--item-width: ' . $width . '%;">';

            foreach ($filteredOffersArray as $arr_key => $offer) {
                $imageSrc = "https://cdn.cdndating.net/images/" . esc_attr($arr_key) . ".png";
                $offerLinkURL = site_url() . "/out/offer.php?id=" . esc_attr($offer['linkID']) . "&o=" . urlencode($arr_key) . "&t=dating";
                $labelName = esc_html($offer['labelName']);
                $brandName = esc_html($offer['brandName']);
                $bulletPoints = nl2br(esc_html($offer['bulletPoints']));
                $labelButton = esc_html($offer['labelButton']);

                $tableHTML .= '<div class="wGuu8hjkhgjj_comparison-item wGuu8hjkhgjj_snipcss0-1-1-2">';
                $tableHTML .= '    <div class="wGuu8hjkhgjj_item-header wGuu8hjkhgjj_snipcss0-2-2-3 wGuu8hjkhgjj_style-9KM7g" data-match-height="itemHeader">';
                $tableHTML .= '        <div class="wGuu8hjkhgjj_item-badge wGuu8hjkhgjj_snipcss0-3-3-4 wGuu8hjkhgjj_style-o1fJI">' . $labelName . '</div>';
                $tableHTML .= '        <a href="' . esc_url($offerLinkURL) . '" target="_blank" class="wGuu8hjkhgjj_product-image wGuu8hjkhgjj_snipcss0-3-3-5">';
                $tableHTML .= '            <div class="wGuu8hjkhgjj_image wGuu8hjkhgjj_snipcss0-4-5-6">';
                $tableHTML .= '                <img fetchpriority="high" decoding="async" src="' . esc_url($imageSrc) . '" class="wGuu8hjkhgjj_attachment-full wGuu8hjkhgjj_size-full wGuu8hjkhgjj_snipcss0-5-6-7" width="160" height="160" alt="' . $brandName . ' Logo">';
                $tableHTML .= '            </div>';
                $tableHTML .= '        </a>';
                $tableHTML .= '        <div class="wGuu8hjkhgjj_item-title wGuu8hjkhgjj_snipcss0-3-3-8 wGuu8hjkhgjj_style-iXbas"><strong>' . $brandName . '</strong></div>';
                $tableHTML .= '        <div class="wGuu8hjkhgjj_item-rating wGuu8hjkhgjj_snipcss0-3-3-10">';
                $tableHTML .= '            <div class="wGuu8hjkhgjj_item-stars-rating wGuu8hjkhgjj_snipcss0-4-10-11">';
                for ($i = 0; $i < 5; $i++) {
                    $tableHTML .= '                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="33 -90 360 360">';
                    $tableHTML .= '                    <polygon fill="#F6A123" points="281.1,129.8 364,55.7 255.5,46.8 214,-59 172.5,46.8 64,55.4 146.8,129.7 121.1,241 213.9,181.1 213.9,181 306.5,241 "></polygon>';
                    $tableHTML .= '                </svg>';
                }
                $tableHTML .= '            </div>';
                $tableHTML .= '        </div>';
                $tableHTML .= '        <a href="' . esc_url($offerLinkURL) . '" rel="nofollow noopener sponsored" target="_blank" style="background-color: #7635f3" class="wGuu8hjkhgjj_gss-item-btn wGuu8hjkhgjj_gspb_track_btn wGuu8hjkhgjj_re_track_btn wGuu8hjkhgjj_snipcss0-3-3-17">' . $labelButton . '</a>';
                $tableHTML .= '    </div>';
                $tableHTML .= '    <div class="wGuu8hjkhgjj_item-row-description wGuu8hjkhgjj_item-row-bottomline wGuu8hjkhgjj_snipcss0-2-2-18 wGuu8hjkhgjj_style-h7PD1" data-match-height="itemBottomline">';
                $tableHTML .= '        <div class="wGuu8hjkhgjj_item-row-title wGuu8hjkhgjj_snipcss0-3-18-19">Bottom Line</div>';
                $tableHTML .= '        ' . $bulletPoints;
                $tableHTML .= '    </div>';
                $tableHTML .= '</div>';
            }

            $tableHTML .= '</div>';

            return $tableHTML;

        }

        return $tableHTML;
    }
}

if ( ! function_exists( 'enqueue_offers_table_css' ) ) {
    function enqueue_offers_table_css($style) {
        $handle = "updated-table-css-$style";
        $css_url = site_url() . "/table-client/mob/inc/{$style}.css";

        if (!wp_style_is($handle, 'enqueued') && file_exists(ABSPATH . "table-client/mob/inc/{$style}.css")) {
            wp_enqueue_style($handle, $css_url, array(), '1.0.0');
        }
    }
}


add_action('wp_enqueue_scripts', 'enqueue_tiny_slider_assets');

function enqueue_tiny_slider_assets() {
    wp_enqueue_style('tiny-slider-css', site_url() . '/table-client/mob/inc/tiny-slider.css', array(), '1.0.0');
    wp_enqueue_script('tiny-slider-js', site_url() . '/table-client/mob/js/tiny-slider.js', array(), '1.0.0', true);
    wp_enqueue_script('tiny-slider-init', site_url() . '/table-client/mob/js/tiny-init.js', array('tiny-slider-js'), '1.0.0', true);
}
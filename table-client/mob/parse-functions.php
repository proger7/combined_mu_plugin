<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'customDisplayModelsApp' ) ) {
    function customDisplayModelsApp($atts) {
        $data = include __DIR__ . '/offers-data.php';
        $modelsArray = $data['models'];
        $modelBrandArray = $data['brands'];

        $ModelTracker = "12456";
        $ModelTag = "dating-mainstream";

        $atts = shortcode_atts([
            'tag' => '',
            'offer' => '',
            'limit' => 10,
            'style' => 'site1',
        ], $atts);

        custom_mi_enqueue_models_app_css($atts['style']);

        $filteredModels = array_filter($modelsArray, function($model) use ($atts) {
            return empty($atts['tag']) || $model['Tag'] === $atts['tag'];
        });

        if (empty($filteredModels)) {
            return 'No models found.';
        }

        $style = $atts['style'];
        $output = '';

        $filteredModels = array_slice($filteredModels, 0, $atts['limit']);
        $offers = array_map('trim', explode(',', $atts['offer']));
        $offerCount = count($offers);


        if ($style == 'site1') {

            $output = '<div class="wp_brand-models_tns-ovh">';
            $output .= '<div class="wp_brand-models_tns-inner" id="wp_brand-models_tns1-iw">';
            $output .= '<div class="wp_brand-models_profiles-slider wp_brand-models_tns-slider wp_brand-models_tns-subpixel wp_brand-models_tns-horizontal wp_brand-models_style-91lpw" id="wp_brand-models_tns1">';

            foreach ($filteredModels as $key => $model) {
                $randomOfferKey = $offerCount > 0 ? $offers[array_rand($offers)] : '';
                $randomOffer = $offerCount > 0 ? $offers[array_rand($offers)] : '';
                $offerName = isset($modelBrandArray[$randomOffer]) ? $modelBrandArray[$randomOffer]['brandName'] : '';
                $imageUrl = "https://cdn.cdndating.net/images/models/{$key}1.png";
                $link = "/out/offer.php?id=$ModelTracker&o=$randomOfferKey&t=$ModelTag";

                $output .= '<div class="wp_brand-models_tns-item">';
                $output .= '<div class="wp_brand-models_profile-item">';
                $output .= '<div class="wp_brand-models_profile-image-wrapper">';
                $output .= '<div class="wp_brand-models_profile-label">';
                $output .= '<div class="wp_brand-models_icon"><svg width="32" height="32" viewBox="0 0 32 32" fill="#2fc85a" xmlns="http://www.w3.org/2000/svg">
                                <rect x="7.95898" y="7" width="15.9179" height="17" fill="white"></rect>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.7185 0.350103L18.7624 2.69534L21.8192 1.39198C22.3144 1.18226 22.8848 1.45229 23.0429 1.96625L23.9756 4.98883L27.2911 5.04778C27.8271 5.05634 28.2466 5.53474 28.1804 6.06986L27.8114 9.21575L30.8171 10.6258C31.272 10.84 31.4691 11.3846 31.2559 11.8423C30.8462 12.6956 30.1043 13.7955 29.6024 14.6425L31.7793 17.1624C32.1308 17.5701 32.0525 18.2007 31.615 18.5103L29.0432 20.3371L30.0121 23.5275C30.1688 24.0478 29.8433 24.5856 29.3154 24.6905L26.2313 25.3079L25.8265 28.6168C25.7576 29.1834 25.1925 29.5497 24.6534 29.3836L21.6464 28.6982L19.9378 31.5543C19.6606 32.0192 19.0418 32.1416 18.6111 31.8184L16.0854 29.9233L13.368 31.8347C12.9229 32.147 12.3171 32.0012 12.0516 31.5291L10.5149 28.7698L7.25444 29.4062C6.70013 29.5124 6.19104 29.0956 6.17179 28.5335L5.88971 25.4371L2.65832 24.6864C2.12953 24.5645 1.82775 24.0122 1.99834 23.4987L3.01159 20.5013L0.362717 18.4932C-0.0939854 18.1471 -0.122641 17.4716 0.295107 17.0859L2.3834 14.8167L0.77554 11.8994C0.511817 11.4228 0.719124 10.8265 1.21478 10.6123L4.10409 9.36517L3.81619 6.04151C3.76694 5.46814 4.25409 4.99378 4.81735 5.04869L7.88532 5.09054L8.96663 1.937C9.14976 1.40143 9.76317 1.16245 10.2579 1.42394L13.0716 2.7291L15.334 0.292046C15.7178 -0.122456 16.3724 -0.0891516 16.7185 0.350103ZM8.53142 16.3487C7.3216 15.1326 9.1614 13.2829 10.3717 14.499L14.4471 18.5958L21.5837 10.6442C22.725 9.36922 24.657 11.1159 23.5153 12.3918L15.5042 21.3173C15.0184 21.9177 14.1206 21.9667 13.5744 21.4172L8.53142 16.3487Z" fill="#2fc85a"></path>
                            </svg></div>';
                $output .= '</div>';
                $output .= '<span class="wp_brand-models_partner-link"><img src="' . esc_url($imageUrl) . '" width="330" height="220" class="wp_brand-models_profile-image wp_brand-models_lazyloaded" alt="' . esc_attr($model['Name']) . '"></span>';
                $output .= '</div>';

                $output .= '<div class="wp_brand-models_profile-item-content">';
                $output .= '<div class="wp_brand-models_profile-name">';
                $output .= '<span class="wp_brand-models_partner-link">' . esc_html($model['Name']) . ', ' . esc_html($model['Age']) . '</span>';
                $output .= '</div>';
                $output .= '<div class="wp_brand-models_profile-offer-online">';
                $output .= '<span class="wp_brand-models_partner-link">Online at ' . esc_html($offerName) . '</span>';
                $output .= '</div>';

                $output .= '<div class="wp_brand-models_profile-meta">';
                $output .= '<div class="wp_brand-models_profile-meta-item wp_brand-models_profile-meta-location">';
                $output .= '<div class="wp_brand-models_profile-meta-icon"><svg width="20" height="28" viewBox="0 0 20 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M10.2047 6.13583C8.23139 6.13583 6.62524 7.74198 6.62524 9.71528C6.62524 11.6886 8.23139 13.2947 10.2047 13.2947C12.178 13.2947 13.7841 11.6886 13.7841 9.71528C13.7841 7.74198 12.178 6.13583 10.2047 6.13583ZM10.2047 12.272C8.7949 12.272 7.64794 11.1251 7.64794 9.71528C7.64794 8.30549 8.7949 7.15853 10.2047 7.15853C11.6145 7.15853 12.7614 8.30549 12.7614 9.71528C12.7614 11.1251 11.6145 12.272 10.2047 12.272Z" fill="#333333"></path>
                                            <path d="M16.855 2.87225C15.0242 1.02014 12.59 0 10.001 0C7.41159 0 4.97784 1.02014 3.14709 2.87225C-0.240956 6.29932 -0.661998 12.7474 2.23526 16.6542L10.001 28L17.7552 16.67C20.6641 12.7474 20.243 6.29932 16.855 2.87225ZM16.9353 16.0722L10.001 26.2031L3.05561 16.0564C0.427758 12.5117 0.80432 6.68846 3.86231 3.5953C5.502 1.93648 7.68201 1.0227 10.001 1.0227C12.32 1.0227 14.5001 1.93648 16.1403 3.5953C19.1982 6.68846 19.5748 12.5117 16.9353 16.0722Z" fill="#333333"></path>
                                        </svg></div>';
                $output .= '<div>';
                $output .= '<div class="wp_brand-models_profile-meta-label">Location</div>';
                $output .= '<div class="wp_brand-models_profile-meta-value">' . esc_html($model['Location']) . '</div>';
                $output .= '</div>';
                $output .= '</div>';

                $output .= '<div class="wp_brand-models_profile-meta-item wp_brand-models_profile-meta-occupation">';
                $output .= '<div class="wp_brand-models_profile-meta-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.7603 4.86896V1.8695C16.7603 0.838775 15.9714 0 15.002 0H8.9975C8.0281 0 7.23918 0.838775 7.23918 1.8695V4.86896H0V24H24V4.86896H16.7603ZM8.26046 1.8695C8.26046 1.40175 8.59112 1.02132 8.9975 1.02132H15.002C15.4084 1.02132 15.739 1.4018 15.739 1.8695V4.86896H8.26046V1.8695ZM22.9787 5.89029V12.735H1.02127V5.89029H22.9787ZM1.02127 22.9787V13.7563H6.3695V15.8448H7.39078V13.7563H16.6092V15.8448H17.6304V13.7563H22.9787V22.9787H1.02127Z" fill="#333333"></path>
                            </svg></div>';
                $output .= '<div>';
                $output .= '<div class="wp_brand-models_profile-meta-label">Occupation</div>';
                $output .= '<div class="wp_brand-models_profile-meta-value">' . esc_html($model['Occupation']) . '</div>';
                $output .= '</div>';
                $output .= '</div>';

                if (!empty($model['Age'])) {
                    $output .= '<div class="wp_brand-models_profile-meta-item wp_brand-models_profile-meta-age">';
                    $output .= '<div class="wp_brand-models_profile-meta-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 24C9.62663 24 7.30655 23.2962 5.33316 21.9776C3.35977 20.6591 1.8217 18.7849 0.913451 16.5922C0.00519936 14.3995 -0.232441 11.9867 0.230582 9.65892C0.693605 7.33115 1.83649 5.19295 3.51472 3.51472C5.19295 1.83649 7.33115 0.693605 9.65892 0.230582C11.9867 -0.232441 14.3995 0.00519936 16.5922 0.913451C18.7849 1.8217 20.6591 3.35977 21.9776 5.33316C23.2962 7.30655 24 9.62663 24 12C23.997 15.1817 22.7317 18.2322 20.4819 20.4819C18.2322 22.7317 15.1817 23.997 12 24ZM12 1.14286C9.85266 1.14286 7.75355 1.77962 5.9681 2.97262C4.18265 4.16562 2.79106 5.86127 1.96931 7.84516C1.14756 9.82904 0.932554 12.012 1.35148 14.1181C1.7704 16.2242 2.80445 18.1588 4.32285 19.6772C5.84124 21.1956 7.7758 22.2296 9.88188 22.6485C11.988 23.0675 14.171 22.8524 16.1549 22.0307C18.1387 21.2089 19.8344 19.8174 21.0274 18.0319C22.2204 16.2465 22.8571 14.1473 22.8571 12C22.8541 9.12144 21.7093 6.36164 19.6738 4.32619C17.6384 2.29073 14.8786 1.14589 12 1.14286Z" fill="#333333"></path>
                                            <path d="M17.7143 18.2856C17.6394 18.2865 17.5651 18.2717 17.4962 18.2422C17.4273 18.2127 17.3654 18.1691 17.3143 18.1142L11.6001 12.3999C11.5452 12.3488 11.5015 12.2869 11.472 12.218C11.4425 12.1491 11.4277 12.0748 11.4286 11.9999V5.71416C11.4286 5.56261 11.4888 5.41726 11.596 5.3101C11.7032 5.20293 11.8485 5.14273 12.0001 5.14273C12.1516 5.14273 12.297 5.20293 12.4041 5.3101C12.5113 5.41726 12.5715 5.56261 12.5715 5.71416V11.7599L18.1143 17.3142C18.169 17.3655 18.2126 17.4274 18.2424 17.4962C18.2721 17.565 18.2875 17.6392 18.2875 17.7142C18.2875 17.7891 18.2721 17.8633 18.2424 17.9321C18.2126 18.0009 18.169 18.0629 18.1143 18.1142C18.0633 18.1691 18.0014 18.2127 17.9325 18.2422C17.8636 18.2717 17.7893 18.2865 17.7143 18.2856Z" fill="#333333"></path>
                                        </svg></path>
                                </svg></div>';
                    $output .= '<div>';
                    $output .= '<div class="wp_brand-models_profile-meta-label">Age</div>';
                    $output .= '<div class="wp_brand-models_profile-meta-value">' . esc_html($model['Age']) . '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                }

                $output .= '</div>';

                if ($randomOffer) {
                    $output .= '<div class="wp_brand-models_profile-button-wrap">';
                    $output .= '<a href="' . esc_url($link) . '" class="wp_brand-models_profile-button wp_brand-models_cr-btn wp_brand-models_partner-link" target="_blank">';
                    $output .= '<span>Chat Now 💬</span>';
                    $output .= '<svg width="9" height="15" viewBox="0 0 9 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <mask style="mask-type:luminance" width="9" height="15">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0.901245 0.157898H9.00001V14.8947H0.901245V0.157898Z" fill="white"></path>
                                    </mask>
                                    <g>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.70904 8.25604L2.59988 14.5927C2.21043 14.9954 1.58022 14.9954 1.19196 14.5927C0.804177 14.1898 0.804177 13.5359 1.19196 13.1334L6.59764 7.52613L1.19291 1.92035C0.804177 1.51715 0.804177 0.863741 1.19291 0.461037C1.58117 0.0568517 2.21138 0.0568517 2.59988 0.461037L8.70904 6.79747C8.90317 6.99906 9 7.26235 9 7.52613C9 7.79016 8.90317 8.05567 8.70904 8.25604Z" fill="white"></path>
                                    </g>
                                </svg>';
                    $output .= '</a>';
                    $output .= '</div>';
                }

                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';

            }

            $output .= '</div>';
            $output .= '</div>';
            $output .= '</div>';

        } elseif ($style == 'site2') {

            $output = '<div class="wp_s2_site_profiles-grid">';

            foreach ($filteredModels as $key => $model) {
                $randomOfferKey = $offerCount > 0 ? $offers[array_rand($offers)] : '';
                $randomOffer = $offerCount > 0 ? $offers[array_rand($offers)] : '';
                $offerName = isset($modelBrandArray[$randomOffer]) ? $modelBrandArray[$randomOffer]['brandName'] : '';
                $link = "/out/offer.php?id=$ModelTracker&o=$randomOfferKey&t=$ModelTag";

                $output .= '<div class="wp_s2_site_profile-grid-item">';
                $output .= '<div class="wp_s2_site_tns-outer">';
                $output .= '<div class="wp_s2_site_tns-controls"><button type="button" data-controls="prev">‹</button><button type="button" data-controls="next">›</button></div>';
                $output .= '<div class="wp_s2_site_tns-visually-hidden">slide <span>1</span> of 5</div>';
                $output .= '<div id="tns1-mw" class="wp_s2_site_tns-ovh wp_s2_site_tns-ah wp_s2_site_style-oWeJE">';
                $output .= '<div id="tns1-iw">';
                $output .= '<div class="wp_s2_site_profile-top-side wp_s2_site_tns-slider wp_s2_site_tns-subpixel wp_s2_site_tns-horizontal wp_s2_site_style-99FO2" id="tns1">';

                for ($i = 1; $i <= 4; $i++) {
                    $imageUrl = "https://cdn.cdndating.net/images/models/{$key}{$i}.png";
                    $output .= '<div class="wp_s2_site_item wp_s2_site_tns-item">';
                    $output .= '<img src="' . esc_url($imageUrl) . '" width="230" height="280" class="wp_s2_site_loaded wp_s2_site_lazyloaded">';
                    if ($i == 4) {
                        $output .= '<div class="wp_s2_site_more">' . esc_html($model['Name']) . ' has more photos!<br>Do you want to watch?';
                        $output .= '<div class="wp_s2_site_profile-all-photos-button wp_s2_site_partner-link"><a href="' . esc_url($link) . '" class="wp_s2_site_profile-button wp_s2_site_partner-link-view">View photos</a></div>';
                        $output .= '</div>';
                    }
                    $output .= '</div>';
                }

                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '<div class="wp_s2_site_tns-nav">';
                for ($i = 0; $i < 5; $i++) {
                    $output .= '<button type="button" class="' . ($i == 0 ? 'wp_s2_site_tns-nav-active' : '') . '"></button>';
                }
                $output .= '</div>';
                $output .= '</div>';
                $output .= '<div class="wp_s2_site_profile-bottom-side">';
                $output .= '<div class="wp_s2_site_profile-info">';
                $output .= '<div class="wp_s2_site_profile-name">';
                $output .= '<span class="wp_s2_site_partner-link">' . esc_html($model['Name']) . ', ' . esc_html($model['Age']) . '</span>';
                $output .= '</div>';
                $output .= '<div class="wp_s2_site_profile-location">' . esc_html($model['Location']) . '</div>';
                $output .= '<div class="wp_s2_site_profile-website"> From: <span class="wp_s2_site_profile-website-link wp_s2_site_partner-link">' . esc_html($offerName) . '</span></div>';
                $output .= '</div>';
                $output .= '<a href="' . esc_url($link) . '" class="wp_s2_site_profile-button wp_s2_site_partner-link">Visit Profile</a>';
                $output .= '</div>';
                $output .= '</div>';
            }

            $output .= '</div>';

            return $output;

        } elseif ($style == 'site3') {

            $output = '<div class="s3_shortcode_reviews-list">';
            $currentIndex = 0;

            foreach ($filteredModels as $key => $model) {
                $randomOfferKey = $offerCount > 0 ? $offers[array_rand($offers)] : '';
                $randomOffer = $offerCount > 0 ? $offers[array_rand($offers)] : '';
                $offerName = isset($modelBrandArray[$randomOffer]) ? $modelBrandArray[$randomOffer]['brandName'] : '';
                $imageUrl = "https://cdn.cdndating.net/images/models/{$key}1.png";
                $link = "/out/offer.php?id=$ModelTracker&o=$randomOfferKey&t=$ModelTag";

                $popularClass = $currentIndex === 0 ? 's3_shortcode_review-item-popular' : '';
                $popularRibbon = $currentIndex === 0 ? '<div class="s3_shortcode_review-item-ribbon"><span>Most Popular Choice</span></div>' : '';

                $output .= '<div class="s3_shortcode_review-item ' . esc_attr($popularClass) . '">';
                $output .= $popularRibbon;
                $output .= '<div class="s3_shortcode_review-item-grid">';
                $output .= '<div class="s3_shortcode_review-item-column">';
                $output .= '<div class="s3_shortcode_logo s3_shortcode_partner-link">';
                $output .= '<img src="' . esc_url($imageUrl) . '" width="240" height="300" class="s3_shortcode_lazyloaded" alt="' . esc_attr($model['Name']) . '">';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '<div class="s3_shortcode_review-item-column s3_shortcode_review-item-column-content">';
                $output .= '<div class="s3_shortcode_review-item-info">';
                $output .= '<a href="' . esc_url($link) . '" class="s3_shortcode_review-title">' . esc_html($model['Name']) . '</a>';
                $output .= '<div class="s3_shortcode_cr-rating-stars"><div class="s3_shortcode_fill" style="width: 100%;"></div></div>';
                $output .= '<p>' . esc_html($model['Interests']) . '</p>';
                $output .= '</div>';
                $output .= '<div class="s3_shortcode_review-item-bottom">';
                $output .= '<div class="s3_shortcode_review-item-average-age">Average Girls Age <div class="s3_shortcode_review-item-average-age-count">' . esc_html($model['Age']) . '</div></div>';
                $output .= '<div class="s3_shortcode_review-item-rating">Our Score <div class="s3_shortcode_review-item-overall-rating"><div>5.0</div></div></div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '<div class="s3_shortcode_review-item-column s3_shortcode_review-item-column-action">';
                $output .= '<div class="s3_shortcode_review-item-buttons">';
                $output .= '<a href="' . esc_url($link) . '" class="s3_shortcode_cr-btn s3_shortcode_square s3_shortcode_partner-link">Visit Site</a>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                $output .= '</div>';
                $currentIndex++;
            }

            $output .= '</div>';

        } elseif ($style == 'site4') {

                $output = '<div class="wp_site4_bride_profiles-grid">';

                foreach ($filteredModels as $key => $model) {
                    $randomOfferKey = $offerCount > 0 ? $offers[array_rand($offers)] : '';
                    $randomOffer = $offerCount > 0 ? $offers[array_rand($offers)] : '';
                    $offerName = isset($modelBrandArray[$randomOffer]) ? $modelBrandArray[$randomOffer]['brandName'] : '';
                    $link = "/out/offer.php?id=$ModelTracker&o=$randomOfferKey&t=$ModelTag";

                    $output .= '<div class="wp_site4_bride_profile-grid-item">';
                    $output .= '<div class="wp_site4_bride_tns-outer">';
                    $output .= '<div class="wp_site4_bride_tns-controls">';
                    $output .= '<button type="button" data-controls="prev">‹</button>';
                    $output .= '<button type="button" data-controls="next">›</button>';
                    $output .= '</div>';
                    $output .= '<div class="wp_site4_bride_tns-visually-hidden">slide <span>1</span> of 5</div>';
                    $output .= '<div id="tns1-mw" class="wp_site4_bride_tns-ovh wp_site4_bride_tns-ah style-qZdYU">';
                    $output .= '<div id="tns1-iw">';
                    $output .= '<div class="wp_site4_bride_profile-top-side wp_site4_bride_tns-slider wp_site4_bride_tns-subpixel wp_site4_bride_tns-horizontal style-YQhZ3" id="tns1">';

                    for ($i = 1; $i <= 4; $i++) {
                        $imageUrl = "https://cdn.cdndating.net/images/models/{$key}{$i}.png";

                        $output .= '<div class="wp_site4_bride_item wp_site4_bride_tns-item">';
                        $output .= '<img src="' . esc_url($imageUrl) . '" width="230" height="280" class="wp_site4_bride_loaded wp_site4_bride_lazyloaded">';
                        if ($i == 4) {
                            $output .= '<div class="wp_site4_bride_more"> ' . esc_html($model['Name']) . ' has more photos!<br>Do you want to watch? <div class="wp_site4_bride_profile-all-photos-button wp_site4_bride_partner-link"><a href="' . esc_url($link) . '" target="_blank" class="wp_site4_bride_profile-button wp_site4_bride_partner-link-view"> View photos </a></div></div>';
                        }
                        $output .= '</div>';
                    }

                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '<div class="wp_site4_bride_tns-nav">';
                    for ($i = 0; $i < 5; $i++) {
                        $output .= '<button type="button" style="' . ($i == 0 ? '' : '') . '" class="' . ($i == 0 ? 'wp_site4_bride_tns-nav-active' : '') . '"></button>';
                    }
                    $output .= '</div>';
                    $output .= '</div>';

                    $output .= '<div class="wp_site4_bride_profile-bottom-side">';
                    $output .= '<div class="wp_site4_bride_profile-info">';
                    $output .= '<div class="wp_site4_bride_profile-name">';
                    $output .= '<span class="wp_site4_bride_partner-link">' . esc_html($model['Name']) . ', ' . esc_html($model['Age']) . '</span>';
                    $output .= '</div>';
                    $output .= '<div class="wp_site4_bride_profile-location">' . esc_html($model['Location']) . '</div>';
                    $output .= '<div class="wp_site4_bride_profile-website"> From: <span class="wp_site4_bride_profile-website-link wp_site4_bride_partner-link">' . esc_html($offerName) . '</span></div>';
                    $output .= '</div>';
                    $output .= '<a href="' . esc_url($link) . '" class="wp_site4_bride_profile-button wp_site4_bride_partner-link"> Find Me </a>';
                    $output .= '</div>';

                    $output .= '</div>';
                }

                $output .= '</div>';

                return $output;

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



if ( ! function_exists( 'customNewTables' ) ) {
    function customNewTables($atts) {
        global $externalTableSettings, $isCloakActive, $newOffersArray;

        if (empty($newOffersArray)) {
            $newOffersArray = include __DIR__ . '/offers-data.php';
            $newOffersArray = $newOffersArray['offers'];
        }

        $atts = shortcode_atts(array(
            'offers' => 'povr',
            'tag' => '',
            'style' => 'style1',
        ), $atts);

        if (!$isCloakActive || ($isCloakActive && !cloakIPChecker())) {
            custom_enqueue_offers_table_css($atts['style']);

            $offerKeys = array_map('trim', explode(',', $atts['offers']));
            $filteredOffersArray = array_filter($newOffersArray, function($key) use ($offerKeys) {
                return in_array($key, $offerKeys);
            }, ARRAY_FILTER_USE_KEY);

            return customNewTableLayouts($atts, $filteredOffersArray);
        }

        return '';
    }

    add_shortcode('new_table', 'customNewTables');
}

if ( ! function_exists( 'customNewTableLayouts' ) ) {
    function customNewTableLayouts($atts, $newOffersArray) {
        $style = $atts['style'];
        $tableHTML = '';

        custom_enqueue_offers_table_css($style);

        if ($style == 'style1') {
                $tableHTML .= '<div class="shortcode-wp_cr-table-style-23 shortcode-wp_cr-rating-table ' . esc_attr($atts['style']) . '">';
                $tableHTML .= '<div class="shortcode-wp_table-head">
                                    <div class="shortcode-wp_editors-choice">Casual Dating Site</div>
                                    <div class="shortcode-wp_rating-meta">
                                        <div class="shortcode-wp_reviews-updated">
                                            <svg width="18" height="25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M17.5967 6.77552c.2198.21967.2198.57582 0 .79549L9.23738 15.9254c-.2198.2197-.57617.2197-.79597 0l-4.00703-4.0046c-.2198-.2197-.2198-.5759 0-.7955l.7428-.7424c.21981-.2197.57617-.2197.79597 0l2.86625 2.8645 7.2185-7.21424c.2198-.21967.5762-.21967.796 0l.7428.74236Z" fill="#4BBB8B"></path>
                                                <path d="M17.5604 12.6105c.2487 0 .4515.2016.4391.4499-.0884 1.7656-.6956 3.4699-1.7505 4.8972-1.1442 1.5482-2.7549 2.6891-4.5957 3.255-1.84079.566-3.81463.5273-5.63176-.1105-1.81713-.6377-3.38181-1.8409-4.46434-3.4328-1.082524-1.592-1.6258656-3.4888-1.55025419-5.4121C.0825572 10.3338.773139 8.48545 1.97731 6.9833c1.20416-1.50215 2.85848-2.57892 4.72007-3.07222 1.71622-.45478 3.52522-.39157 5.20042.17627.2355.07983.3484.34247.2569.57354l-.1658.4184c-.0915.23108-.3528.34288-.589.26514-1.40588-.46278-2.91938-.50921-4.35632-.12844-1.58236.41931-2.98853 1.33456-4.01207 2.61139-1.02354 1.27682-1.61053 2.84802-1.6748 4.48282-.06427 1.6348.39757 3.2471 1.31772 4.6002.92014 1.3532 2.25012 2.3759 3.79468 2.918 1.54456.5421 3.22233.575 4.78699.0939 1.5647-.481 2.9338-1.4508 3.9064-2.7668.8832-1.195 1.3972-2.6185 1.4842-4.0952.0146-.2481.2148-.4498.4635-.4498h.4502Z" fill="#4BBB8B"></path>
                                            </svg>
                                            Updated for November 2024
                                        </div>
                                    </div>
                                </div>';

                $tableHTML .= '<div class="shortcode-wp_reviews-list shortcode-wp_set-positions">';
                $isFirst = true;
                $rating = 5.0;

                foreach ($newOffersArray as $arr_key => $offer) {
                    $highlightClass = $isFirst ? 'shortcode-wp_highlight' : '';
                    $imageSrc = "https://cdn.cdndating.net/images/" . esc_attr($arr_key) . ".png";
                    $userRating = mt_rand(80, 100) / 10;

                    $offerLinkURL = site_url() . "/out/offer.php?id=" . esc_attr($offer['linkID']) . "&o=" . urlencode($arr_key) . "&t=dating";

                    $tableHTML .= '<div class="shortcode-wp_review-item ' . $highlightClass . '" data-position="' . esc_attr($arr_key) . '">';
                    $tableHTML .= '<div class="shortcode-wp_review-item-logo shortcode-wp_type-logo shortcode-wp_partner-link shortcode-wp_data-' . esc_attr($arr_key) . '-reviews-table">';
                    $tableHTML .= '<img decoding="async" src="' . esc_url($imageSrc) . '" width="180" height="60" alt="' . esc_attr($offer['brandName']) . ' Logo" class="shortcode-wp_cr-logotype-logo ls-is-cached lazyloaded">';
                    $tableHTML .= '</div>';

                    $tableHTML .= '<div class="shortcode-wp_review-info-block shortcode-wp_rating-block">';
                    $tableHTML .= '<div class="shortcode-wp_review-info-block-label">Our score</div>';
                    $tableHTML .= '<div class="shortcode-wp_rating">';
                    $tableHTML .= '<div class="shortcode-wp_cr-rating-number">' . number_format($rating, 1) . '</div>';
                    $tableHTML .= '<div class="shortcode-wp_cr-rating-stars" title="Our Score"><div class="shortcode-wp_fill" style="width: ' . esc_attr(($rating / 5) * 100) . '%"></div></div>';
                    $tableHTML .= '</div></div>';

                    $tableHTML .= '<div class="shortcode-wp_review-info-block shortcode-wp_user-rating-block">';
                    $tableHTML .= '<div class="shortcode-wp_review-info-block-label">User Rating</div>';
                    $tableHTML .= '<div class="shortcode-wp_user-rating">' . number_format($userRating, 1) . '</div>';
                    $tableHTML .= '</div>';

                    $tableHTML .= '<div class="shortcode-wp_review-buttons">';
                    $tableHTML .= '<a target="_blank" href="' . esc_url($offerLinkURL) . '" class="shortcode-wp_cr-btn shortcode-wp_small-rounded shortcode-wp_default-size shortcode-wp_site-btn shortcode-wp_partner-link shortcode-wp_data-' . esc_attr($arr_key) . '-reviews-table">Visit Site</a>';
                    $tableHTML .= '<a href="https://example.com?linkID=' . esc_attr($offer['linkID']) . '" class="shortcode-wp_review-link shortcode-wp_cr-btn shortcode-wp_cr-btn-plain shortcode-wp_small-rounded shortcode-wp_default-size">Read Review</a>';
                    $tableHTML .= '</div></div>';

                    $isFirst = false;
                    $rating -= 0.5;
                    if ($rating < 4.0) $rating = 4.0;
                }

                $tableHTML .= '</div></div>';
        } elseif ($style == 'style2') {
                $randomVisitors = rand(1000, 3000);
                $tableHTML .= '<div class="wp_shortcode-bridelist_cr-table-style-15 wp_shortcode-bridelist_cr-rating-table">';
                $tableHTML .= '<div class="wp_shortcode-bridelist_table-head">';
                $tableHTML .= '<div class="wp_shortcode-bridelist_visitors-wrapper">
                                    <span class="wp_shortcode-bridelist_review-visitors"><span>' . $randomVisitors . '</span> people visited this site today
                                        <svg width="11" height="14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.875 0c-3.126 1.72-2.75 6.562-2.75 6.562S2.75 6.125 2.75 4.156C1.11 5.064 0 6.81 0 8.75 0 11.65 2.462 14 5.5 14S11 11.65 11 8.75C11 4.484 6.875 3.61 6.875 0zm-.892 12.191c-1.105.263-2.224-.379-2.5-1.434-.276-1.055.397-2.124 1.502-2.387 2.668-.635 3.003-2.067 3.003-2.067s1.33 5.094-2.005 5.888z" fill="#fff"></path>
                                        </svg>
                                    </span>
                                </div>';
                $tableHTML .= '<div class="wp_shortcode-bridelist_reviews-updated">
                                    <svg width="26" height="26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="m13.584.284 1.66 1.906 2.484-1.059a.742.742 0 0 1 .994.467l.758 2.455 2.694.048a.743.743 0 0 1 .723.83l-.3 2.557 2.442 1.145c.37.175.53.617.356.989-.332.693-.935 1.587-1.343 2.275l1.769 2.047a.75.75 0 0 1-.134 1.096l-2.09 1.484.788 2.592a.744.744 0 0 1-.566.945l-2.506.502-.329 2.688a.744.744 0 0 1-.953.623l-2.443-.557-1.389 2.32a.74.74 0 0 1-1.078.215l-2.052-1.54-2.208 1.554a.737.737 0 0 1-1.07-.249l-1.248-2.242-2.649.517a.742.742 0 0 1-.88-.709l-.229-2.515-2.625-.61a.746.746 0 0 1-.536-.965l.823-2.436-2.152-1.631a.748.748 0 0 1-.055-1.144l1.697-1.843L.63 9.669a.746.746 0 0 1 .357-1.047L3.335 7.61 3.1 4.91a.747.747 0 0 1 .813-.807l2.493.034.878-2.562a.741.741 0 0 1 1.05-.417l2.286 1.06 1.838-1.98a.739.739 0 0 1 1.125.047Zm-6.652 13c-.983-.989.512-2.492 1.495-1.504l3.311 3.33 5.799-6.462c.927-1.036 2.497.384 1.57 1.42l-6.51 7.252a1.054 1.054 0 0 1-1.568.081l-4.097-4.118Z" fill="#ED8A0A"></path>
                                    </svg> Updated for November 2024
                                </div>';
                $tableHTML .= '<div class="wp_shortcode-bridelist_cpm-ajax-info wp_shortcode-bridelist_cpm-advertiser-disclosure"></div></div>';
                $tableHTML .= '<div class="wp_shortcode-bridelist_reviews-list">';

                $itemIndex = 0;
                foreach ($newOffersArray as $arr_key => $offer) {
                    $highlightClass = $itemIndex == 0 ? 'wp_shortcode-bridelist_highlight' : '';
                    $imageSrc = "https://cdn.cdndating.net/images/" . esc_attr($arr_key) . ".png";
                    $userRating = mt_rand(40, 50) / 10;
                    $rating = mt_rand(14, 20) / 2;
                    $offerLinkURL = site_url() . "/out/offer.php?id=" . esc_attr($offer['linkID']) . "&o=" . urlencode($arr_key) . "&t=dating";

                    $tableHTML .= '<div class="wp_shortcode-bridelist_review-item ' . $highlightClass . '">';

                    if ($itemIndex == 0) {
                        $tableHTML .= '<div class="wp_shortcode-bridelist_review-site-label wp_shortcode-bridelist_mobile-only">Site of the day</div>';
                    }

                    $tableHTML .= '<div class="wp_shortcode-bridelist_review-logo wp_shortcode-bridelist_partner-link"><img src="' . esc_url($imageSrc) . '" width="180" height="60" class="wp_shortcode-bridelist_cr-logotype-logo wp_shortcode-bridelist_lazyloaded"></div>';
                    

                    $tableHTML .= '<div class="wp_shortcode-bridelist_review-description wp_shortcode-bridelist_inner-container wp_shortcode-bridelist_mobile-only">';
                    if (!empty($offer['bulletPoints'])) {
                        $bulletPoints = preg_split('/\r\n|\r|\n/', trim($offer['bulletPoints']));
                        $tableHTML .= '<p>' . esc_html(implode(', ', $bulletPoints)) . '</p>';
                    }
                    $tableHTML .= '</div>';


                    $tableHTML .= '<div class="wp_shortcode-bridelist_review-rating wp_shortcode-bridelist_inner-container">
                                        <div class="wp_shortcode-bridelist_cr-rating-stars" title="User Rating">
                                            <div class="wp_shortcode-bridelist_fill" style="width: ' . esc_attr(($userRating / 5) * 100) . '%"></div>
                                        </div>
                                        ' . number_format($userRating, 1) . '/5 rating
                                    </div>';
                    $tableHTML .= '<div class="wp_shortcode-bridelist_review-score wp_shortcode-bridelist_inner-container">
                                        <div class="wp_shortcode-bridelist_score-box">
                                            <div class="wp_shortcode-bridelist_cr-rating-number">' . number_format($rating, 1) . '</div>
                                            <span class="wp_shortcode-bridelist_our-score">Our score</span>
                                        </div>
                                        <div class="wp_shortcode-bridelist_cr-rating-stars" title="Our Score">
                                            <div class="wp_shortcode-bridelist_fill" style="width: ' . esc_attr(($rating / 10) * 100) . '%"></div>
                                        </div>
                                    </div>';
                    $tableHTML .= '<div class="wp_shortcode-bridelist_review-buttons">
                                        <a href="' . esc_url($offerLinkURL) . '" target="_blank" class="wp_shortcode-bridelist_cr-btn wp_shortcode-bridelist_partner-link">Visit Site</a>
                                    </div>';
                    $tableHTML .= '</div>';

                    $itemIndex++;
                }

                $tableHTML .= '</div></div>';
        } elseif ($style == 'single1') {
                $randomVisitors = rand(1000, 3000);
                $tableHTML .= '<div class="wp_shortcode-toplist_cr-table-style-15 wp_shortcode-toplist_cr-rating-table">';
                $tableHTML .= '<div class="wp_shortcode-toplist_table-head">';
                $tableHTML .= '<div class="wp_shortcode-toplist_visitors-wrapper">
                                    <span class="wp_shortcode-toplist_review-visitors"><span>' . $randomVisitors . '</span> people visited this site today
                                        <svg width="11" height="14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.875 0c-3.126 1.72-2.75 6.562-2.75 6.562S2.75 6.125 2.75 4.156C1.11 5.064 0 6.81 0 8.75 0 11.65 2.462 14 5.5 14S11 11.65 11 8.75C11 4.484 6.875 3.61 6.875 0zm-.892 12.191c-1.105.263-2.224-.379-2.5-1.434-.276-1.055.397-2.124 1.502-2.387 2.668-.635 3.003-2.067 3.003-2.067s1.33 5.094-2.005 5.888z" fill="#fff"></path>
                                        </svg>
                                    </span>
                                </div>';
                $tableHTML .= '<div class="wp_shortcode-toplist_reviews-updated">
                                    <svg width="26" height="26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="m13.584.284 1.66 1.906 2.484-1.059a.742.742 0 0 1 .994.467l.758 2.455 2.694.048a.743.743 0 0 1 .723.83l-.3 2.557 2.442 1.145c.37.175.53.617.356.989-.332.693-.935 1.587-1.343 2.275l1.769 2.047a.75.75 0 0 1-.134 1.096l-2.09 1.484.788 2.592a.744.744 0 0 1-.566.945l-2.506.502-.329 2.688a.744.744 0 0 1-.953.623l-2.443-.557-1.389 2.32a.74.74 0 0 1-1.078.215l-2.052-1.54-2.208 1.554a.737.737 0 0 1-1.07-.249l-1.248-2.242-2.649.517a.742.742 0 0 1-.88-.709l-.229-2.515-2.625-.61a.746.746 0 0 1-.536-.965l.823-2.436-2.152-1.631a.748.748 0 0 1-.055-1.144l1.697-1.843L.63 9.669a.746.746 0 0 1 .357-1.047L3.335 7.61 3.1 4.91a.747.747 0 0 1 .813-.807l2.493.034.878-2.562a.741.741 0 0 1 1.05-.417l2.286 1.06 1.838-1.98a.739.739 0 0 1 1.125.047Zm-6.652 13c-.983-.989.512-2.492 1.495-1.504l3.311 3.33 5.799-6.462c.927-1.036 2.497.384 1.57 1.42l-6.51 7.252a1.054 1.054 0 0 1-1.568.081l-4.097-4.118Z" fill="#ED8A0A"></path>
                                    </svg> Updated for November 2024
                                </div>';
                $tableHTML .= '<div class="wp_shortcode-toplist_cpm-ajax-info wp_shortcode-toplist_cpm-advertiser-disclosure"></div></div>';
                $tableHTML .= '<div class="wp_shortcode-toplist_reviews-list">';

                $elementIndex = 0;
                foreach ($newOffersArray as $arr_key => $offer) {
                    $highlightClass = $elementIndex == 0 ? 'wp_shortcode-toplist_highlight' : '';
                    $imageSrc = "https://cdn.cdndating.net/images/" . esc_attr($arr_key) . ".png";
                    $userRating = mt_rand(40, 50) / 10;
                    $rating = mt_rand(14, 20) / 2;
                    $offerLinkURL = site_url() . "/out/offer.php?id=" . esc_attr($offer['linkID']) . "&o=" . urlencode($arr_key) . "&t=dating";

                    $tableHTML .= '<div class="wp_shortcode-toplist_review-item ' . $highlightClass . '">';
                    if ($elementIndex == 0) {
                        $tableHTML .= '<div class="wp_shortcode-toplist_review-site-label">Site of the day</div>';
                    }
                    $tableHTML .= '<div class="wp_shortcode-toplist_review-logo wp_shortcode-toplist_partner-link"><img src="' . esc_url($imageSrc) . '" width="180" height="60" class="wp_shortcode-toplist_cr-logotype-logo wp_shortcode-toplist_lazyloaded"></div>';
                    
                    $tableHTML .= '<div class="wp_shortcode-toplist_review-description wp_shortcode-toplist_inner-container wp_shortcode-toplist_mobile-only">';
                    if (!empty($offer['bulletPoints'])) {
                        $bulletPoints = preg_split('/\r\n|\r|\n/', trim($offer['bulletPoints']));
                        $tableHTML .= '<p>' . esc_html(implode(', ', $bulletPoints)) . '</p>';
                    }
                    $tableHTML .= '</div>';

                    $tableHTML .= '<div class="wp_shortcode-toplist_review-rating wp_shortcode-toplist_inner-container">
                                        <div class="wp_shortcode-toplist_cr-rating-stars" title="User Rating">
                                            <div class="wp_shortcode-toplist_fill" style="width: ' . esc_attr(($userRating / 5) * 100) . '%"></div>
                                        </div>
                                        ' . number_format($userRating, 1) . '/5 rating
                                    </div>';
                    $tableHTML .= '<div class="wp_shortcode-toplist_review-score wp_shortcode-toplist_inner-container">
                                        <div class="wp_shortcode-toplist_score-box">
                                            <div class="wp_shortcode-toplist_cr-rating-number">' . number_format($rating, 1) . '</div>
                                            <span class="wp_shortcode-toplist_our-score">Our score</span>
                                        </div>
                                        <div class="wp_shortcode-toplist_cr-rating-stars" title="Our Score">
                                            <div class="wp_shortcode-toplist_fill" style="width: ' . esc_attr(($rating / 10) * 100) . '%"></div>
                                        </div>
                                    </div>';
                    $tableHTML .= '<div class="wp_shortcode-toplist_review-buttons">
                                        <a href="' . esc_url($offerLinkURL) . '" target="_blank" class="wp_shortcode-toplist_cr-btn wp_shortcode-toplist_partner-link">Visit Site</a>
                                    </div>';
                    $tableHTML .= '</div>';

                    $elementIndex++;
                }
                $tableHTML .= '</div></div>';
        } elseif ($style == 'style3') {
            $tableHTML .= '<div class="insp_woman_wp_shortcode-bridelist_cr-table-style-45 insp_woman_wp_shortcode-bridelist_cr-rating-table">';
            foreach ($newOffersArray as $arr_key => $offer) {
                $highlightClass = $arr_key == 0 ? 'insp_woman_has-review' : '';
                $imageSrc = "https://cdn.cdndating.net/images/" . esc_attr($arr_key) . ".png";
                $userRating = mt_rand(40, 50) / 10;
                $ratingPercentage = esc_attr(($userRating / 5) * 100);
                $ratingFormatted = number_format($userRating, 1);
                $offerLinkURL = site_url() . "/out/offer.php?id=" . esc_attr($offer['linkID']) . "&o=" . urlencode($arr_key) . "&t=dating";

                $tableHTML .= '<div class="insp_woman_review-item ' . $highlightClass . ' insp_woman_snipcss-xGlZY">';
                $tableHTML .= '<div class="insp_woman_review-logo">';
                $tableHTML .= '<figure class="insp_woman_partner-link insp_woman_data-1566-reviews-table">';
                $tableHTML .= '<img decoding="async" src="' . esc_url($imageSrc) . '" width="130" height="62" alt="' . esc_attr($offer['brandName'] ?? '') . '" class="insp_woman_cr-logotype-logo insp_woman_ls-is-cached insp_woman_lazyloaded">';
                $tableHTML .= '<figcaption>' . esc_html($offer['brandName'] ?? '') . '</figcaption>';
                $tableHTML .= '</figure>';
                $tableHTML .= '</div>';
                $tableHTML .= '<div class="insp_woman_cr-rating-stars" title="Our Score">';
                $tableHTML .= '<div class="insp_woman_fill" style="width: ' . $ratingPercentage . '%"></div>';
                $tableHTML .= '</div>';
                $tableHTML .= '<div class="insp_woman_cr-rating-number">' . $ratingFormatted . '</div>';
                $tableHTML .= '<a href="' . esc_url($offerLinkURL) . '" class="insp_woman_cr-btn insp_woman_square insp_woman_default-size insp_woman_site-btn insp_woman_partner-link insp_woman_data-1566-reviews-table" target="_blank">Visit Site</a>';
                $tableHTML .= '</div>';
            }
            $tableHTML .= '</div>';
        }

        return $tableHTML;
    }
}

if ( ! function_exists( 'custom_enqueue_offers_table_css' ) ) {
    function custom_enqueue_offers_table_css($style) {
        $handle = "offers-table-css-$style";
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
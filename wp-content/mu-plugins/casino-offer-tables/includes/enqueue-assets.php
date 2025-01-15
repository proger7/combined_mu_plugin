<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function casino_offer_tables_enqueue_assets() {
    wp_enqueue_style('casino-style-css', plugin_dir_url(__FILE__) . '../assets/css/casino1.css', [], '1.0.0');
}

add_action('wp_enqueue_scripts', 'casino_offer_tables_enqueue_assets');
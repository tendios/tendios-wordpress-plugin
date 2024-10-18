<?php
/*
Plugin Name: Tenders Finder | Tendios
Description: Plugin para mostrar licitaciones públicas en España
Version: 1.0
Author: Antonio Liébana
Author URI: https://tendios.com
*/

// Incluir archivos de funciones
require_once plugin_dir_path(__FILE__) . 'includes/shortcode.php';
require_once plugin_dir_path(__FILE__) . 'includes/settings.php';
require_once plugin_dir_path(__FILE__) . 'includes/helpers.php';

function tendios_plugin_enqueue_styles() {
    wp_enqueue_style('tendios-plugin-styles', plugins_url('assets/styles.css', __FILE__), array(), '1.0', 'all');
}

// Inicializar el plugin
add_action('wp_enqueue_scripts', 'tendios_plugin_enqueue_styles');

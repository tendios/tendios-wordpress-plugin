<?php

function tendios_shortcode($atts) {
    $atts = shortcode_atts(array(
        'location' => '',
        'search' => '',
        'minBudget' => '1000',
        'maxBudget' => '9000000'
    ), $atts, 'tendios');

    $json_file = plugin_dir_path(__FILE__) . '../locations.json';
    if (!file_exists($json_file)) {
        return 'Error: El archivo JSON no se encontró en la ruta: ' . $json_file;
    }

    $json_content = file_get_contents($json_file);
    $locations = json_decode($json_content, true, 512, JSON_UNESCAPED_UNICODE);

    $api_url = 'https://api.tendios.com/v2/tender?count=10&offset=0&status[]=Creada&status[]=Anuncio+Previo&status[]=Publicada&status[]=No+Resuelta&sort=by-published-date&isDescendent=true&isOnlyWithinDeadline=true&isTotalWanted=false';

    $location_normalised = normalize_string(trim($atts['location']));

    $matching_location = null;

    foreach ($locations as $location) {
        $normalized_location_name = normalize_string(trim($location['name']));
        if ($normalized_location_name === $location_normalised) {
            $matching_location = $location;
            break;
        }
    }

    if ($matching_location) {
        $api_url .= '&locations[]=' . $matching_location['queryapi'];
    }  

    if (!empty($atts['search'])) {
        $api_url .= '&text=' . urlencode(trim($atts['search']));
    }

    $minBudget = intval($atts['minBudget']);
    if ($minBudget > 0) {
        $api_url .= '&minBudget=' . $minBudget;
    }

    $maxBudget = intval($atts['maxBudget']);
    if ($maxBudget > 0 && $maxBudget != 9000000) {
        $api_url .= '&maxBudget=' . $maxBudget;
    }

    // Realizar la solicitud a la API
    $api_response = wp_remote_get($api_url);
    if (is_wp_error($api_response)) {
        return 'Error al obtener datos de la API: ' . $api_response->get_error_message();
    }

    $body = wp_remote_retrieve_body($api_response);
    $body = mb_convert_encoding($body, 'UTF-8', 'auto');
    $data = json_decode($body, true);

    if (!isset($data['data']) || empty($data['data'])) {
        return 'No se encontraron licitaciones. Revisa los parámetros del shortcode.';
    }

    $output = '<table class="tendios-api">';
    $output .= '<thead>';
    $output .= '<tr>';
    $output .= '<th>Objeto de Contrato</th>';
    $output .= '<th>Presupuesto</th>';
    $output .= '<th>Tipo de Contrato</th>';
    $output .= '<th>Detalles</th>';
    $output .= '</tr>';
    $output .= '</thead>';
    $output .= '<tbody>';

    foreach ($data['data'] as $tender) {
        $output .= '<tr>';
        $output .= '<td>' . htmlspecialchars(truncate_text($tender['name'], 40), ENT_QUOTES, 'UTF-8') . '</td>';
        $output .= '<td><div class="presupuesto">' . number_format($tender['budgetNoTaxes'], 2, ',', '.') . ' €</div></td>';
        $output .= '<td><div class="tipo-contrato">' . htmlspecialchars($tender['contractType'], ENT_QUOTES, 'UTF-8') . '</div></td>';
        $output .= '<td><a href="https://tendios.com/tenders/' . $tender['_id'] . '" class="btn-ver-mas" target="_blank">Ver Licitación</a></td>';
        $output .= '</tr>';
    }

    $output .= '</tbody>';
    $output .= '</table>';

    return $output;
}

add_shortcode('tendios', 'tendios_shortcode');

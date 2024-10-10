<?php
function tendios_plugin_menu() {
    add_menu_page(
        'Tendios Plugin',
        'Tendios',
        'manage_options',
        'tendios-plugin',
        'tendios_plugin_settings_page',
        'dashicons-admin-tools',  
        100  
    );
}
add_action('admin_menu', 'tendios_plugin_menu');

function tendios_plugin_settings_page() {
    ?>
    <div class="wrap">
        <h1>Tendios Plugin - Configuración</h1>
        <p>Explicación de los parámetros del shortcode:</p>
        <ul>
            <li><strong>→ location</strong>: Nombre de la provincia (obligatorio)</li>
            <li><strong>→ search</strong>: Texto de búsqueda (opcional)</li>
            <li><strong>→ minBudget</strong>: Precio mínimo del presupuesto de la licitación (opcional)</li>
            <li><strong>→ maxBudget</strong>: Precio máximo del presupuesto de la licitación (opcional)</li>
        </ul>
        <p>Ejemplo de uso: [tendios location="Barcelona" search="transporte" minBudget="1000" maxBudget="50000"]</p>

        <h2>Generar Shortcode:</h2>
        <form id="tendios-form">
            <table class="form-table">
                <tr>
                    <th><label for="location">Location</label></th>
                    <td><input type="text" id="location" name="location" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="search">Search</label></th>
                    <td><input type="text" id="search" name="search" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="minBudget">min Budget</label></th>
                    <td><input type="number" id="minBudget" name="minBudget" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="maxBudget">max Budget</label></th>
                    <td><input type="number" id="maxBudget" name="maxBudget" class="regular-text"></td>
                </tr>
            </table>
            <p><button type="submit" class="button button-primary">Generar Shortcode</button></p>
        </form>

        <!-- Hide the shortcode area initially -->
        <div id="shortcode-area" style="display: none;">
            <h3 id="shortcode-header">Shortcode:</h3>
            <textarea id="shortcode-textarea" readonly style="width: 100%; height: 50px;"></textarea>
        </div>

        <script>
            document.getElementById('tendios-form').addEventListener('submit', function(e) {
                e.preventDefault();

                var location = document.getElementById('location').value;
                var search = document.getElementById('search').value;
                var minBudget = document.getElementById('minBudget').value;
                var maxBudget = document.getElementById('maxBudget').value;

                var shortcode = '[tendios location="' + location + '"';

                if (search) {
                    shortcode += ' search="' + search + '"';
                }

                if (minBudget) {
                    shortcode += ' minBudget="' + minBudget + '"';
                }

                if (maxBudget) {
                    shortcode += ' maxBudget="' + maxBudget + '"';
                }

                shortcode += ']';

                // Show the shortcode area
                document.getElementById('shortcode-area').style.display = 'block';

                // Set the shortcode value
                document.getElementById('shortcode-textarea').value = shortcode;
            });
        </script>
    </div>
    <?php
}

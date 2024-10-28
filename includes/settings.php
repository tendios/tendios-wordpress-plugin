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
            <li><strong>→ minbudget</strong>: Precio mínimo del presupuesto de la licitación (opcional)</li>
            <li><strong>→ maxbudget</strong>: Precio máximo del presupuesto de la licitación (opcional)</li>
        </ul>
        <p>Ejemplo de uso: [tendios location="Barcelona" search="transporte" minbudget="1000" maxbudget="50000"]</p>

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
                    <th><label for="minbudget">min Budget</label></th>
                    <td><input type="number" id="minbudget" name="minbudget" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="maxbudget">max Budget</label></th>
                    <td><input type="number" id="maxbudget" name="maxbudget" class="regular-text"></td>
                </tr>
            </table>
            <p><button type="submit" class="button button-primary">Generar Shortcode</button></p>
        </form>

        <!-- Hide the shortcode area initially -->
        <div id="shortcode-area" style="display: none; margin-top: 20px;">
            <h3 id="shortcode-header">Shortcode:</h3>
            <div style="display: flex; align-items: center; max-width: 60%">
                <input type="text" id="shortcode-textarea" readonly style="flex: 1; height: 40px; padding: 10px; border: 1px solid #ccc; border-radius: 4px; margin-right: 5px;">
                <button onclick="copyToClipboard()" style="height: 40px; padding: 0 15px; border: none; border-radius: 4px; background-color: #0073aa; color: white; cursor: pointer;">Copiar <span class="dashicons dashicons-admin-page"></span></button>
            </div>
        </div>

        <script>
            document.getElementById('tendios-form').addEventListener('submit', function(e) {
                e.preventDefault();

                var location = document.getElementById('location').value;
                var search = document.getElementById('search').value;
                var minbudget = document.getElementById('minbudget').value;
                var maxbudget = document.getElementById('maxbudget').value;

                var shortcode = '[tendios location="' + location + '"';

                if (search) {
                    shortcode += ' search="' + search + '"';
                }

                if (minbudget) {
                    shortcode += ' minbudget="' + minbudget + '"';
                }

                if (maxbudget) {
                    shortcode += ' maxbudget="' + maxbudget + '"';
                }

                shortcode += ']';

                // Show the shortcode area
                document.getElementById('shortcode-area').style.display = 'block';

                // Set the shortcode value
                document.getElementById('shortcode-textarea').value = shortcode;
            });

            function copyToClipboard() {
                var copyText = document.getElementById("shortcode-textarea");
                copyText.select();
                document.execCommand("copy");
            
                var copyButton = document.querySelector('#shortcode-area button');
                copyButton.innerHTML = "Copiado al portapapeles <span class='dashicons dashicons-admin-page'></span>";
            
                setTimeout(function() {
                    copyButton.innerHTML = "Copiar <span class='dashicons dashicons-admin-page'></span>";
                }, 2000);
            }
        </script>
    </div>
    <?php
}

<?php
require 'dompdf/vendor/autoload.php'; // Incluye el archivo autoload de Composer para DOMPDF
require 'connection_img.php'; // Incluir el archivo de conexión a la base de datos

use Dompdf\Dompdf;
use Dompdf\Options;

// Opciones de Dompdf
$options = new Options();
$options->set('isHtml5ParserEnabled', true); // Habilitar el parser HTML5
$options->set('isPhpEnabled', true); // Permitir el uso de PHP en el HTML
$options->set('isRemoteEnabled', true); // Habilitar carga de recursos remotos (como imágenes)

// Crear una instancia de Dompdf con las opciones
$dompdf = new Dompdf($options);

// Obtener la URL base del servidor
$base_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/';

// HTML que será convertido en PDF
$html = '<html><body>';

$html .= '<table border="1" cellspacing="0" cellpadding="10">
    <tr>
        <th>#</th>
        <th>Usuario</th>
        <th>Imagen</th>
    </tr>';

// Realizar la consulta a la base de datos
$sql = "SELECT id, name, image FROM tb_upload ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Mostrar datos en cada fila de la tabla
    while ($row = mysqli_fetch_assoc($result)) {
        // Asegurarse de que la URL de la imagen sea absoluta
        $image_url = $base_url . 'img/' . htmlspecialchars($row["image"]);
        $html .= '
        <tr>
            <td>' . htmlspecialchars($row["id"]) . '</td>
            <td>' . htmlspecialchars($row["name"]) . '</td>
            <td><img src="' . $image_url . '" alt="' . htmlspecialchars($row["image"]) . '" style="max-width: 200px; height: auto;"></td>
        </tr>';
    }
} else {
    $html .= '<tr><td colspan="3">No se encontraron resultados</td></tr>';
}

$html .= '</table>';

$html .= '</body></html>';

// Cargar HTML en DOMPDF
$dompdf->loadHtml($html);

// Renderizar PDF
$dompdf->render();

// Salida del PDF (descarga en el navegador)
$dompdf->stream("document.pdf", array("Attachment" => false));

mysqli_close($conn); // Cerrar la conexión a la base de datos
?>
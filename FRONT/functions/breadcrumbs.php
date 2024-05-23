<?php
function generateBreadcrumbs($separator = ' &raquo; ') {
    // Definir la estructura del sitio
    $siteStructure = [
        'index.php' => 'Inicio',
        'registrar.php' => 'Registrar',
        'buscador.php' => 'Buscador',
        'services/web-development.php' => 'Web Development',
        'services/seo.php' => 'SEO',
        'contact.php' => 'Contact'
    ];

    // Obtener la URL actual
    $currentPage = basename($_SERVER['PHP_SELF']);

    // Construir los breadcrumbs
    $breadcrumbs = [];
    $path = '';
    foreach ($siteStructure as $url => $title) {
        $path .= $url;
        if ($url === $currentPage || strpos($currentPage, $url) === 0) {
            $breadcrumbs[$path] = $title;
        }
        $path = '';
    }

    // Renderizar los breadcrumbs
    $breadcrumbString = '';
    foreach ($breadcrumbs as $url => $title) {
        $breadcrumbString .= '<a href="./">Inicio </a>'. $separator. ' <a href="' . $url . '">' . htmlspecialchars($title) . '</a>' . $separator;
    }
    // Eliminar el último separador
    $breadcrumbString = rtrim($breadcrumbString, $separator);

    return $breadcrumbString;
}
?>
<?php
// Helper functie voor afbeelding URLs
function getImageUrl($image_path, $base_path = '../assets/img/') {
    if (empty($image_path)) {
        return $base_path . 'placeholder.jpg';
    }
    
    // Check of het al een volledige URL is (begint met http of https)
    if (strpos($image_path, 'http') === 0) {
        return $image_path;
    }
    
    // Anders gebruik lokale path
    return $base_path . $image_path;
}

// Helper functie voor video poster
function getPosterUrl($image_path, $base_path = '../assets/img/') {
    if (empty($image_path)) {
        return $base_path . 'placeholder.jpg';
    }
    
    // Check of het al een volledige URL is
    if (strpos($image_path, 'http') === 0) {
        return $image_path;
    }
    
    // Anders gebruik lokale path
    return $base_path . $image_path;
}

// Helper functie voor responsive images
function getResponsiveImageHtml($image_path, $alt_text, $css_class = '', $base_path = '../assets/img/') {
    $image_url = getImageUrl($image_path, $base_path);
    $class_attr = $css_class ? ' class="' . htmlspecialchars($css_class) . '"' : '';
    
    return '<img src="' . htmlspecialchars($image_url) . '"' . $class_attr . ' alt="' . htmlspecialchars($alt_text) . '" loading="lazy">';
}
?>
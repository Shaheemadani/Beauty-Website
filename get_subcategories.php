<?php
$category = $_GET['category'] ?? '';

$subcategories = [
    "face" => ["foundation", "primer", "setting-powder", "makeup-remover", "blush"],
    "lip" => ["lipstick", "lip-liner", "lip-stain", "lip-balm", "lip-gloss"],
    "eye" => ["eye-shadow", "mascara", "eye-lashes", "eye-liner"],
    "nail" => ["nail-polish", "nail-remover"]
];

header('Content-Type: application/json');
echo json_encode($subcategories[$category] ?? []);
?>
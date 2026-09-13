<?php
// Forward root requests to the public front controller.
$target = 'public/index.php';
$query = $_SERVER['QUERY_STRING'] ?? '';

if ($query !== '') {
    $target .= '?' . $query;
}

header('Location: ' . $target);
exit;

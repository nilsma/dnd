<?php
/**
 * A file to write the application header
 */

$html = '';
$html = $html . '<!DOCTYPE html>' . "\n";
$html = $html . '<html lang="en">' . "\n";
$html = $html . '  <head>' . "\n";
$html = $html . '    <meta charset="UTF-8">' . "\n";
$html = $html . '    <link rel="stylesheet" href="' . BASE . CSS . 'main.css"/>' . "\n";
$html = $html . '    <script type="text/javascript" src="' . BASE . JS . 'main.js"></script>' . "\n";
$html = $html . '    <title>DND Helper</title>' . "\n";
$html = $html . '  </head>' . "\n";

echo $html;

?>
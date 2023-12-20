<?php

require 'vendor/autoload.php';

use thiagoalessio\TesseractOCR\TesseractOCR;

// Ścieżka do pliku z obrazem
$imagePath = 'tekst.jpg';

// Tworzenie obiektu TesseractOCR
$tesseract = new TesseractOCR($imagePath);

// Odczytywanie tekstu ze zdjęcia
$readText = $tesseract->run();

// Wyświetlenie odczytanego tekstu
echo "Odczytany tekst:\n";
echo $readText;

?>

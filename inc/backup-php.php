<?php 

//Taking help from ChatGPT
// https://chat.openai.com/c/c8bd5a79-e711-4cf4-8dfe-e04c6ab25437


$pattern = "/(\d+)\s*x/";
$string = "Flachbeutel / Säcke 0,050 mm 80 x 120 x 0,050";

preg_match($pattern, $string, $matches);
$number = $matches[1];

echo $number; // Output: 80

//second number
$pattern = "/\bx\s*(\d+)\s*x/";
$string = "Flachbeutel / Säcke 0,050 mm 80 x 120 x 0,050";

preg_match($pattern, $string, $matches);
$number = $matches[1];

echo $number; // Output: 120

$products = [
"Flachbeutel / Säcke 0,050 mm 60 x 20 x 0,050",
"Flachbeutel / Säcke 0,050 mm 60 x 120 x 0,050",
"Flachbeutel / Säcke 0,050 mm 60 x 200 x 0,050",
"Flachbeutel / Säcke 0,050 mm 60 x 250 x 0,050",
"Flachbeutel / Säcke 0,050 mm 60 x 1020 x 0,050",
"Flachbeutel / Säcke 0,050 mm 65 x 150 x 0,050",
"Flachbeutel / Säcke 0,050 mm 80 x 120 x 0,050",
"Flachbeutel / Säcke 0,050 mm 500 x 800 x 0,050",
"Flachbeutel / Säcke 0,050 mm 600 x 1000 x 0,050",
];



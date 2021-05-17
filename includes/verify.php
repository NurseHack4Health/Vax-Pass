<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') Basic::apiResponse(405, 'Only "POST" request method allowed.'); // Only allow POST request

$data = file_get_contents('php://input'); // Request body
$encrypted = base64_decode($data); // Encrypted data

if ( substr($encrypted, 0, 5) !== 'vaxv1' ) Basic::apiResponse(400, 'Error: This QR was not encrypted and generated by Vax Pass.');

if (! empty($encrypted)) {
	$plaintext = Basic::decrypt($encrypted, 'PasswordHere', 'vaxv1');
	Basic::apiResponse(200, $plaintext);
}

Basic::apiResponse(404); // Error 404
<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') Basic::apiResponse(405, 'Only "POST" request method allowed.'); // Only allow POST request

$encrypted = file_get_contents('php://input'); // Encrypted data

if ( substr($encrypted, 0, 5) !== 'encv2' ) Basic::apiResponse(400);

if (! empty($encrypted)) {
	$plaintext = Basic::decrypt($encrypted, PASS_PHRASE, 'encv2');

	if ($plaintext) Basic::apiResponse(200, $plaintext);
	if (! $plaintext) Basic::apiResponse(400);
}

Basic::apiResponse(404); // Error 404

<?php

define('BASE_URL', 'http://localhost/vaxpass/'); // Base URL
define('PASS_PHRASE', 'PasswordHere'); // Encryption passphrase

require __DIR__ . '/basic/Basic.php'; // BasicPHP class library

// Routing
Basic::route('GET', '/generate', function() {
	include __DIR__ . '/includes/generate.php';
});

Basic::route('POST', '/generate', function() {
	include __DIR__ . '/includes/generate.php';
});

Basic::route('GET', '/scanner', function() {
	include __DIR__ . '/includes/scanner.php';
});

Basic::route('POST', '/verify', function() {
	include __DIR__ . '/includes/verify.php';
});

Basic::apiResponse(404); // Error 404
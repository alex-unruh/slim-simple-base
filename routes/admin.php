<?php

$route->get('', function ($request, $response, $args) {
	$response->getBody()->write('Welcome From Admin');
	return $response;
});

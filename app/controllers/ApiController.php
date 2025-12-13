<?php

require_once __DIR__ . '/../services/GeocodingService.php';

class ApiController
{
    public function geocode()
    {
        header('Content-Type: application/json; charset=utf-8');

        try {
            $q = $_GET['q'] ?? '';
            $country = $_GET['country'] ?? null;

            if (trim($q) === '') {
                http_response_code(400);
                echo json_encode(['error' => 'q is required']);
                return;
            }

            $cacheKey = 'geo_' . md5($q . '|' . (string)$country);
            if (isset($_SESSION[$cacheKey]['ts'], $_SESSION[$cacheKey]['data'])) {
                if (time() - (int)$_SESSION[$cacheKey]['ts'] < 600) {
                    echo json_encode($_SESSION[$cacheKey]['data']);
                    return;
                }
            }

            $result = (new GeocodingService())->geocode($q, $country);

            $payload = $result
                ? ['ok' => true, 'result' => $result]
                : ['ok' => false, 'result' => null];

            $_SESSION[$cacheKey] = ['ts' => time(), 'data' => $payload];

            echo json_encode($payload);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Internal error']);
        }
    }

    public function reverseGeocode()
    {
        header('Content-Type: application/json; charset=utf-8');

        try {
            if (!isset($_GET['lat'], $_GET['lon'])) {
                http_response_code(400);
                echo json_encode(['ok' => false, 'error' => 'lat/lon required']);
                return;
            }

            $lat = (float)$_GET['lat'];
            $lon = (float)$_GET['lon'];

            $service = new GeocodingService();
            $result = $service->reverse($lat, $lon);

            echo json_encode([
                'ok' => (bool)$result,
                'result' => $result
            ]);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode([
                'ok' => false,
                'error' => 'Internal server error'
            ]);
        }
    }

}
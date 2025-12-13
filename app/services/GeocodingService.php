<?php

class GeocodingService
{
    private string $baseUrl = 'https://nominatim.openstreetmap.org/search';

    public function geocode(string $query, ?string $countryCode = null): ?array
    {
        $query = trim($query);
        if ($query === '') return null;

        $params = [
            'format' => 'jsonv2',
            'q' => $query,
            'limit' => 1,
            'addressdetails' => 1,
        ];

        if ($countryCode) {
            $params['countrycodes'] = strtolower($countryCode);
        }

        $url = $this->baseUrl . '?' . http_build_query($params);

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'User-Agent: PlanetThere/1.0 (contact: artembash@gmail.com)',
            ],
        ]);

        $raw = curl_exec($ch);
        if ($raw === false) {
            $err = curl_error($ch);
            curl_close($ch);
            throw new \RuntimeException("Nominatim cURL error: " . $err);
        }

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $data = json_decode($raw, true);
        if ($status < 200 || $status >= 300 || !is_array($data)) {
            throw new \RuntimeException("Nominatim error: HTTP {$status}");
        }

        if (count($data) === 0) return null;

        return [
            'lat' => (float) $data[0]['lat'],
            'lon' => (float) $data[0]['lon'],
            'display_name' => (string) ($data[0]['display_name'] ?? ''),
        ];
    }

    public function reverse(float $lat, float $lon): ?array
{
    $url = 'https://nominatim.openstreetmap.org/reverse?' . http_build_query([
        'format' => 'jsonv2',
        'lat' => $lat,
        'lon' => $lon,
        'addressdetails' => 1,
    ]);

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            'User-Agent: PlanetThere/1.0 (contact: artembash@gmail.com)',
        ],
    ]);

    $raw = curl_exec($ch);
    if ($raw === false) { curl_close($ch); return null; }
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data = json_decode($raw, true);
    if ($status < 200 || $status >= 300 || !is_array($data)) return null;

    if (empty($data['display_name'])) return null;

    return [
        'display_name' => (string)$data['display_name'],
        'lat' => isset($data['lat']) ? (float)$data['lat'] : $lat,
        'lon' => isset($data['lon']) ? (float)$data['lon'] : $lon,
    ];
}

}

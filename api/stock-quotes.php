<?php
header('Content-Type: application/json');

$cacheFile = __DIR__ . '/stock-quotes-cache.json';
$cacheTime = 300; // 5 minutes

// Return cached data if it's fresh
if (file_exists($cacheFile) && (time() - filemtime($cacheFile) < $cacheTime)) {
    echo file_get_contents($cacheFile);
    exit;
}

// Symbols to fetch (Stooq format)
$symbols = ['AAPL.US', 'AMD.US', 'BABA.US', 'BMW.DE', 'CSCO.US', 'EBAY.US', 'GOOGL.US', 'KO.US', 'NVDA.US', 'TSLA.US'];
$symbolString = implode('+', $symbols);

// Stooq CSV URL (stable for public data)
$url = "https://stooq.com/q/l/?s=" . $symbolString . "&f=sd2t2ohlc&h&e=csv";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36');
$csv = curl_exec($ch);
curl_close($ch);

$lines = explode("\n", trim($csv));
if (count($lines) > 1) {
    $header = str_getcsv(array_shift($lines));
    $response = [
        'success' => true,
        'source' => 'stooq-csv-live',
        'updated' => date('c'),
        'quotes' => []
    ];

    foreach ($lines as $line) {
        $row = str_getcsv($line);
        if (count($row) < 6) continue;
        
        $symbol = strtolower($row[0]); // e.g. aapl.us
        $price = (float)$row[5]; // Last Price
        $open = (float)$row[4];  // Open
        $change = $price - $open;
        $changePercent = $open != 0 ? ($change / $open) * 100 : 0;

        $response['quotes'][] = [
            'symbol' => $symbol,
            'price' => $price,
            'changePercent' => round($changePercent, 2)
        ];
    }

    $finalJson = json_encode($response, JSON_PRETTY_PRINT);
    file_put_contents($cacheFile, $finalJson);
    echo $finalJson;
} else {
    // Smart Mock Finish if everything fails
    if (file_exists($cacheFile)) {
        $data = json_decode(file_get_contents($cacheFile), true);
        $data['source'] = 'simulated-market';
        $data['updated'] = date('c');
        echo json_encode($data, JSON_PRETTY_PRINT);
    } else {
        echo json_encode(['success' => false, 'error' => 'Unable to fetch market data']);
    }
}
?>

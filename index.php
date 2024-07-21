<?php
// Zaman damgalarını almak için current timestamp kullanıyoruz
$now = time();

// URL'ler ve aralıkları içeren dizi
$urls = [
    [
        'url' => 'https://websiteniz.com/url1.php',
        'interval' => 60 // 1 dakika
    ],
    [
         'url' => 'https://websiteniz.com/url2.php',
        'interval' => 3600 // 1 saat
    ]
    // Daha fazla URL ve aralık eklemek için buraya yeni elemanlar ekleyebilirsiniz
];

// Dosyadan son çalıştırma zamanlarını oku
$last_run_times = [];
$last_run_file = 'urldb.txt';

if (file_exists($last_run_file)) {
    $lines = file($last_run_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        list($url, $last_run_time) = explode('=', $line);
        $last_run_times[$url] = (int)$last_run_time;
    }
}

// URL'ye istek gönderme fonksiyonu
function request_url($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
        // Hata ile ilgili loglama veya başka bir işlem yapılabilir
    }

    curl_close($ch);

    return $response;
}

// URL çalıştırma fonksiyonu
function run_url_if_needed($url_info, $now, &$last_run_times) {
    $url = $url_info['url'];
    $interval = $url_info['interval'];
    $last_run_time = isset($last_run_times[$url]) ? $last_run_times[$url] : 0;

    if (($now - $last_run_time) >= $interval) {
        // URL'yi çalıştır
        request_url($url);

        // Son çalıştırma zamanını güncelle
        $last_run_times[$url] = $now;
    }
}

// Her URL için kontrol ve çalıştırma
foreach ($urls as $url_info) {
    run_url_if_needed($url_info, $now, $last_run_times);
}

// Son çalıştırma zamanlarını dosyaya yaz
$lines = [];
foreach ($last_run_times as $url => $last_run_time) {
    $lines[] = "$url=$last_run_time";
}
file_put_contents($last_run_file, implode("\n", $lines));
?>

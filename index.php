<?php
date_default_timezone_set('Europe/Istanbul');

$baglanti = new mysqli("localhost", "user", "pass", "dbname");  
if ($baglanti->connect_errno > 0) {
    die("<b>Bağlantı Hatası:</b> " . $baglanti->connect_error);
}
$baglanti->set_charset("UTF8");



// Zaman damgalarını almak için current timestamp kullanıyoruz
$now = time();

// URL'ler ve aralıkları içeren dizi
$urls = [];

$cronsorgusu = $baglanti->query("SELECT cronurl, cronsaniye FROM cron");

while ($croncikti = $cronsorgusu->fetch_assoc()) {	
    $urls[] = [
        'url' => $croncikti['cronurl'],
        'interval' => (int)$croncikti['cronsaniye']
    ];
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
function run_url_if_needed($url_info, $now, $baglanti) {
    $url = $url_info['url'];
    $interval = $url_info['interval'];

    // Veritabanından son çalıştırma zamanını alın
    $stmt = $baglanti->prepare("SELECT crondate FROM cron WHERE cronurl = ?");
    $stmt->bind_param('s', $url);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($crondate);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        $last_run_time = strtotime($crondate);
    } 

    $stmt->close();

    if (($now - $last_run_time) >= $interval) {
        // URL'yi çalıştır
        request_url($url);

        // Son çalıştırma zamanını güncelle
        $update_stmt = $baglanti->prepare("UPDATE cron SET crondate = ? WHERE cronurl = ?");
        $crondate = date('Y-m-d H:i:s', $now);
        $update_stmt->bind_param('ss', $crondate, $url);
        $update_stmt->execute();
        $update_stmt->close();
    }
}

// Her URL için kontrol ve çalıştırma
foreach ($urls as $url_info) {
    run_url_if_needed($url_info, $now, $baglanti);
}

$baglanti->close();
?>
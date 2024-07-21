<h1>PHP ile Zamanlanmış URL Çalıştırıcı</h1>

<p>Bu PHP betiği, belirli aralıklarla URL'lere istek göndermek için kullanılabilir. Örneğin, web sitenizde önbelleğe alınmış verileri güncellemek, harici API'leri düzenli olarak kontrol etmek veya zamanlanmış görevler gerçekleştirmek için kullanabilirsiniz.</p>

<h2>Özellikler</h2>

<ul>
    <li>Belirtilen aralıklarla URL'lere otomatik olarak istek gönderir.</li>
    <li>Birden fazla URL'yi ve her bir URL için farklı aralıkları destekler.</li>
    <li>Son çalıştırma zamanlarını bir dosyada saklar, böylece betik yeniden başlatıldığında bile aralıklar korunur.</li>
    <li>Kolay yapılandırma için URL'leri ve aralıkları bir dizide tanımlar.</li>
</ul>

<h2>Kurulum</h2>

<ol>
    <li>Bu betiği sunucunuzdaki bir dosyaya kaydedin (örneğin, <code>url_runner.php</code>).</li>
    <li><code>$urls</code> dizisini istediğiniz URL'ler ve aralıklarla düzenleyin.</li>
    <li>Betiği çalıştırmak için sunucunuzda her dakika çalışan bir cronjob tanımlayın.</li>
</ol>

<h2>Kullanım</h2>

<p><code>$urls</code> dizisi, her biri bir URL ve aralığı temsil eden bir dizi dizi içerir.</p>

<ul>
    <li><code>url</code>: İstek gönderilecek URL.</li>
    <li><code>interval</code>: İstekler arasında beklenmesi gereken süre (saniye cinsinden).</li>
</ul>

<p>Örneğin, <code>https://websiteniz.com/cron.php</code> adresine her 5 dakikada bir istek göndermek için aşağıdaki yapılandırmayı kullanabilirsiniz:</p>

<pre><code>
$urls = [
    [
        'url' => 'https://websiteniz.com/cron.php',
        'interval' => 300 // 5 dakika (saniye cinsinden)
    ]
];
</code></pre>

<h2>Notlar</h2>

<ul>
    <li>Betik, URL'lere istek göndermek için cURL kullanır. Sunucunuzda cURL'nin etkinleştirilmiş olduğundan emin olun.</li>
    <li>Betik, son çalıştırma zamanlarını depolamak için <code>urldb.txt</code> adlı bir dosya kullanır. Bu dosyanın yazma izinlerine sahip olduğundan emin olun.</li>
    <li>Betiğin çalışması için PHP'nin sunucunuzda yüklü olması gerekir.</li>
</ul>



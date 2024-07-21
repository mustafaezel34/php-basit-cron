
    <style>
        body {
            font-family: sans-serif;
        }
        pre {
            background-color: #f0f0f0;
            padding: 10px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 600px;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        code {
            font-family: Consolas, monospace;
        }
    </style>

    <h1>PHP Cron İş Yöneticisi</h1>

    <p>Bu basit PHP betiği, MySQL veritabanını kullanarak cron işlerinizi yönetmenize yardımcı olur. Betik, belirtilen aralıklarda URL'lere istek gönderir ve son çalıştırma zamanını veritabanında günceller.</p>

    <h2>Kurulum</h2>

    <ol>
        <li>
            <h3>Veritabanı Oluşturma:</h3>
            <p>MySQL veritabanınızda "cron" adında bir tablo oluşturun ve aşağıdaki sütunları ekleyin:</p>
            <pre><code>
CREATE TABLE `cron` (
    `cronurl` varchar(255) NOT NULL,
    `crondate` datetime NOT NULL,
    `cronsaniye` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            </code></pre>
            <table>
                <thead>
                    <tr>
                        <th>Sütun Adı</th>
                        <th>Veri Türü</th>
                        <th>Açıklama</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>cronurl</code></td>
                        <td>varchar(255)</td>
                        <td>Çalıştırılacak URL</td>
                    </tr>
                    <tr>
                        <td><code>crondate</code></td>
                        <td>datetime</td>
                        <td>Son çalıştırma zamanı</td>
                    </tr>
                    <tr>
                        <td><code>cronsaniye</code></td>
                        <td>int(11)</td>
                        <td>Çalıştırma sıklığı (saniye cinsinden)</td>
                    </tr>
                </tbody>
            </table>
        </li>
        <li>
            <h3>Veritabanı Bağlantısı:</h3>
            <p>Aşağıdaki kod bloğundaki <code>cron.php</code> dosyasındaki veritabanı bağlantı bilgilerinizi (sunucu adı, kullanıcı adı, parola ve veritabanı adı) güncelleyin:</p>
            <pre><code>
$baglanti = new mysqli("localhost", "user", "pass", "dbname"); 
            </code></pre>
        </li>
        <li>
            <h3>URL'leri Ekleme:</h3>
            <p>Cron işlerinizi yönetmek için "cron" tablosuna URL'leri ve aralıklarını ekleyin. Örneğin:</p>
            <table>
                <thead>
                    <tr>
                        <th>cronurl</th>
                        <th>crondate</th>
                        <th>cronsaniye</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>https://ornek.com/cron1.php</td>
                        <td>2023-10-26 12:00:00</td>
                        <td>3600</td>
                    </tr>
                    <tr>
                        <td>https://ornek.com/cron2.php</td>
                        <td>2023-10-26 12:00:00</td>
                        <td>86400</td>
                    </tr>
                </tbody>
            </table>
        </li>
        <li>
            <h3>Cron Job Oluşturma:</h3>
            <p><code>cron.php</code> dosyasını sunucunuza yükleyin ve düzenli aralıklarla çalışacak bir cron işi ayarlayın. Örneğin, her dakika çalıştırmak için:</p>
            <pre><code>
* * * * * php /path/to/cron.php
            </code></pre>
        </li>
    </ol>

    <h2>Nasıl Çalışır?</h2>

    <p>Bu betik, veritabanındaki "cron" tablosundaki her URL için aşağıdaki adımları gerçekleştirir:</p>
    <ol>
        <li><strong>Son Çalıştırma Zamanını Kontrol Et:</strong> Betik, URL'nin son çalıştırma zamanını veritabanından alır.</li>
        <li><strong>Aralığı Kontrol Et:</strong> Belirtilen aralığın (saniye cinsinden) geçip geçmediğini kontrol eder.</li>
        <li><strong>URL'yi Çalıştır:</strong> Aralık geçtiyse, URL'ye bir istek göndermek için <code>curl</code> kullanır.</li>
        <li><strong>Son Çalıştırma Zamanını Güncelle:</strong> URL başarıyla çalıştırılırsa, veritabanındaki son çalıştırma zamanını günceller.</li>
    </ol>

    <h2>Notlar</h2>

    <ul>
        <li>Bu betik, basit cron işlerini yönetmek için tasarlanmıştır. Daha karmaşık senaryolar için daha gelişmiş bir çözüm kullanmanız gerekebilir.</li>
        <li>Betiğin güvenliğini sağlamak için veritabanı bağlantı bilgilerinizi güvenli bir şekilde saklayın.</li>
        <li><code>curl</code> fonksiyonlarının etkinleştirildiğinden emin olun.</li>
    </ul>



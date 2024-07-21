## PHP Cron İş Yöneticisi

Bu basit PHP betiği, MySQL veritabanını kullanarak cron işlerinizi yönetmenize yardımcı olur. Betik, belirtilen aralıklarda URL'lere istek gönderir ve son çalıştırma zamanını veritabanında günceller.

## Kurulum

1. **Veritabanı Oluşturma:** MySQL veritabanınızda "cron" adında bir tablo oluşturun ve aşağıdaki sütunları ekleyin:
```markdown

   CREATE TABLE `cron` (
       `cronurl` varchar(255) NOT NULL,
       `crondate` datetime NOT NULL,
       `cronsaniye` int(11) NOT NULL
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
   ```

   | Sütun Adı | Veri Türü | Açıklama                   |
   | :-------- | :-------- | :---------------------------- |
   | `cronurl` | varchar(255) | Çalıştırılacak URL        |
   | `crondate` | datetime | Son çalıştırma zamanı       |
   | `cronsaniye` | int(11)    | Çalıştırma sıklığı (saniye) |

2. **Veritabanı Bağlantısı:** `cron.php` dosyasındaki veritabanı bağlantı bilgilerinizi (sunucu adı, kullanıcı adı, parola ve veritabanı adı) güncelleyin:

   ```php
   $baglanti = new mysqli("localhost", "user", "pass", "dbname"); 
   ```

3. **URL'leri Ekleme:** Cron işlerinizi yönetmek için "cron" tablosuna URL'leri ve aralıklarını ekleyin. Örneğin:

   | cronurl                 | crondate            | cronsaniye |
   | :---------------------- | :------------------ | :--------- |
   | https://ornek.com/cron1.php | 2023-10-26 12:00:00 | 3600       |
   | https://ornek.com/cron2.php | 2023-10-26 12:00:00 | 86400      |

4. **Cron Job Oluşturma:** `cron.php` dosyasını sunucunuza yükleyin ve düzenli aralıklarla çalışacak bir cron işi ayarlayın. Örneğin, her dakika çalıştırmak için:

   ```bash
   * * * * * php /path/to/index.php
   ```

## Nasıl Çalışır?

Bu betik, veritabanındaki "cron" tablosundaki her URL için aşağıdaki adımları gerçekleştirir:

1. **Son Çalıştırma Zamanını Kontrol Et:** Betik, URL'nin son çalıştırma zamanını veritabanından alır.
2. **Aralığı Kontrol Et:** Belirtilen aralığın (saniye cinsinden) geçip geçmediğini kontrol eder.
3. **URL'yi Çalıştır:** Aralık geçtiyse, URL'ye bir istek göndermek için `curl` kullanır.
4. **Son Çalıştırma Zamanını Güncelle:** URL başarıyla çalıştırılırsa, veritabanındaki son çalıştırma zamanını günceller.

## Notlar

- Bu betik, basit cron işlerini yönetmek için tasarlanmıştır. Daha karmaşık senaryolar için daha gelişmiş bir çözüm kullanmanız gerekebilir.
- Betiğin güvenliğini sağlamak için veritabanı bağlantı bilgilerinizi güvenli bir şekilde saklayın.
- `curl` fonksiyonlarının etkinleştirildiğinden emin olun.
```

# CASE TO DO

2 ayrı provider'dan gelecek to-do iş bilgilerini çekerek development ekibine haftalık olarak paylaştıracak ve ekrana çıktısını verecek bir web uygulama geliştirme.
Her provider servisinde task ismi, süre (saat olarak), zorluk derecesi vermektedir. Toplam 5 developer var ve her developer’ın 1 saatte yapabildiği iş büyüklüğü aşağıda verildiği gibidir:

| Developer | Süre             | Zorluk |
|-----------|------------------|--------|
| DEV1      | 1h               | 1x     |
| DEV2      | 1h | 2x     |
| DEV3      | 1h | 3x     |
| DEV4      | 1h | 4x     |
| DEV5      | 1h | 5x     |


Developer’ların haftalık 45 saat çalıştığı varsayılarak, en kısa sürede işlerin bitmesini sağlayan bir algoritma ile haftalık developer bazında iş yapma programını ve işin minimum toplam kaç haftada biteceğini ekrana basacak bir ara yüz hazırlanmalı.

Koşullar :
1. Programlama dili olarak PHP ve Framework olarak Symfony 4 tercih edilmeli. (Yetkin olduğun farklı bir framework tercih edebilirsin.)
2. 2 ayrı to-do iş listesi veren API'lerden (aşağıda mock server yanıtlarını bulabilirsin.) iş listesi çekilecek.
3. Burada iş listesini veren servisler Design Pattern ile geliştirilmeli ki daha sonra 3. bir iş listesi veren API'nin eklenmesi gerekirse (Provider 3) bu sadece API tanıtımı ile yapılabilsin.
4. Bu verileri API’lerden çekmek için command (console) yazılacak ve veri tabanına kaydedecek. Ana sayfada veri tabanından okuduğu verilerle planlama sonucunu çıkartıp verileri gösterecek. İhtiyaç halinde ön yüzde Bootstrap ve Jquery vb. kullanılabilir.
5. Backend servisinde Facade, Factory, Proxy, Strategy veya Adapter vb. gibi patternleri ile geliştirme yapılması tercih edilir.

## Kurulum

Gereklilikler:

1. [Docker](https://docs.docker.com/engine/install/)
2. [Docker Compose](https://docs.docker.com/compose/install/)
3. [PHP 8.1](https://www.php.net/downloads.php)
4. [Composer](https://getcomposer.org/download/)
5. [Symfony CLI](https://symfony.com/download)

## Kullanım
Uygulamayı çalıştırmak için aşağıdaki komutları çalıştırabilirsiniz.

```bash
docker-compose up --build -d
```
Migrationları oluşturmak için aşağıdaki kodu çalıştırabilirsiniz.

```bash
php bin/console make:migration
```

```bash
php bin/console doctrine:migrations:migrate
```



Developerları oluşturmak için aşağıdaki kodu çalıştırabilirsiniz.

```bash
php bin/console doctrine:fixtures:load --append
```

Aşağıdaki kod ile taskları oluşturabilirsiniz.

```bash
php bin/console app:create-task
```

# deepfocus

Yapay zeka kullanarak kendi kişisel isteklerime göre sunucumda basitçe çalıştırabileceğim bir planlama uygulaması yapmıştım, gönlünüzce düzenleyip kullanabilirsiniz. Public sunucularda kullanım için tavsiye etmiyorum, kullanacaksanızda lütfen gerekli güvenlik önlemlerini alınız :))

<p float="left">
  <img src="https://github.com/user-attachments/assets/efd0d6a7-4783-4edf-ba19-29baf4d949f5" width="45%" height="450" />
  <img src="https://github.com/user-attachments/assets/2215f42f-0dc4-4731-ba5f-88bd108c6d66" width="45%" height="450" />
</p>


Deep Focus, odaklanarak çalışmak isteyenler için geliştirilmiş modern bir görev planlama ve zaman takip aracıdır.
Günlük hedeflerini planlayabilir, her göreve başlangıç–bitiş saatleri belirleyebilir, çalıştığın süreyi otomatik olarak kaydedebilir ve gün içindeki ilerlemeni dinamik bir progress bar ile takip edebilirsin.

✔️ Özellikler

🗂 Kategori Bazlı Görevler (İş, okul, spor, kişisel vb.)

⏱ Görev Bazlı Geri Sayım ve Çalışma Süresi Takibi

📝 Tarih Filtreleme (Her güne özel görev listesi)

💡 Günlük Motivasyon Sözleri

🔥 Günlük Tamamlama Serisi (Streak)

🔧 Sürükle–Bırak ile görev sıralama

🎨 Modern koyu tema + glassmorphism arayüz

💾 JSON tabanlı API ile verilerin kalıcı olarak saklanması

⏱ Görev geldiğinde ve her saatte 1 bildirim gönderimi yapılmaktadır

# GEREKLİ PAKETLER VE AYARLAR:

```
sudo apt update
sudo apt install apache2 php libapache2-mod-php -y
sudo systemctl restart apache2
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 755 /var/www/html
```
Telegram Botu Oluştur
Telegram'da @BotFather kullanıcısını bul.

/newbot yaz ve botuna bir isim ver.

Sana uzun bir TOKEN verecek (Örn: 123456:ABC-DEF...). Bunu kaydet.

Kendi oluşturduğun bota git ve "Start"a bas.

Tarayıcıdan şu adrese git: https://api.telegram.org/botSENIN_TOKENIN/getUpdates

Sayfada "id": 123456789 yazan kısmı bul. Bu senin Chat ID'n. Bunu da kaydet.

```
crontab -e # 1'i seçip aşağıdaki komutu sonra ekleyebilirsiniz
* * * * * /usr/bin/php /var/www/notify.php
```


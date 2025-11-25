<?php
// =========================================================
// 1. AYARLAR
// =========================================================
$botToken = "TOKEN_BURAYA";
$chatId = "CHAT_ID_BURAYA";
$tasksFile = '/var/www/html/tasks.json';
$logFile = '/var/www/html/bot_log.txt'; // Çift mesajı önlemek için kayıt

date_default_timezone_set('Europe/Istanbul');
$currentDate = date('Y-m-d');
$currentTime = date('H:i'); // Örn: 14:30
$currentHour = date('H');   // Örn: 14
$currentMin = date('i');    // Örn: 30

// Dosya yoksa dur
if (!file_exists($tasksFile)) exit;
$tasks = json_decode(file_get_contents($tasksFile), true);

// Log dosyasını oku
$sentLog = file_exists($logFile) ? file_get_contents($logFile) : '';


// =========================================================
// 2. MODÜL A: "VAKİT GELDİ" BİLDİRİMİ (Her Dakika Kontrol)
// =========================================================
foreach ($tasks as $task) {
    // Benzersiz anahtar: ID + Tarih (Örn: 17098233_2023-10-25)
    $uniqueKey = $task['id'] . '_' . $currentDate;

    // Görev bugünse + Saati geldiyse + Daha önce atılmadıysa
    if ($task['date'] === $currentDate && 
        $task['startTime'] === $currentTime && 
        strpos($sentLog, $uniqueKey) === false) {

        $msg = "🔔 *VAKİT GELDİ!*\n\n";
        $msg .= "🎯 *" . $task['text'] . "*\n";
        $msg .= "⏰ " . $task['startTime'] . " - " . $task['endTime'] . "\n";
        $msg .= "🚀 Hemen masaya geç!";

        sendTelegram($botToken, $chatId, $msg);
        
        // Loga işle (Tekrar atmasın)
        file_put_contents($logFile, $uniqueKey . "\n", FILE_APPEND);
    }
}


// =========================================================
// 3. MODÜL B: SAATLİK DURUM RAPORU (Sadece Dakika 00 ise)
// =========================================================
// Sabah 09:00 ile Akşam 23:00 arasında ve dakika 00 ise çalışır
if ($currentMin === '00' && $currentHour >= 9 && $currentHour <= 23) {
    
    $pendingTasks = [];
    $completedCount = 0;

    foreach ($tasks as $task) {
        if ($task['date'] === $currentDate) {
            if ($task['completed']) {
                $completedCount++;
            } else {
                $pendingTasks[] = $task;
            }
        }
    }

    $pendingCount = count($pendingTasks);

    // Sadece yapılacak iş kaldıysa darlamaya başla
    if ($pendingCount > 0) {
        $msg = "⏳ *DURUM RAPORU ($currentHour:00)*\n\n";
        $msg .= "✅ Biten: *$completedCount*\n";
        $msg .= "🚨 *Kalan: $pendingCount*\n\n";
        $msg .= "👉 *Sıradaki:* " . $pendingTasks[0]['text'] . "\n";
        $msg .= "Zinciri kırma, devam et! 🔥";

        sendTelegram($botToken, $chatId, $msg);
    }
}

// =========================================================
// FONKSİYONLAR
// =========================================================
function sendTelegram($token, $chatId, $msg) {
    $url = "https://api.telegram.org/bot$token/sendMessage";
    $data = [
        'chat_id' => $chatId,
        'text' => $msg,
        'parse_mode' => 'Markdown'
    ];
    
    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    $context  = stream_context_create($options);
    file_get_contents($url, false, $context);
}
?>

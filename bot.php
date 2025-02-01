<?php
// Telegram Bot Token (from BotFather)
$botToken = "7776137055:AAFYkQ6UqG6SDc8rR7HzQbP023FTlbO2pxY";
$telegramApiUrl = "https://api.telegram.org/bot" . $botToken . "/";

// Placeholder HorridAPI base URL
// Update this to the actual base URL of your HorridAPI endpoints.
$horridApiUrl = "https://api.horridapi.example.com/";

/**
 * Send a message to a Telegram chat.
 *
 * @param int    $chatId The Telegram chat ID.
 * @param string $text   The text message to send.
 */
function sendMessage($chatId, $text) {
    global $telegramApiUrl;
    $url = $telegramApiUrl . "sendMessage?chat_id=" . $chatId . "&text=" . urlencode($text);
    file_get_contents($url);
}

/**
 * Make an HTTP GET request using cURL.
 *
 * @param string $url The URL to request.
 * @return string     The response from the request.
 */
function getRequest($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Uncomment the next line if you run into SSL verification issues
    // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

// Retrieve the incoming update from Telegram (as JSON)
$update = json_decode(file_get_contents("php://input"), true);

// Process the update if a message is present
if (isset($update["message"])) {
    $chatId = $update["message"]["chat"]["id"];
    $text = trim($update["message"]["text"]);

    // Split command and argument (if any)
    $parts = explode(" ", $text, 2);
    $command = strtolower($parts[0]);
    $argument = isset($parts[1]) ? trim($parts[1]) : "";

    switch ($command) {
        case "/start":
            $welcome = "Welcome to the HorridAPI Bot!\n\n" .
                       "Available commands:\n" .
                       "/mango_text - Generate text via Mango\n" .
                       "/mango_image - Generate an image via Mango\n" .
                       "/video - Create a video from text\n" .
                       "/song - Download a song\n" .
                       "/bard - Interact with Bard\n" .
                       "/upscale - Upscale an image\n" .
                       "/wiki - Search Wiki\n" .
                       "/proxy - Get a proxy\n" .
                       "/news - Fetch the latest news\n" .
                       "/lyrics - Get song lyrics\n" .
                       "/logo - Generate a logo\n" .
                       "/instadl - Download Instagram media (pass URL after command)\n" .
                       "/imagine - Generate an image using Imagine\n" .
                       "/joke - Get a joke\n" .
                       "/llama - Interact with Llama AI\n" .
                       "/qr - Generate a QR code\n" .
                       "/dare - Get a dare\n" .
                       "/truth - Get a truth";
            sendMessage($chatId, $welcome);
            break;

        case "/mango_text":
            $url = $horridApiUrl . "mango_text?model=gpt-3.5-turbo&message=" . urlencode("Hello");
            $response = getRequest($url);
            sendMessage($chatId, "Mango Text: " . $response);
            break;

        case "/mango_image":
            $url = $horridApiUrl . "mango_image?model=flux-1.1-pro&prompt=" . urlencode("a boy looking in the river");
            $response = getRequest($url);
            sendMessage($chatId, "Mango Image: " . $response);
            break;

        case "/video":
            // Replace with your LLVA API key
            $llvaApiKey = "YOUR_LLVA_API_KEY";
            $url = $horridApiUrl . "video?prompt=" . urlencode("a girl and boy kissing") . "&api_key=" . urlencode($llvaApiKey);
            $response = getRequest($url);
            sendMessage($chatId, "Video generated: " . $response);
            break;

        case "/song":
            $url = $horridApiUrl . "song?name=" . urlencode("thallumaala");
            $response = getRequest($url);
            sendMessage($chatId, "Song URL: " . $response);
            break;

        case "/bard":
            $url = $horridApiUrl . "bard?text=" . urlencode("hi");
            $response = getRequest($url);
            sendMessage($chatId, "Bard says: " . $response);
            break;

        case "/upscale":
            // Replace with your image URL and API key
            $apiKey = "YOUR_API_KEY";
            $imageUrl = "https://www.example.jpg";
            $url = $horridApiUrl . "upscale?url=" . urlencode($imageUrl) . "&api_key=" . urlencode($apiKey) . "&scale=8";
            $response = getRequest($url);
            sendMessage($chatId, "Upscaled Image: " . $response);
            break;

        case "/wiki":
            $url = $horridApiUrl . "wiki?query=" . urlencode("what is ai?");
            $response = getRequest($url);
            sendMessage($chatId, "Wiki: " . $response);
            break;

        case "/proxy":
            $url = $horridApiUrl . "proxy?url=" . urlencode("https://www.google.com/");
            $response = getRequest($url);
            sendMessage($chatId, "Proxy: " . $response);
            break;

        case "/news":
            $url = $horridApiUrl . "news?query=" . urlencode("today news");
            $response = getRequest($url);
            sendMessage($chatId, "News: " . $response);
            break;

        case "/lyrics":
            $url = $horridApiUrl . "lyrics?name=" . urlencode("thallumaala");
            $response = getRequest($url);
            sendMessage($chatId, "Lyrics: " . $response);
            break;

        case "/logo":
            $url = $horridApiUrl . "logo?text=" . urlencode("mrz bots");
            $response = getRequest($url);
            sendMessage($chatId, "Logo: " . $response);
            break;

        case "/instadl":
            if (empty($argument)) {
                sendMessage($chatId, "Usage: /instadl <Instagram URL>");
            } else {
                $url = $horridApiUrl . "instadl?url=" . urlencode($argument);
                $response = getRequest($url);
                sendMessage($chatId, "Instagram Media: " . $response);
            }
            break;

        case "/imagine":
            // Replace with your API key if needed
            $apiKey = "YOUR_API_KEY";
            $url = $horridApiUrl . "imagine?prompt=" . urlencode("a cute cat") . "&api_key=" . urlencode($apiKey);
            $response = getRequest($url);
            sendMessage($chatId, "Imagine Image: " . $response);
            break;

        case "/joke":
            $url = $horridApiUrl . "joke";
            $response = getRequest($url);
            sendMessage($chatId, "Joke: " . $response);
            break;

        case "/llama":
            $url = $horridApiUrl . "llama?text=" . urlencode("who are you");
            $response = getRequest($url);
            sendMessage($chatId, "Llama says: " . $response);
            break;

        case "/qr":
            $url = $horridApiUrl . "qr?text=" . urlencode("hi");
            $response = getRequest($url);
            sendMessage($chatId, "QR Code: " . $response);
            break;

        case "/dare":
            $url = $horridApiUrl . "dare";
            $response = getRequest($url);
            sendMessage($chatId, "Dare: " . $response);
            break;

        case "/truth":
            $url = $horridApiUrl . "truth";
            $response = getRequest($url);
            sendMessage($chatId, "Truth: " . $response);
            break;

        default:
            sendMessage($chatId, "Unknown command. Use /start to see available commands.");
            break;
    }
}
?>

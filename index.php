<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>API Handshake Assignment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f9f9f9;
        }
        h2 {
            color: #333;
        }
        pre {
            background: #eee;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
        }
        .success {
            color: green;
            font-weight: bold;
        }
        .failed {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<?php
// ==========================
// CONFIG (API LINK)
// ==========================
$base_url = "https://staging.collabmed.net/api/external";

$platform_name = "Test Platform v2";
$platform_key = "afya_2d00d74512953c933172ab924f5073fa";
$platform_secret = "e0502a5c052842cf19d0305455437b791d201761c88e2ad641680b2d5d356ba8";

// ==========================
// FUNCTION TO CALL API
// ==========================
function callAPI($url, $data) {
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        die("cURL Error: " . curl_error($ch));
    }

    curl_close($ch);

    return json_decode($response, true);
}

// ==========================
// STEP 1: INITIATE HANDSHAKE
// ==========================
$initiate_url = $base_url . "/initiate-handshake";

$initiate_data = [
    "platform_name" => $platform_name,
    "platform_key" => $platform_key,
    "platform_secret" => $platform_secret,
    "callback_url" => "http://localhost/afya/index.php"
];

$initiate_response = callAPI($initiate_url, $initiate_data);

echo "<h2>Step 1: Initiate Handshake</h2>";
echo "<pre>";
print_r($initiate_response);
echo "</pre>";

if (!$initiate_response || !$initiate_response['success']) {
    die("<p class='failed'>❌ Failed to initiate handshake</p>");
}

// Extract token
$handshake_token = $initiate_response['data']['handshake_token'];

// ==========================
// STEP 2: COMPLETE HANDSHAKE
// ==========================
$complete_url = $base_url . "/complete-handshake";

$complete_data = [
    "handshake_token" => $handshake_token,
    "platform_key" => $platform_key
];

$complete_response = callAPI($complete_url, $complete_data);

echo "<h2>Step 2: Complete Handshake</h2>";
echo "<pre>";
print_r($complete_response);
echo "</pre>";

if ($complete_response && $complete_response['success']) {
    echo "<p class='success'>✅ SUCCESS</p>";
    echo "<p>Access Token: <strong>" . $complete_response['data']['access_token'] . "</strong></p>";
} else {
    echo "<p class='failed'>❌ FAILED</p>";
}
?>

</body>
</html>

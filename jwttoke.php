<?php
// 1️⃣ Create header and payload arrays
$header = [
    "alg" => "HS256",
    "typ" => "JWT"
];

$payload = [
    "bank" => "Example Bank",
    "application" => "LenderApp",
    "exp" => time() + 3600  // expires in 1 hour
];

// 2️⃣ Convert to JSON
$header_json = json_encode($header);
$payload_json = json_encode($payload);

// 3️⃣ Encode to Base64URL (safe for URLs)
function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

$header_base64 = base64url_encode($header_json);
$payload_base64 = base64url_encode($payload_json);

// 4️⃣ Create a simple signature (HMAC SHA256)
$secret = "my_secret_key_123";
$signature = hash_hmac('sha256', "$header_base64.$payload_base64", $secret, true);
$signature_base64 = base64url_encode($signature);

// 5️⃣ Combine all three parts to form a token
$jwt = "$header_base64.$payload_base64.$signature_base64";

echo "✅ Generated JWT:\n$jwt\n\n";

// 6️⃣ Decode payload (for demonstration)
list($header_b64, $payload_b64, $sig_b64) = explode('.', $jwt);

function base64url_decode($data) {
    return base64_decode(strtr($data, '-_', '+/'));
}

$decoded_payload = json_decode(base64url_decode($payload_b64), true);
echo "📦 Decoded Payload:\n";
print_r($decoded_payload);
?>

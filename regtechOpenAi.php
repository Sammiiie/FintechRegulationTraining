<?php
// RegTech Compliance Analyzer using OpenAI GPT API
// -----------------------------------------------
// This demo analyzes financial text for potential regulatory red flags

$apiKey = "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"; // Replace with your key

// Sample financial disclosure or complaint text
$text = "
Loan Agreement:
Borrowers agree to repay ₦100,000 within 10 days.
Failure to repay may lead to automatic debit of all linked accounts.
Service fee: ₦12,000 (non-refundable).
Data may be shared with partners for credit scoring.
";

// Step 1: Define the prompt for AI
$prompt = "
You are a RegTech compliance assistant.
Analyze the following financial text for potential violations of:
- consumer protection
- data privacy
- transparency
- fair lending

Text:
$text

Output in JSON with keys: 'issues', 'recommendations', and 'severity_level'.
";

$ch = curl_init("https://api.openai.com/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // ✅ For localhost testing
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $apiKey"
]);

$data = [
    "model" => "gpt-3.5-turbo",
    "messages" => [
        ["role" => "system", "content" => "You are a RegTech compliance analysis assistant."],
        ["role" => "user", "content" => $prompt]
    ],
    "temperature" => 0.2
];

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
$response = curl_exec($ch);

if (curl_errno($ch)) {
    die("❌ cURL Error: " . curl_error($ch));
}

$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$result = json_decode($response, true);

if ($http_code !== 200) {
    echo "❌ API Error ($http_code):<br>";
    echo "<pre>" . htmlspecialchars($response) . "</pre>";
    exit;
}

if (isset($result['choices'][0]['message']['content'])) {
    echo "<h3>✅ RegTech AI Analysis</h3><pre>";
    echo htmlspecialchars($result['choices'][0]['message']['content']);
    echo "</pre>";
} else {
    echo "❌ No response content found.<br>";
    echo "<pre>" . htmlspecialchars($response) . "</pre>";
}
?>
<?php
// ===============================================
// SUPTECH AI EARLY WARNING SYSTEM
// Using OpenAI GPT API
// ===============================================

$apiKey = "YOUR_OPENAI_API_KEY";

// Example complaints (could be fetched from DB, Twitter API, or logs)
$complaints = [
    "This loan app keeps calling my family members for repayment!",
    "ZedWallet shared my BVN details without my consent!",
    "Transfer failed but money was deducted from my account.",
    "The payment platform has been down for hours!",
    "The customer service refused to refund me after an error."
];

// Prepare the text input for analysis
$complaintText = implode("\n- ", $complaints);

$prompt = "
You are a SupTech compliance and consumer protection assistant
working for a financial regulator (like CBN or FCCPC Nigeria).

Analyze the following consumer complaints and return a structured JSON report
showing: complaint_summary, detected_risks, severity_level (High/Medium/Low),
and supervisory_recommendations.

Complaints:
- $complaintText
";

// Step 1: Initialize cURL request to OpenAI
$ch = curl_init("https://api.openai.com/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $apiKey"
]);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Optional for localhost

// Step 2: Send message to GPT
$data = [
    "model" => "gpt-3.5-turbo",
    "messages" => [
        ["role" => "system", "content" => "You are an expert in financial supervision and consumer protection."],
        ["role" => "user", "content" => $prompt]
    ],
    "temperature" => 0.3
];

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Step 3: Execute and parse response
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code !== 200) {
    echo "❌ API Error ($http_code):<br><pre>" . htmlspecialchars($response) . "</pre>";
    exit;
}

$result = json_decode($response, true);
$output = $result['choices'][0]['message']['content'] ?? "No valid output.";

// Step 4: Display formatted SupTech Report
echo "<h2>🏦 SUPTECH AI EARLY WARNING REPORT</h2>";
echo "<pre>" . htmlspecialchars($output) . "</pre>";

// Optional: Try to decode JSON (if GPT outputs valid structure)
$jsonPart = json_decode($output, true);
if ($jsonPart) {
    echo "<hr><h3>Parsed Summary Table</h3>";
    echo "<table border='1' cellpadding='6' cellspacing='0'>
            <tr><th>Complaint</th><th>Detected Risks</th><th>Severity</th><th>Supervisory Recommendations</th></tr>";
    foreach ($jsonPart as $entry) {
        echo "<tr>
                <td>{$entry['complaint_summary']}</td>
                <td>{$entry['detected_risks']}</td>
                <td><b>{$entry['severity_level']}</b></td>
                <td>{$entry['supervisory_recommendations']}</td>
              </tr>";
    }
    echo "</table>";
}
?>

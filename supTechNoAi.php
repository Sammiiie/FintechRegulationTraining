<?php
// SUPTECH EARLY WARNING SYSTEM
// ----------------------------
// Simulates how supervisors can monitor fintech complaints
// using basic keyword detection and sentiment logic in PHP.

// Sample "complaints" or "social media posts"
$complaints = [
    "My loan app keeps calling my family members for repayment!",
    "Bank debited me twice and didn’t reverse it.",
    "This fintech app is excellent, easy to use.",
    "ZedWallet shared my BVN details without my consent!",
    "Transfer failed but money was deducted from my account!",
    "The payment platform is down again. Same issue every week!"
];

// Define risk categories and related keywords
$riskIndicators = [
    "data_privacy" => [
        "keywords" => ["bvn", "consent", "privacy", "shared data", "contact list"],
        "risk_level" => "High",
        "message" => "Possible NDPR or Data Privacy Breach"
    ],
    "unauthorized_debit" => [
        "keywords" => ["debited", "double charge", "not reversed", "unauthorized debit"],
        "risk_level" => "Medium",
        "message" => "Unauthorized Debit or Refund Delay"
    ],
    "harassment" => [
        "keywords" => ["calling", "family", "threaten", "harass"],
        "risk_level" => "High",
        "message" => "Aggressive Debt Recovery Practice"
    ],
    "system_failure" => [
        "keywords" => ["down", "failed", "error", "unavailable"],
        "risk_level" => "Medium",
        "message" => "Systemic or Platform Instability"
    ]
];

$alerts = [];

// Analyze complaints
foreach ($complaints as $index => $text) {
    $matched = [];
    foreach ($riskIndicators as $category => $rule) {
        foreach ($rule["keywords"] as $keyword) {
            if (stripos($text, $keyword) !== false) {
                $alerts[] = [
                    "complaint_id" => $index + 1,
                    "complaint_text" => $text,
                    "category" => ucfirst(str_replace("_", " ", $category)),
                    "risk_level" => $rule["risk_level"],
                    "flag" => $rule["message"]
                ];
                break;
            }
        }
    }
}

// Display SupTech Report
echo "<h2>🏦 SUPTECH EARLY WARNING DASHBOARD</h2>";

if (empty($alerts)) {
    echo "<p>✅ No early warnings triggered.</p>";
} else {
    echo "<table border='1' cellpadding='6' cellspacing='0'>
            <tr>
              <th>#</th>
              <th>Complaint Text</th>
              <th>Detected Category</th>
              <th>Risk Level</th>
              <th>Flag / Description</th>
            </tr>";

    foreach ($alerts as $a) {
        echo "<tr>
                <td>{$a['complaint_id']}</td>
                <td>{$a['complaint_text']}</td>
                <td>{$a['category']}</td>
                <td><b>{$a['risk_level']}</b></td>
                <td>{$a['flag']}</td>
              </tr>";
    }

    echo "</table>";

    // Summary metrics
    $totalAlerts = count($alerts);
    $highRisk = count(array_filter($alerts, fn($a) => $a['risk_level'] === "High"));
    echo "<hr><b>Summary:</b> $totalAlerts total alerts, $highRisk High-Risk cases detected.";
}
?>

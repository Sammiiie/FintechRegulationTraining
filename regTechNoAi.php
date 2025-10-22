<?php
// Simple Rule-Based RegTech Analyzer
// ----------------------------------
// This version does not use AI or paid APIs.
// It uses keyword detection and logic to simulate compliance analysis.

// $text = "
// Loan Agreement:
// Borrower agrees to repay ₦50,000 in 10 days.
// Late repayment will attract a penalty of ₦10,000.
// Lender may access contact list to recover funds.
// Service charge: ₦7,500, non-refundable.
// ";

$text = "Loan app requires access to contact list before disbursing funds..";

// Define simple keyword patterns for red flags
$rules = [
    "data_privacy" => [
        "keywords" => ["access contact", "share data", "third party", "partners", "phone contacts"],
        "issue" => "Possible data privacy violation — user data may be shared without consent."
    ],
    "high_fee" => [
        "keywords" => ["fee", "charge", "penalty"],
        "issue" => "High or unclear service fee detected — may violate transparency rules."
    ],
    "debt_collection" => [
        "keywords" => ["debit", "recover", "harass", "threaten"],
        "issue" => "Aggressive or automatic debt recovery — potential consumer protection breach."
    ],
    "short_repayment" => [
        "keywords" => ["10 days", "7 days"],
        "issue" => "Very short repayment period — could violate fair lending standards."
    ]
];

// Run analysis
$findings = [];
foreach ($rules as $category => $rule) {
    foreach ($rule["keywords"] as $word) {
        if (stripos($text, $word) !== false) {
            $findings[] = [
                "category" => $category,
                "keyword" => $word,
                "issue" => $rule["issue"]
            ];
            break;
        }
    }
}

// Output result
echo "<h3>🔍 Rule-Based RegTech Report</h3>";

if (empty($findings)) {
    echo "<p>✅ No major compliance issues found.</p>";
} else {
    echo "<table border='1' cellpadding='6' cellspacing='0'>
            <tr><th>Category</th><th>Matched Keyword</th><th>Detected Issue</th></tr>";
    foreach ($findings as $f) {
        echo "<tr>
                <td>{$f['category']}</td>
                <td>{$f['keyword']}</td>
                <td>{$f['issue']}</td>
              </tr>";
    }
    echo "</table>";
}

echo "<hr><b>Recommendation:</b> Ensure all fees are disclosed, customer consent obtained, and fair treatment maintained.";
?>

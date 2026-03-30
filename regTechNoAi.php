<?php
// Simple Rule-Based RegTech Analyzer
// ----------------------------------
// This version does not use AI or paid APIs.
// It uses keyword detection and logic to simulate compliance analysis.

$text = "
Loan Agreement:
The Company reserves the right to revise interest rates, charges or repayment
terms at any time, provided such changes are deemed necessary by the Company
for operational reasons.
All applicable fees and charges are included in the total cost of credit. Detailed
computation methods and daily interest accrual rates will be provided to the
customer on monthly but not invariable basis provided there are no operational
impediments.
By accepting this Agreement, the Borrower consents to the collection, analysis, and
unrestricted use of personal and transactional data by the Company or its partners
for credit scoring, marketing, or other business purposes.
The Borrower irrevocably waives the right to commence or participate in any class
action, collective proceeding or seeking redress with any 3 rd party outside of this
agreement
The Company may, at its discretion, provide informational materials to Borrowers
regarding financial management. Such materials may attract a token and will be
tailored to general circumstances.
Any complaint or claim arising under this Agreement must be submitted in writing
within three (3) days of the occurrence giving rise to the complaint. The Company’s
decision on all complaints shall be final and binding.
";

//$text = "Loan app requires access to contact list before disbursing funds..";

// Define simple keyword patterns for red flags
$rules = [
    "data_privacy" => [
        "keywords" => ["access contact", "share data", "third party", "partners", "phone contacts", "contact list", "consent"],
        "issue" => "Possible data privacy violation — user data may be shared without consent."
    ],
    "high_fee" => [
        "keywords" => ["penalty"],
        "issue" => "High or unclear service fee detected — may violate transparency rules."
    ],
    "debt_collection" => [
        "keywords" => ["debit", "recover", "harass", "threaten", "ethical"],
        "issue" => "Aggressive or automatic debt recovery — potential consumer protection breach."
    ],
    "ethical_debt_collection" => [
        "keywords" => ["ethical", "offer letter", "notice", "demand notice", "variation"],
        "issue" => "Aggressive or automatic debt recovery — potential consumer protection breach."
    ],
    "short_repayment" => [
        "keywords" => ["10 days", "7 days"],
        "issue" => "Very short repayment period — could violate fair lending standards."
    ],
    "exceptions" => [
        "keywords" => ["law enforcement", "regulator"],
        "issue" => "Data can be shared to these entities."
    ],
    "disclosure" => [
        "keywords" => ["contract"],
        "issue" => "Very short repayment period — could violate fair lending standards."
    ],
     "fair_treatment" => [
        "keywords" => ["equal rate", "clear", "understand", "not misleading"],
        "issue" => "The t and C shows fair treatment."
     ],
     "consumer_education" => [
        "keywords" => ["educate", "inform", "awareness", "transparent"],
        "issue" => "The t and C shows fair treatment."
     ],
     "complaints_handling" => [
        "keywords" => ["rsolution", "complaint", "feedback", "support","timeline","24hrs","48hrs","compliants id", "tracking"],
        "issue" => "This t and C shows complaints handling mechanism."
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

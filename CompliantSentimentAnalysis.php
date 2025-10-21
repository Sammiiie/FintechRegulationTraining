<?php
$complaints = [
    "This loan app harassed me for payment!",
    "Great service, fast transfers!",
    "Hidden fees everywhere, not using again!"
];

foreach ($complaints as $text) {
    $negativeWords = ["harassed", "hidden", "not", "bad"];
    $score = 0;
    foreach ($negativeWords as $word) {
        if (stripos($text, $word) !== false) {
            $score--;
        }
    }
    echo "Complaint: $text\nSentiment: " . ($score < 0 ? "Negative ⚠️" : "Positive ✅") . "\n\n";
}
?>

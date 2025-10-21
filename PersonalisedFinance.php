<?php
$userSpending = ["groceries" => 60, "entertainment" => 30, "savings" => 10];

if ($userSpending["savings"] < 20) {
    echo "💡 Suggestion: Open a high-yield savings plan to grow your balance.\n";
} elseif ($userSpending["entertainment"] > 40) {
    echo "💡 Suggestion: Set entertainment budget alerts to control spending.\n";
} else {
    echo "✅ Your spending habits look balanced!\n";
}
?>

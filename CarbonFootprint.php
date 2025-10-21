<?php
$transactions = [
    ["customer" => "A", "amount" => 1000, "category" => "Transport"],
    ["customer" => "B", "amount" => 500,  "category" => "Energy"]
];

$carbon_factors = ["Transport" => 0.3, "Energy" => 0.7]; // kg CO₂ per Naira

foreach ($transactions as $t) {
    $carbon = $t["amount"] * $carbon_factors[$t["category"]];
    echo "{$t['customer']} - {$carbon} kg CO₂ emitted\n";
}
?>

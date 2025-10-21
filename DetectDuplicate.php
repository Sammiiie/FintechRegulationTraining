<?php
$transactions = [
    ['CustomerID' => 1, 'Amount' => 1000, 'Merchant' => 'LoanApp'],
    ['CustomerID' => 1, 'Amount' => 1000, 'Merchant' => 'LoanApp'],
    ['CustomerID' => 2, 'Amount' => 2500, 'Merchant' => 'PayNow'],
    ['CustomerID' => 3, 'Amount' => 500,  'Merchant' => 'ShopMe'],
    ['CustomerID' => 3, 'Amount' => 500,  'Merchant' => 'ShopMe'],
    ['CustomerID' => 3, 'Amount' => 20000,'Merchant' => 'CryptoFast']
];

echo "⚠️ Potential Duplicate Transactions:\n";
for ($i = 0; $i < count($transactions); $i++) {
    for ($j = $i + 1; $j < count($transactions); $j++) {
        if (
            $transactions[$i]['CustomerID'] === $transactions[$j]['CustomerID'] &&
            $transactions[$i]['Amount'] === $transactions[$j]['Amount'] &&
            $transactions[$i]['Merchant'] === $transactions[$j]['Merchant']
        ) {
            print_r($transactions[$i]);
        }
    }
}
?>

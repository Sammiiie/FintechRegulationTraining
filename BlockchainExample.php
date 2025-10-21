<?php
function hashBlock($data) {
    return hash('sha256', $data);
}

$block1 = hashBlock("Alice pays Bob ₦100");
$block2 = hashBlock($block1 . "Bob pays Carol ₦50");

echo "Block 1: $block1\n";
echo "Block 2: $block2\n";
?>

<?php
function checkPasswordStrength($password) {
    if (strlen($password) >= 8 &&
        preg_match('/[A-Z]/', $password) &&
        preg_match('/[a-z]/', $password) &&
        preg_match('/[0-9]/', $password) &&
        preg_match('/[!@#$%^&*]/', $password)) {
        return "✅ Strong password";
    }
    return "❌ Weak password";
}

echo checkPasswordStrength("Pass123") . "\n";
echo checkPasswordStrength("StrongPass#2025") . "\n";
?>

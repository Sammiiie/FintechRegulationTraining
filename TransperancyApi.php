<?php
$licenseData = [
    "company_name" => "PayLink Digital",
    "license_id" => "CBN-FINTECH-23456",
    "license_status" => "Approved",
    "valid_until" => "2026-12-31",
    "transparency_url" => "https://paylink.ng/legal/disclosures"
];

header('Content-Type: application/json');
echo json_encode($licenseData, JSON_PRETTY_PRINT);
?>

<?php
/**
 * File: git-deploy.php
 * Version: 1.0.0
 * Description: Secure webhook to auto-deploy updates from GitHub.
 *              This script verifies GitHub's webhook signature and runs `git pull origin main`
 *              to deploy changes automatically on the production server.
 *
 * Author: WP Speed Expert
 * Author URI: https://wpspeedexpert.com
 * 
 * Important: The secret key must match the one set in GitHub Webhook settings.
 */

// Secret key (set this in GitHub Webhook settings)
$secret = "your-webhook-secret-key";

// Read the raw POST data
$payload = file_get_contents("php://input");

// Verify webhook signature
$signature = "sha256=" . hash_hmac("sha256", $payload, $secret);
if (!hash_equals($signature, $_SERVER["HTTP_X_HUB_SIGNATURE_256"])) {
    http_response_code(403);
    exit("Invalid webhook signature");
}

// Run Git Pull
shell_exec("cd /home/onsalenow/htdocs/www.onsalenow.ie/public && git pull origin main 2>&1");

// Return success response
http_response_code(200);
?>

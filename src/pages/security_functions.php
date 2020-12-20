<?php
ini_set('session.cookie_httponly', 1);
function generate_random_token() {
    try {
        return bin2hex(random_bytes(32));
    } catch (Exception $e) {
    }
}
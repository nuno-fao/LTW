<?php

function generate_random_token() {
    try {
        return bin2hex(random_bytes(32));
    } catch (Exception $e) {
    }
}
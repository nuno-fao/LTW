<?php
function generate_random_token() {
    return bin2hex(random_bytes(32));
}
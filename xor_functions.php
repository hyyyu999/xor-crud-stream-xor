<?php
// xor_functions.php - fungsi encrypt/decrypt XOR (stream) + base64
function xor_encrypt($text, $key) {
    if ($key === null || $key === '') {
        throw new Exception('Key must not be empty');
    }
    $result = '';
    $klen = strlen($key);
    for ($i = 0; $i < strlen($text); $i++) {
        $result .= chr(ord($text[$i]) ^ ord($key[$i % $klen]));
    }
    return base64_encode($result);
}

function xor_decrypt($cipher, $key) {
    if ($key === null || $key === '') {
        throw new Exception('Key must not be empty');
    }
    $cipher = base64_decode($cipher);
    $result = '';
    $klen = strlen($key);
    for ($i = 0; $i < strlen($cipher); $i++) {
        $result .= chr(ord($cipher[$i]) ^ ord($key[$i % $klen]));
    }
    return $result;
}
?>

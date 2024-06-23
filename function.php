<?php

define('OPENSSL_KEY', 'A9f2q6hDEFBeptKe2NPw2F3jrFugFSK6');
define('OPENSSL_IV','gaTB4sa5h5oWkKd9');

function aes_encrypt($value){
    return bin2hex(openssl_encrypt($value, 'aes-256-cbc', OPENSSL_KEY, OPENSSL_RAW_DATA, OPENSSL_IV));

}

function aes_decrypt($value){
    if (strlen($value) % 2 != 0) {
    return false;
    }
    else{
        return openssl_decrypt(hex2bin($value), 'aes-256-cbc', OPENSSL_KEY, OPENSSL_RAW_DATA, OPENSSL_IV);
    }

}
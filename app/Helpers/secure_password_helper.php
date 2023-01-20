<?php

function hashPassword($plainText){
    return password_hash($plainText,PASSWORD_BCRYPT);
}

function verifyPassword($plainText,$hash){
    return password_verify($plainText,$hash);
}
<?php

function hashPassword($plainText){
    return password_hash($plainText,PASSWORD_BCRYPT);
}
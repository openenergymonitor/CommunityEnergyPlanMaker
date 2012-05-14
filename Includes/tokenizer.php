<?php

function create_CSRF_token() {
    $_SESSION['CSRF_token'] = md5('open energy monitor' . (string)(time() + rand(1, 99999)));
}

function reset_CSRF_token() {
    create_CSRF_token();
}

?>

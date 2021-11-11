<?php

    # Obtem a sessão iniciada
    session_start();   

    # Destroi a sessão
    $_SESSION = array();
    session_destroy();

    
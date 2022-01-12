<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

include_once( '../bd.php' );
include_once( '../funcoes.php' );
include_once( './requestEmail.php' );

requestEmail("nfe");    
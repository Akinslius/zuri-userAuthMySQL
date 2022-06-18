<?php
session_start();

function logout()
{
//remove all session variable
    session_unset();
//destroy session
    session_destroy();
//redirect to login page
    header('location:../forms/login.html');

}
logout();
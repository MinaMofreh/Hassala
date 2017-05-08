<?php

session_start();
if (isset($_SESSION['instructor'])) {

    unset($_SESSION['instructor']);
    unset($_SESSION['instructor_id']);
    unset($_SESSION['instructor_fname']);
    unset($_SESSION['solved_problems']);
    unset($_SESSION['email']);
    unset($_SESSION['gender']);
    unset($_SESSION['cf_handle']);
    unset($_SESSION['profile_photo']);
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    header('location: home.php');
} else if (isset($_SESSION['student'])) {

    unset($_SEESION['student']);
    unset($_SEESION['student_id']);
    unset($_SESSION['college_id']);
    unset($_SESSION['first_name']);
    unset($_SESSION['last_name']);
    unset($_SESSION['university']);
    unset($_SESSION['rate']);
    unset($_SESSION['email']);
    unset($_SESSION['solved_problems']);
    unset($_SESSION['profile_photo']);
    unset($_SESSION['gender']);
    unset($_SESSION['codeforces_handle']);
    unset($_SESSION['qr_code_string']);
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    header('location: home.php');
}
?>
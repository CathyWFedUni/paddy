<?php
/**
 * Log in a particular user
 */
require_once "api/data.php";


function login($username, $isOrganiser)
{
    
    $_SESSION['user_name'] = $username;
    $_SESSION['isOrganiser'] = $isOrganiser;

    sessionLogin($username);

}

/**
 * Log out the current user
 */
function logout()
{
    session_destroy();
}

/**
 * Return whether there a user is logged in
 */
function is_logged_in()
{
    return isset($_SESSION['user_name']);
}
/**
 * Return whether there a user is an organizer
 */
function is_Organiser()
{
    if ($_SESSION['currentUser']->getIsOrganiser() == '1') {
        return true;
    } else {
        return false;
    }
}

/**
 * Get the current logged-in username
 */
function logged_in_user()
{
    return $_SESSION['user_name'];
}

function logged_in_user_ID()
{
    return $_SESSION['user_id'];
}

/**
 * Redirect if not logged in
 */
function require_login()
{
    if (!is_logged_in()) {
        header('Location: index.php');
    }
}

function image()
{
    return $_SESSION['user_profile_picture_unimplemented'];
}

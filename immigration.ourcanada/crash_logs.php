<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
error_reporting(E_ERROR);
function globalExceptionHandler($exception)
{
    global $conn;

    $form_html = mysqli_real_escape_string($conn,'<p></p>');

    if (isset($_POST['formHtml'])) {
        $form_html  =  mysqli_real_escape_string($conn, $_POST['formHtml']);

        unset($_POST['formHtml']);
    }
    $postdata = mysqli_real_escape_string($conn, json_encode($_POST));
    $ip = "";
    $browser = "";
    $timezone = "";
    $client_datetime = "";
    if (isset($_SESSION['client_browser'])) {
        $browser =  mysqli_real_escape_string($conn, $_SESSION['client_browser']);
    }
    if (isset($_SESSION['client_ip'])) {
        $ip = mysqli_real_escape_string($conn, $_SESSION['client_ip']);
    }
    if (isset($_SESSION['client_timezone'])) {
        $timezone =  mysqli_real_escape_string($conn, $_SESSION['client_timezone']);
    }
    if (isset($_SESSION['client_datetime'])) {
        $client_datetime =  mysqli_real_escape_string($conn, $_SESSION['client_datetime']);
    }
    $exceptionArr = array();
    $exceptionArr['message'] =  (($exception->getMessage()));
    $exceptionArr['line_no'] = (($exception->getLine()));
    $exceptionArr['file'] = ($exception->getFile());
    $exceptionArr['exceptionTrace'] = ($exception->getTraceAsString());
    $exceptionArr['exceptionClass'] = get_class($exception);



    $exceptionArr = mysqli_real_escape_string($conn, json_encode($exceptionArr));

    $crashQuery = "INSERT INTO `form_error_logs` (`id`, `ip`, `browser`, `timezone`, `client_datetime` , `exception_info`, `post_data`, `form_html`, `created_at`, `resolved`) 
VALUES (NULL, '$ip', '$browser', '$timezone', '$client_datetime', '$exceptionArr', '$postdata', '$form_html', CURRENT_TIMESTAMP, '0');";
    mysqli_query($conn, $crashQuery);
}
set_exception_handler('globalExceptionHandler');
function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    global $conn;

    $form_html = mysqli_real_escape_string($conn,'<p></p>');

    if (isset($_POST['formHtml'])) {
        $form_html  =  mysqli_real_escape_string($conn, $_POST['formHtml']);

        unset($_POST['formHtml']);
    }
    $postdata = mysqli_real_escape_string($conn, json_encode($_POST));
    $ip = "";
    $browser = "";
    $timezone = "";
    $client_datetime = "";
    if (isset($_SESSION['client_browser'])) {
        $browser =  mysqli_real_escape_string($conn, $_SESSION['client_browser']);
    }
    if (isset($_SESSION['client_ip'])) {
        $ip = mysqli_real_escape_string($conn, $_SESSION['client_ip']);
    }
    if (isset($_SESSION['client_timezone'])) {
        $timezone =  mysqli_real_escape_string($conn, $_SESSION['client_timezone']);
    }
    if (isset($_SESSION['client_datetime'])) {
        $client_datetime =  mysqli_real_escape_string($conn, $_SESSION['client_datetime']);
    }
    $exceptionArr = array();
    $exceptionArr['message'] =  $errstr;
    $exceptionArr['line_no'] = $errline;
    $exceptionArr['error_no'] = $errno;
    $exceptionArr['file'] = ($errfile);
    $exceptionArr = mysqli_real_escape_string($conn, json_encode($exceptionArr));

    $crashQuery = "INSERT INTO `form_error_logs` (`id`, `ip`, `browser`, `timezone`, `client_datetime` , `exception_info`, `post_data`, `form_html`, `created_at`, `resolved`) 
VALUES (NULL, '$ip', '$browser', '$timezone', '$client_datetime','$exceptionArr', '$postdata', '$form_html', CURRENT_TIMESTAMP, '0');";
    mysqli_query($conn, $crashQuery);
}

// Set user-defined error handler function
set_error_handler("myErrorHandler",E_ERROR);

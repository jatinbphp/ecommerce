<?php

function addPaymentLog($message)
{

    // Define the directory where log files will be stored
    $logDirectory = 'logs/';

    // Get the current date
    $currentDate = date('Y-m-d');
   
    // Create the log file name with the current date
    $logFileName = $logDirectory . $currentDate . '_payment_log' . '.txt';

    // Log message
    $logMessage = $message;

    // Check if the log file for today already exists, if not, create it
    if (!file_exists(dirname($logFileName))) {
        // Create the directory if it doesn't exist
        mkdir(dirname($logFileName), 0755, true);
    }
    if (!file_exists($logFileName)) {
        // Create a new log file
        $fileHandle = fopen($logFileName, 'w');
        fclose($fileHandle);
    }

    // Append the log message to the log file
    file_put_contents($logFileName, $logMessage , FILE_APPEND | LOCK_EX);
    file_put_contents($logFileName, PHP_EOL, FILE_APPEND | LOCK_EX);
}
<?php
function handleError($errorTitle, $errorMessage)
{
    include __DIR__ . '/../views/error.php';
    exit;
}

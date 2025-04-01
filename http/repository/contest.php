<?php

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/../models/contest.php';

// Returns all images for the current contest, that sill require admin confirmation
function getUnconfirmedContestImages() {
    $conn = createDbConnection();
    $stmt = $conn->prepare('call spGetUnconfirmedContestImages()');

    $stmt->execute();
    $result = $stmt->get_result();

    $ret = array();

    while ($row = $result->fetch_assoc()) {
        $ret[] = new ContestImage($row['nKey'], $row['szImagePath'], $row['szAccountName'], $row['dtCreated']);
    }

    return $ret;
}

function updateContestImageConfirmation($imageKey, $confirmed) {    
    $conn = createDbConnection();

    $stmt = $conn->prepare('call spUpdateContestImageConfirmation(?, ?)');
    $stmt->bind_param('ii', $imageKey, $confirmed);
    $stmt->execute();
}

// Returns the next image that can be rated by the user
function getUnratedContestImages($userKey) {
    $conn = createDbConnection();    
    $stmt = $conn->prepare('call spGetContestImagesToRate(?)');
    $stmt->bind_param('i', $userKey);
    $stmt->execute();

    $result = $stmt->get_result();

    $ret = array();
    while ($row = $result->fetch_assoc()) {
        $ret[] = new ContestImage($row['nKey'], $row['szImagePath'], $row['szAccountName'], $row['dtCreated'], $row['nRating'] ?? 0);
    }

    return $ret;
}

function submitContestImage($userKey, $image) {
    $fileTmp = $image['tmp_name'];
    $fileOriginalName = $image['name'];
    $fileExtension = pathinfo($fileOriginalName, PATHINFO_EXTENSION);

    $uploadDir = __DIR__ . '/../images/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $uniqueId = uniqid();
    $timestamp = time();
    $newFilename = "image_{$uniqueId}_{$timestamp}.{$fileExtension}";
    $uploadFile = $uploadDir . $newFilename;

    move_uploaded_file($fileTmp, $uploadFile);
    
    $httpPath = 'images/' . $newFilename;

    $conn = createDbConnection();
    $stmt = $conn->prepare('call spCreateNewContestImage(?, ?)');
    $stmt->bind_param('is', $userKey, $httpPath);
    $stmt->execute();    
}

function updateContestImageRating($userKey, $imageKey, $rating) {
    $conn = createDbConnection();
    $stmt = $conn->prepare('call spUpdateContestImageRating(?, ?, ?)');
    $stmt->bind_param('iis', $userKey, $imageKey, $rating);
    $stmt->execute();
}

function getContestWinners() {
    $conn = createDbConnection();
    $stmt = $conn->prepare('call spGetContestWinners()');
    $stmt->execute();

    $result = $stmt->get_result();
    $ret = array();

    while ($row = $result->fetch_assoc()) {
        $ret[] = new ContestImage($row['nKey'], $row['szImagePath'], $row['szAccountName'], $row['dtCreated']);
    }
    
    return $ret;
}

?>

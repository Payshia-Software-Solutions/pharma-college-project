<?php
require_once './controllers/community/CommunityPostReplyRatingsController.php';

// Instantiate the controller
$pdo = $GLOBALS['pdo'];
$communityReplyRatingsController = new CommunityPostReplyRatingsController($pdo);

// Define routes
return [
    'GET /community-post-reply-ratings/' => [$communityReplyRatingsController, 'getAllRecords'],
    'GET /community-post-reply-ratings/{reply_id}/' => [$communityReplyRatingsController, 'getRecordById'],
    'POST /community-post-reply-ratings/' => [$communityReplyRatingsController, 'createRecord'],
    'PUT /community-post-reply-ratings/{reply_id}/' => [$communityReplyRatingsController, 'updateRecord'],
    'DELETE /community-post-reply-ratings/{reply_id}/' => [$communityReplyRatingsController, 'deleteRecord']
];
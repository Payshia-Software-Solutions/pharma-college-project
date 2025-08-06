<?php
// --- routes/SupportRoutes.php ---
require_once './controllers/AnnouncementController.php';
require_once './controllers/TicketController.php';
require_once './controllers/TicketMessageController.php';
require_once './controllers/ChatController.php';
require_once './controllers/ChatMessageController.php';
require_once './controllers/BnfChapterController.php';
require_once './controllers/BnfPageController.php';
require_once './controllers/BnfWordIndexController.php';
require_once './controllers/BnfListItemController.php';

$pdo = $GLOBALS['pdo'];

$announcementController = new AnnouncementController($pdo);
$ticketController = new TicketController($pdo);
$ticketMessageController = new TicketMessageController($pdo);
$chatController = new ChatController($pdo);
$chatMessageController = new ChatMessageController($pdo);
$bnfChapterController = new BnfChapterController($pdo);
$bnfPageController = new BnfPageController($pdo);
$bnfWordIndexController = new BnfWordIndexController($pdo);
$bnfListItemController = new BnfListItemController($pdo);

return [
    // --- Announcements ---
    'GET /api/announcements/$' => fn() => $announcementController->getAll(),
    'GET /api/announcements/(\w+)/$' => fn($id) => $announcementController->getById($id),
    'POST /api/announcements/$' => fn() => $announcementController->create(),
    'DELETE /api/announcements/(\w+)/$' => fn($id) => $announcementController->delete($id),

    // --- Tickets ---
    'GET /api/tickets/$' => fn() => $ticketController->getAll(),
    'GET /api/tickets/(\w+)/$' => fn($id) => $ticketController->getById($id),
    'GET /api/tickets/username/(\w+)/$' => fn($user_name) => $ticketController->getByUsername($user_name),
    'POST /api/tickets/$' => fn() => $ticketController->create(),
    'POST /api/tickets/(\w+)/assign/$' => fn($id) => $ticketController->assignTicket($id),
    'POST /api/tickets/(\w+)/unlock/$' => fn($id) => $ticketController->unlockTicket($id),
    'POST /api/tickets/(\w+)/status/$' => fn($id) => $ticketController->updateStatus($id),
    'DELETE /api/tickets/(\w+)/$' => fn($id) => $ticketController->delete($id),

    // --- Ticket Messages ---
    'GET /api/ticket-messages/$' => fn() => $ticketMessageController->getAll(),
    'GET /api/ticket-messages/by-ticket/(\w+)/$' => fn($ticketId) => $ticketMessageController->getByTicketId($ticketId),
    'POST /api/ticket-messages/$' => fn() => $ticketMessageController->create(),
    'PUT /api/ticket-messages/update-read-status/(\w+)/$' => fn($id) => $ticketMessageController->updateReadStatus($id),
    'POST /api/ticket-messages/get-unread-messages/(\w+)/$' => fn($id) => $ticketMessageController->getUnreadMessages($id),
    'DELETE /api/ticket-messages/(\w+)/$' => fn($id) => $ticketMessageController->delete($id),

    // --- Chats ---
    'GET /api/chats/$' => fn() => $chatController->getAll(),
    'GET /api/chats/(\w+)/$' => fn($id) => $chatController->getById($id),
    'GET /api/chats/username/(\w+)/$' => fn($user_name) => $chatController->getByUsername($user_name),
    'POST /api/chats/$' => fn() => $chatController->create(),
    'DELETE /api/chats/(\w+)/$' => fn($id) => $chatController->delete($id),

    // --- Chat Messages ---
    'GET /api/chat-messages/by-chat/(\w+)/$' => fn($chatId) => $chatMessageController->getByChatId($chatId),
    'POST /api/chat-messages/$' => fn() => $chatMessageController->create(),
    'DELETE /api/chat-messages/(\w+)/$' => fn($id) => $chatMessageController->delete($id),

    // --- BNF Chapters ---
    'GET /api/bnf/chapters/$' => fn() => $bnfChapterController->getAll(),
    'GET /api/bnf/chapters/(\d+)/$' => fn($id) => $bnfChapterController->getById($id),
    'POST /api/bnf/chapters/$' => fn() => $bnfChapterController->create(),
    'PUT /api/bnf/chapters/(\d+)/$' => fn($id) => $bnfChapterController->update($id),
    'DELETE /api/bnf/chapters/(\d+)/$' => fn($id) => $bnfChapterController->delete($id),

    // --- BNF Pages ---
    'GET /api/bnf/pages/$' => fn() => $bnfPageController->getAll(),
    'GET /api/bnf/pages/(\d+)/$' => fn($id) => $bnfPageController->getById($id),
    'GET /api/bnf/pages/chapter/(\d+)/$' => fn($chapter_id) => $bnfPageController->getByChapterId($chapter_id),
    'POST /api/bnf/pages/$' => fn() => $bnfPageController->create(),
    'PUT /api/bnf/pages/(\d+)/$' => fn($id) => $bnfPageController->update($id),
    'DELETE /api/bnf/pages/(\d+)/$' => fn($id) => $bnfPageController->delete($id),

    // --- BNF Word Index ---
    'GET /api/bnf/word-index/$' => fn() => $bnfWordIndexController->getAll(),
    'GET /api/bnf/word-index/(\w+)/$' => fn($word) => $bnfWordIndexController->getByWord($word),
    'POST /api/bnf/word-index/$' => fn() => $bnfWordIndexController->create(),
    'DELETE /api/bnf/word-index/(\d+)/$' => fn($id) => $bnfWordIndexController->delete($id),

    // --- Optional: BNF Page List Items ---
    'GET /api/bnf/list-items/page/(\d+)/$' => fn($page_id) => $bnfListItemController->getByPageId($page_id),
    'POST /api/bnf/list-items/$' => fn() => $bnfListItemController->create(),
    'PUT /api/bnf/list-items/(\d+)/$' => fn($id) => $bnfListItemController->update($id),
    'DELETE /api/bnf/list-items/(\d+)/$' => fn($id) => $bnfListItemController->delete($id),
];

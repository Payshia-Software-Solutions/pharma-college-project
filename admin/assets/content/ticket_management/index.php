<?php
require_once('../../../include/config.php');
include '../../../include/function-update.php';
include '../../../include/lms-functions.php';

include './methods/functions.php'; //Ticket Methods

$LoggedUser = $_POST['LoggedUser'];
$studentBatch = $_POST['studentBatch'];

$ticketList = GetTickets();
$CourseBatches = getLmsBatches();
$Locations = GetLocations($link);
$accountDetails = GetAccounts($link);
$ticketAssignments = GetTicketAssignmentsByUsername($LoggedUser);

$openTickets = ticketsByStatus(1);

$ticketCount = count($ticketList);
$ActiveStatus = 0;
?>

<div class="row mt-5">
    <div class="col-md-3">
        <div class="card item-card">
            <div class="overlay-box">
                <i class="fa-solid fa-location-dot icon-card"></i>
            </div>
            <div class="card-body">
                <p>No of Tickets</p>
                <h1><?= $ticketCount ?></h1>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card item-card">
            <div class="overlay-box">
                <i class="fa-solid fa-check icon-card"></i>
            </div>
            <div class="card-body">
                <p>Open</p>
                <h1><?= count($openTickets) ?></h1>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card item-card">
            <div class="overlay-box">
                <i class="fa-solid fa-xmark icon-card"></i>
            </div>
            <div class="card-body">
                <p>Closed</p>
                <h1><?= $ticketCount ?></h1>
            </div>
        </div>
    </div>
</div>



<div class="row mt-5">
    <div class="col-md-12">
        <div class="table-title font-weight-bold mb-4 mt-0">Tickets</div>

        <div class="row g-2">
            <div class="col-6">
                <button class="btn btn-dark w-100 rounded-3" onclick="GetMailBox('Open')">
                    <h1 class="mb-1 badge bg-white text-dark"><?= count($openTickets) ?></h1>
                    <h4 class="mb-0">Open</h4>
                </button>
            </div>
            <div class="col-6">
                <button class="btn btn-dark w-100 rounded-3" onclick="GetMailBox('MyTickets')">
                    <h1 class="mb-1 badge bg-white text-dark"><?= count($ticketAssignments) ?></h1>
                    <h4 class="mb-0">My Chats</h4>
                </button>
            </div>
        </div>
        <div class="row g-2 mt-2">
            <div class="col-12">
                <!-- Search Input Field -->
                <div class="input-group mb-3">
                    <input type="text" id="ticketSearch" class="form-control" placeholder="Search tickets" onkeyup="filterTickets()">
                </div>
            </div>

        </div>
        <div class="row mt-2">
            <div class="col-12 mb-3">
                <div id="ticketBox">
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    function filterTickets() {
        const searchInput = document.getElementById('ticketSearch').value.toLowerCase();
        const tickets = document.querySelectorAll('.ticket-card');

        tickets.forEach(ticket => {
            const subject = ticket.getAttribute('data-subject');
            const department = ticket.getAttribute('data-department');
            const indexNumber = ticket.getAttribute('data-index');

            if (subject.includes(searchInput) || department.includes(searchInput) || indexNumber.includes(searchInput)) {
                ticket.style.display = 'flex';
                ticket.classList.add('d-flex');
            } else {
                ticket.style.display = 'none';
                ticket.classList.remove('d-flex');
            }
        });
    }
</script>
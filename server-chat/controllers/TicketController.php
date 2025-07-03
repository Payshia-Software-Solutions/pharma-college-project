<?php

require_once 'models/Ticket.php';

class TicketController
{
    private $model;
    public function __construct($pdo)
    {
        $this->model = new Ticket($pdo);
    }
    public function getAll()
    {
        echo json_encode($this->model->getAll());
    }
    public function getById($id)
    {
        $record = $this->model->getById($id);
        echo $record ? json_encode($record) : json_encode(["error" => "Not found"]);
    }

    public function getByUsername($user_name)
    {
        echo json_encode($this->model->getByUsername($user_name));
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $insertedId = $this->model->create($data);

        echo json_encode([
            "message" => "Ticket message created",
            "id" => $insertedId
        ]);
    }

    public function updateStatus($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['newStatus'])) {
            echo json_encode(["error" => "New status is required"]);
            return;
        }
        $newStatus = $data['newStatus'];
        $this->model->updateStatus($id, $newStatus);
        echo json_encode(["message" => "Ticket status updated"]);
    }

    public function assignTicket($id)
    {
        $data = json_decode(file_get_contents("php://input"), true);

        // Validate required fields
        if (!isset($data['assignedTo']) || !isset($data['assigneeAvatar'])) {
            echo json_encode(["error" => "Assigned to and assignee avatar are required"]);
            return;
        }

        // Default optional fields
        $isLocked = isset($data['isLocked']) ? (int)$data['isLocked'] : 0;
        $lockedBy = $data['lockedByStaffId'] ?? null;

        // Assign ticket
        $this->model->assignTicket($id, $data['assignedTo'], $data['assigneeAvatar'], $isLocked, $lockedBy);

        // Return full ticket details
        $ticket = $this->model->getById($id);
        if ($ticket) {
            echo json_encode($ticket);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Ticket not found"]);
        }
    }

    public function unlockTicket($id)
    {
        $this->model->unlockTicket($id);

        $ticket = $this->model->getById($id);
        if ($ticket) {
            echo json_encode($ticket);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Ticket not found"]);
        }
    }


    public function delete($id)
    {
        $this->model->delete($id);
        echo json_encode(["message" => "Ticket deleted"]);
    }

    // public function assignTicket($id)
    // {
    //     // Decode the incoming JSON request body
    //     $data = json_decode(file_get_contents("php://input"), true);

    //     // Merge the ticket ID into the data array (if not already included)
    //     $data['id'] = $id;

    //     // Assign the ticket using the model
    //     $this->model->assignToStaff($data);

    //     // Return a success response
    //     echo json_encode(["message" => "Ticket Assigned"]);
    // }
}

<?php
// controllers/AppointmentController.php

require_once './models/Appointment.php';

class AppointmentController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new Appointment($pdo);
    }

    public function getAppointments()
    {
        $appointments = $this->model->getAllAppointments();
        echo json_encode($appointments);
    }

    public function getAppointment($id)
    {
        $appointment = $this->model->getAppointmentById($id);
        echo json_encode($appointment);
    }

    public function createAppointment()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->createAppointment($data);
        echo json_encode(['status' => 'Appointment created']);
    }

    public function updateAppointment($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $this->model->updateAppointment($id, $data);
        echo json_encode(['status' => 'Appointment updated']);
    }

    public function deleteAppointment($id)
    {
        $this->model->deleteAppointment($id);
        echo json_encode(['status' => 'Appointment deleted']);
    }
}

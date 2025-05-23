"use client";
import React, { useState } from "react";

import TicketDetail from "@/components/Chat/TicketDetail";
import TicketScreen from "@/components/Chat/TicketScreen";
import ChatScreen from "@/components/Chat/ChatScreen";
import LoginScreen from "@/components/Chat/LoginScreen";
import CreateTicket from "@/components/Chat/CreateTicket";

const StudentSupportApp = () => {
  const [currentScreen, setCurrentScreen] = useState("login");
  const [showCreateTicket, setShowCreateTicket] = useState(false);
  const [showTicketDetails, setShowTicketDetails] = useState(false);
  const [selectedTicket, setSelectedTicket] = useState(null);
  const [studentNumber, setStudentNumber] = useState("");
  const [message, setMessage] = useState("");
  const [category, setCategory] = useState("");
  const [ticketMessage, setTicketMessage] = useState("");

  return (
    <div className="w-100 bg-gray-100 min-h-screen">
      {currentScreen === "login" && (
        <LoginScreen
          setStudentNumber={setStudentNumber}
          setCurrentScreen={setCurrentScreen}
          studentNumber={studentNumber}
        />
      )}
      {currentScreen === "chat" && (
        <ChatScreen
          setShowCreateTicket={setShowCreateTicket}
          setCurrentScreen={setCurrentScreen}
          setMessage={setMessage}
          message={message}
        />
      )}
      {currentScreen === "tickets" && (
        <TicketScreen
          setShowCreateTicket={setShowCreateTicket}
          setCurrentScreen={setCurrentScreen}
          setSelectedTicket={setSelectedTicket}
          setShowTicketDetails={setShowTicketDetails}
        />
      )}

      {showCreateTicket && (
        <CreateTicket
          setShowCreateTicket={setShowCreateTicket}
          setCategory={setCategory}
        />
      )}
      {showTicketDetails && (
        <TicketDetail setShowTicketDetails={setShowTicketDetails} />
      )}
    </div>
  );
};

export default StudentSupportApp;

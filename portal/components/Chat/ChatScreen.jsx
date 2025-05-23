import React from "react";
import { MessageCircle, Ticket, Bell, Send } from "lucide-react";

function ChatScreen({
  setShowCreateTicket,
  setCurrentScreen,
  setMessage,
  message,
}) {
  const chatMessages = [
    {
      id: 1,
      sender: "staff",
      message: "Hello! How can I help you today?",
      time: "10:30 AM",
      avatar: "👨‍💼",
    },
    {
      id: 2,
      sender: "user",
      message: "I need help with my registration process.",
      time: "10:32 AM",
    },
  ];
  return (
    <div className="min-h-screen bg-white flex flex-col z-50">
      <div className="bg-teal-500 px-4 py-3 flex items-center justify-between text-white">
        <div className="flex items-center space-x-3">
          <MessageCircle className="w-6 h-6" />
          <span className="font-medium">Contact</span>
        </div>
        <div className="flex items-center space-x-3">
          <Bell className="w-5 h-5" />
          <div className="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center text-sm">
            2
          </div>
        </div>
      </div>

      <div className="px-4 py-3">
        <button
          onClick={() => setShowCreateTicket(true)}
          className="w-full bg-teal-500 text-white py-3 rounded-lg font-medium flex items-center justify-center space-x-2"
        >
          <Ticket className="w-5 h-5" />
          <span>Create New Ticket</span>
        </button>
      </div>

      <div className="flex border-b border-gray-200">
        <button className="flex-1 py-3 px-4 bg-teal-100 text-teal-600 font-medium border-b-2 border-teal-500">
          Chat with Staff
        </button>
        <button
          onClick={() => setCurrentScreen("tickets")}
          className="flex-1 py-3 px-4 text-gray-600"
        >
          My Tickets
        </button>
      </div>

      <div className="flex-1 px-4 py-4 space-y-4 bg-white z-50">
        {chatMessages.map((msg) => (
          <div
            key={msg.id}
            className={`flex ${
              msg.sender === "user" ? "justify-end" : "justify-start"
            }`}
          >
            <div
              className={`max-w-xs lg:max-w-md px-4 py-2 rounded-lg ${
                msg.sender === "user"
                  ? "bg-teal-500 text-white"
                  : "bg-gray-100 text-gray-800"
              }`}
            >
              <p className="text-sm">{msg.message}</p>
              <p
                className={`text-xs mt-1 ${
                  msg.sender === "user" ? "text-teal-100" : "text-gray-500"
                }`}
              >
                {msg.time}
              </p>
            </div>
          </div>
        ))}
      </div>

      <div className="bg-white p-4 border-t border-gray-200 z-50">
        <div className="flex items-center space-x-2">
          <input
            type="text"
            value={message}
            onChange={(e) => setMessage(e.target.value)}
            placeholder="Type your message..."
            className="flex-1 px-4 py-2 border border-gray-300 rounded-full focus:ring-2 focus:ring-teal-500 focus:border-transparent"
          />
          <button className="bg-teal-500 text-white p-2 rounded-full">
            <Send className="w-5 h-5" />
          </button>
        </div>
      </div>
    </div>
  );
}

export default ChatScreen;

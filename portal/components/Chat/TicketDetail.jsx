import React from "react";

import { X, Send, Paperclip } from "lucide-react";

function TicketDetail({ setShowTicketDetails }) {
  const ticketDetails = {
    id: "TK-2025",
    title: "Unable to access premium features",
    status: "In Progress",
    date: "May 8, 2025",
    category: "Technical",
    messages: [
      {
        sender: "user",
        message:
          "Hi, I'm having trouble accessing the premium features I paid for. The dashboard shows my subscription is active but I can't access any premium content.",
        time: "10:30 AM",
        attachment: "screenshot.png",
      },
      {
        sender: "support",
        name: "Hemal Support",
        message:
          "I understand your concern. Let me check your account status and permissions. Could you please confirm if you've tried logging out and back in?",
        time: "11:15 AM",
        avatar: "👨‍💼",
      },
    ],
  };
  return (
    <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center lg:p-4 z-50">
      <div className="bg-white rounded-lg max-w-md w-full h-screen overflow-y-auto">
        <div className="flex items-center justify-between p-4 border-b border-gray-200">
          <h2 className="text-lg font-semibold">Ticket Details</h2>
          <button
            onClick={() => setShowTicketDetails(false)}
            className="text-gray-400 hover:text-gray-600"
          >
            <X className="w-5 h-5" />
          </button>
        </div>

        <div className="p-4">
          <div className="mb-4">
            <h3 className="font-semibold text-gray-800 mb-2">
              {ticketDetails.title}
            </h3>
            <div className="flex items-center space-x-4 text-sm text-gray-600">
              <span>Created {ticketDetails.date}</span>
              <span>#{ticketDetails.id}</span>
            </div>
            <div className="flex items-center space-x-2 mt-2">
              <span className="px-2 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-medium">
                {ticketDetails.category}
              </span>
              <span className="px-2 py-1 bg-orange-100 text-orange-600 rounded-full text-xs font-medium">
                {ticketDetails.status}
              </span>
            </div>
          </div>

          <div className="space-y-4 mb-4">
            {ticketDetails.messages.map((msg, index) => (
              <div
                key={index}
                className={`flex ${
                  msg.sender === "user" ? "justify-end" : "justify-start"
                }`}
              >
                <div
                  className={`max-w-xs px-3 py-2 rounded-lg ${
                    msg.sender === "user"
                      ? "bg-teal-500 text-white"
                      : "bg-gray-100 text-gray-800"
                  }`}
                >
                  {msg.sender === "support" && (
                    <div className="flex items-center space-x-2 mb-1">
                      <div className="w-6 h-6 bg-teal-500 rounded-full flex items-center justify-center text-white text-xs">
                        H
                      </div>
                      <span className="text-xs font-medium">{msg.name}</span>
                    </div>
                  )}
                  <p className="text-sm">{msg.message}</p>
                  {msg.attachment && (
                    <div className="mt-2 flex items-center space-x-2">
                      <Paperclip className="w-3 h-3" />
                      <span className="text-xs underline">
                        {msg.attachment}
                      </span>
                    </div>
                  )}
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

          <div className="flex items-center space-x-2">
            <input
              type="text"
              placeholder="Write a reply..."
              className="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
            />
            <button className="p-2 text-gray-400">
              <Paperclip className="w-5 h-5" />
            </button>
            <button className="bg-teal-500 text-white p-2 rounded-lg">
              <Send className="w-4 h-4" />
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}

export default TicketDetail;

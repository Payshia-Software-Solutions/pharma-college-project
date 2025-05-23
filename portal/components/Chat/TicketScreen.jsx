import React from "react";
import {
  MessageCircle,
  Ticket,
  Bell,
  Search,
  Filter,
  MoreVertical,
  ChevronDown,
} from "lucide-react";
function TicketScreen({
  setShowCreateTicket,
  setCurrentScreen,
  setSelectedTicket,
  setShowTicketDetails,
}) {
  const tickets = [
    {
      id: 1,
      title: "Login Issue with Mobile App",
      category: "Technical Support",
      status: "In Progress",
      date: "May 7, 2025",
      color: "orange",
    },
    {
      id: 2,
      title: "Billing Question",
      category: "Billing",
      status: "Resolved",
      date: "May 5, 2025",
      color: "green",
    },
  ];
  return (
    <div className="min-h-screen bg-white flex flex-col">
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
        <button
          onClick={() => setCurrentScreen("chat")}
          className="flex-1 py-3 px-4 text-gray-600"
        >
          Chat with Staff
        </button>
        <button className="flex-1 py-3 px-4 bg-teal-100 text-teal-600 font-medium border-b-2 border-teal-500">
          My Tickets
        </button>
      </div>

      <div className="px-4 py-3 flex items-center space-x-3">
        <div className="flex items-center space-x-2">
          <span className="text-gray-700 font-medium">All Tickets</span>
          <ChevronDown className="w-4 h-4 text-gray-500" />
        </div>
        <div className="flex-1 relative">
          <Search className="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
          <input
            type="text"
            placeholder="Search tickets..."
            className="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm"
          />
        </div>
        <button className="p-2">
          <Filter className="w-5 h-5 text-gray-400" />
        </button>
        <button className="p-2">
          <MoreVertical className="w-5 h-5 text-gray-400" />
        </button>
      </div>

      <div className="flex-1 px-4 space-y-3">
        {tickets.map((ticket) => (
          <div
            key={ticket.id}
            onClick={() => {
              setSelectedTicket(ticket);
              setShowTicketDetails(true);
            }}
            className="bg-white border border-gray-200 rounded-lg p-4 cursor-pointer hover:bg-gray-50"
          >
            <div className="flex items-start justify-between mb-2">
              <div className="flex items-center space-x-2">
                <div className="w-2 h-2 bg-orange-500 rounded-full"></div>
                <h3 className="font-medium text-gray-800">{ticket.title}</h3>
              </div>
              <span
                className={`px-2 py-1 rounded-full text-xs font-medium ${
                  ticket.status === "In Progress"
                    ? "bg-orange-100 text-orange-600"
                    : "bg-green-100 text-green-600"
                }`}
              >
                {ticket.status}
              </span>
            </div>
            <div className="flex items-center space-x-4 text-sm text-gray-500">
              <span>{ticket.category}</span>
              <span>{ticket.date}</span>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
}

export default TicketScreen;

import React from "react";

import { Ticket, X, Upload, ChevronDown } from "lucide-react";

function CreateTicket({
  setShowCreateTicket,
  setCategory,
  category,
  setTicketMessage,
  ticketMessage,
  setCurrentScreen,
}) {
  return (
    <div className="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center lg:p-4 z-50">
      <div className="bg-white rounded-lg max-w-md w-full h-screen overflow-y-auto">
        <div className="flex items-center justify-between p-4 border-b border-gray-200">
          <h2 className="text-lg font-semibold">Create Support Ticket</h2>
          <button
            onClick={() => setShowCreateTicket(false)}
            className="text-gray-400 hover:text-gray-600"
          >
            <X className="w-5 h-5" />
          </button>
        </div>

        <div className="p-4 space-y-4">
          <p className="text-sm text-gray-600">
            Please fill out the form below to submit your support request.
          </p>

          <div>
            <label className="block text-sm font-medium text-gray-700 mb-2">
              What Category
            </label>
            <div className="relative">
              <select
                value={category}
                onChange={(e) => setCategory(e.target.value)}
                className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent appearance-none"
              >
                <option value="">Select a category</option>
                <option value="technical">Technical Support</option>
                <option value="billing">Billing</option>
                <option value="general">General Inquiry</option>
              </select>
              <ChevronDown className="w-4 h-4 absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
            </div>
          </div>

          <div>
            <label className="block text-sm font-medium text-gray-700 mb-2">
              Your Message
            </label>
            <textarea
              value={ticketMessage}
              onChange={(e) => setTicketMessage(e.target.value)}
              placeholder="Please provide detailed information about your issue..."
              rows={4}
              className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent resize-none"
            />
          </div>

          <div>
            <label className="block text-sm font-medium text-gray-700 mb-2">
              Attachments
            </label>
            <div className="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
              <Upload className="w-8 h-8 text-gray-400 mx-auto mb-2" />
              <p className="text-sm text-gray-600">
                Upload a file or drag and drop
              </p>
              <p className="text-xs text-gray-500">PNG, JPG, PDF up to 10MB</p>
            </div>
          </div>

          <div className="flex space-x-3">
            <button
              onClick={() => setShowCreateTicket(false)}
              className="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50"
            >
              Cancel
            </button>
            <button
              onClick={() => {
                setShowCreateTicket(false);
                setCurrentScreen("tickets");
              }}
              className="flex-1 px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 flex items-center justify-center space-x-2"
            >
              <Ticket className="w-4 h-4" />
              <span>Send Ticket</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}

export default CreateTicket;

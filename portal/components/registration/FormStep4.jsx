import React from "react";

export default function FormStep4({ register }) {
  return (
    <>
      <div className="floating-input">
        <input {...register("phone")} placeholder=" " />
        <label>Phone Number</label>
      </div>

      <div className="floating-input">
        <input {...register("email")} placeholder=" " />
        <label>Email</label>
      </div>

      <div className="floating-input">
        <input {...register("whatsapp")} placeholder=" " />
        <label>WhatsApp</label>
      </div>
    </>
  );
}

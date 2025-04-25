import React from "react";

export default function FormStep3({ register }) {
  return (
    <>
      <div className="floating-input">
        <select {...register("gender")} className="w-full">
          <option value="">Select Gender</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Other">Other</option>
        </select>
        <label>Gender</label>
      </div>

      <div className="floating-input">
        <input {...register("nic")} placeholder=" " />
        <label>NIC Number</label>
      </div>

      <div className="floating-input">
        <input {...register("dob")} type="date" />
        <label>Date of Birth</label>
      </div>
    </>
  );
}

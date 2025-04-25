import React from "react";

const Step1PersonalInfo = ({ register }) => (
  <>
    <div className="floating-input">
      <select {...register("civilStatus")} className="w-full">
        <option value="">Select Civil Status</option>
        <option value="Mr">Mr</option>
        <option value="Mrs">Mrs</option>
        <option value="Miss">Miss</option>
        <option value="Dr">Dr</option>
      </select>
      <label>Civil Status</label>
    </div>

    <div className="floating-input">
      <input {...register("firstName")} placeholder=" " />
      <label>First Name</label>
    </div>
    <div className="floating-input">
      <input {...register("lastName")} placeholder=" " />
      <label>Last Name</label>
    </div>
    <div className="floating-input">
      <input {...register("nameWithInitials")} placeholder=" " />
      <label>Name with Initials</label>
    </div>
    <div className="floating-input">
      <input {...register("certificateName")} placeholder=" " />
      <label>Name on Certificate</label>
    </div>
  </>
);

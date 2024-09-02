 <style>
   .animate-text {
     animation: scaleUp 3s ease-in-out infinite, ease-in-out 3s infinite, fadeIn 3s ease-in-out 3s infinite;
   }

   @keyframes scaleUp {
     0% {
       transform: scale(0.5);
       opacity: 0;
     }

     50% {
       transform: scale(0.9);
       opacity: 1;
     }

     100% {
       transform: scale(0.9);
       opacity: 1;
     }
   }

   @keyframes fadeOut {
     0% {
       opacity: 0.9;
     }

     50% {
       opacity: 0;
     }

     100% {
       opacity: 0;
     }
   }

   @keyframes fadeIn {
     0% {
       opacity: 0;
     }

     50% {
       opacity: 0.9;
     }

     100% {
       opacity: 0.9;
     }
   }

   .custom-img {
     max-width: 40%;
     /* Adjust size to 40% of its container */
     height: auto;
     /* Maintain aspect ratio */
   }
 </style>

 <div class="container">
   <div class="row mt-2 mb-5">
     <div class="col-12 mt-3">
       <div class="card mt-5 border-0 bg-success text-light">
         <div class="card-body text-center">
           <!-- Make sure to use responsive classes -->
           <div class="d-flex justify-content-center mb-3">
             <img src="./assets/images/success.gif" class="custom-img shadow w-25 rounded-4" alt="Success Icon">

           </div>
           <!-- Responsive H1 text with proper mobile sizing -->
           <h1 id="success-message" class="card-title bg-light text-success bg-white p-3 rounded-5 mb-0 animate-text fs-3 fs-sm-4 fs-md-2">Appointments Succeed</h1>
         </div>
       </div>
     </div>
   </div>
   <div class="row mb-3">
     <div class="col-12 text-end">
       <button class="btn btn-warning" onclick="GetAppointment()">Reload</button>
     </div>
   </div>
 </div>
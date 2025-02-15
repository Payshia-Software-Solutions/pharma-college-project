import { create } from "zustand";

export const useFormStore = create((set) => ({
  step: 1,
  formData: {
    firstName: "",
    lastName: "",
    civilStatus: "",
    nameWithInitials: "",
    certificateName: "",
    gender: "",
    nic: "",
    dob: "",
    phone: "",
    email: "",
    whatsapp: "",
    course: "",
  },
  nextStep: () => set((state) => ({ step: state.step + 1 })),
  prevStep: () => set((state) => ({ step: state.step - 1 })),
  updateForm: (data) =>
    set((state) => ({ formData: { ...state.formData, ...data } })),
  resetForm: () =>
    set({
      step: 1,
      formData: {
        firstName: "",
        lastName: "",
        civilStatus: "",
        nameWithInitials: "",
        certificateName: "",
        gender: "",
        nic: "",
        dob: "",
        phone: "",
        email: "",
        whatsapp: "",
        course: "",
        address: "",
        city: "",
      },
    }),
}));

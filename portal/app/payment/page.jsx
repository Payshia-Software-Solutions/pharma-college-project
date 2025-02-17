import PaymentSelection from "@/components/PaymentSelection";

export const metadata = {
  title: "Payment Portal",
  description: "Payment Portal",
};

export default function Home() {
  return (
    <div className="">
      <PaymentSelection />
    </div>
  );
}

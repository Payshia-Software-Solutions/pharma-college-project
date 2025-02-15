export async function POST(req) {
  const body = await req.json();
  return new Response(JSON.stringify({ refNumber: `REG-${Date.now()}` }), {
    status: 200,
  });
}

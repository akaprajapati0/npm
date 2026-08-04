export function otpTemplate(otp: string): string {
  return emailTemplate({
    type: "otp",
    title: "Verification Code",
    subtitle: "Valid for <strong>2 minutes</strong>. Do not share this code.",
    highlightLabel: "One-Time OTP",
    highlightValue: otp,
  });
}

export function passwordTemplate(password: string, username?: string): string {
  return emailTemplate({
    type: "password",
    title: "Your Account Credentials",
    subtitle: "Use the credentials below to log in to your account.",
    username: username,
    highlightLabel: "Password",
    highlightValue: password,
    message: "You can change password if require",
  });
}

export function kycTemplate(msg: string): string {
  return emailTemplate({
    type: "alert",
    title: "Your KYC",
    subtitle: "KYC Status",
    // username: username,
    highlightLabel: "KYC",
    highlightValue: msg,
    message: `Your KYC document is successfully ${msg}`,
  });
}

// base builder — not exported, used internally above
function emailTemplate({ type, title, subtitle, highlightValue, highlightLabel, message, footerNote, username }: EmailTemplateData): string {
  const accentColor = { otp: "#1a73e8", password: "#0f9d58", info: "#f59e0b", alert: "#e53e3e" };
  const color = accentColor[type];

  const usernameBlock = username ? `
    <div style="background:#f0f4f8; border-left:4px solid ${color}; padding:16px 24px; border-radius:4px; margin:20px 0;">
      <p style="margin:0 0 6px; font-size:11px; color:#888; letter-spacing:1px; text-transform:uppercase;">Username</p>
      <span style="font-size:20px; font-weight:600; color:#333; font-family:monospace;">${username}</span>
    </div>` : "";

  const highlightBlock = highlightValue ? `
    <div style="background:#f0f4f8; border-left:4px solid ${color}; padding:16px 24px; border-radius:4px; margin:20px 0;">
      ${highlightLabel ? `<p style="margin:0 0 6px; font-size:11px; color:#888; letter-spacing:1px; text-transform:uppercase;">${highlightLabel}</p>` : ""}
      <span style="font-size:20px; font-weight:600; letter-spacing:4px; color:${color}; font-family:monospace;">${highlightValue}</span>
    </div>` : "";

  return `
<div style="font-family:Arial,sans-serif; max-width:480px; margin:0 auto; padding:32px; border:1px solid #e2e8f0; border-radius:8px;">
  <h2 style="color:${color}; margin:0 0 6px;">${title}</h2>
  ${subtitle ? `<p style="color:#555; margin:0 0 16px;">${subtitle}</p>` : ""}
  ${usernameBlock}
  ${highlightBlock}
  ${message ? `<p style="color:#555; font-size:14px; line-height:1.6; margin:16px 0 0;">${message}</p>` : ""}
  <p style="color:#aaa; font-size:11px; margin:24px 0 0; border-top:1px solid #eee; padding-top:12px;">
    ${footerNote ?? "If you didn't request this, please ignore this email."}
  </p>
</div>`;
}

type EmailTemplateType = "otp" | "password" | "info" | "alert";

type EmailTemplateData = {
  type: EmailTemplateType;
  title: string;
  subtitle?: string;
  highlightValue?: string;
  highlightLabel?: string;
  username?: string;
  message?: string;
  footerNote?: string;
};
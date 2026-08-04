import axios, { AxiosInstance, AxiosError } from "axios";

//   __define-ocg__  Production Grade PRP SMS Service
interface SendOtpParams {
    mobile: string;
    otp?: string;
    type: string;
    password?: string;
    username?: string
}

interface TokenCache {
    token: string | null;
    expiry: number;
}

interface PRPSmsPayload {
    sender: string;
    peId: string;
    teId: string;
    Unicode: number;
    flash: string;
    isscheduled: boolean;
    isEncryption: boolean;
    isCallBackUrl: boolean;
    optoutlink: boolean;
    userId: number;
    messageSource: number;
    senderId: string;
    templateId: string;
    shorturl: string;
    message: string;
    smsReciever: {
        reciever: string;
        message: string;
    }[];
    sheduledOn: string;
    smscId: string;
    userName: string;
    activityName: string;
}

interface BuildMessageTypes {
    otp?: string;
    username?: string;
    password?: string;
    type: string;
}

function requireEnv(name: string): string {
    const value = process.env[name];
    if (!value) {
        throw new Error(`Missing ENV variable: ${name}`);
    }
    return value;
}

export class PRPSmsService {

    private loginUrl = requireEnv("PRP_SMS_LOGIN_URL");
    private smsUrl = requireEnv("PRP_SMS_URL");

    private username = requireEnv("PRP_SMS_USERNAME");
    private password = requireEnv("PRP_SMS_PASSWORD");

    private senderId = requireEnv("PRP_SMS_SENDER_ID");
    private otpSender = requireEnv("PRP_OTP_SENDER");
    private passwordSender = requireEnv("PRP_PASS_SENDER");
    private otpTemp = requireEnv("SMS_OTP_TEMP");
    private passwordTemp = requireEnv("SMS_PASS_TEMP");

    private smscId = requireEnv("PRP_SMSC_ID");
    private userId = Number(requireEnv("PRP_USER_ID"));

    private axios: AxiosInstance;

    private tokenCache: TokenCache = {
        token: null,
        expiry: 0
    };

    constructor() {
        this.axios = axios.create({
            timeout: 15000
        });
    }

    //  Get cached token or login again
    private async getToken(): Promise<string | null> {

        const now = Date.now();

        if (this.tokenCache.token && now < this.tokenCache.expiry) {
            return this.tokenCache.token;
        }

        try {

            const response = await this.axios.post(
                this.loginUrl,
                new URLSearchParams({
                    uname: this.username,
                    upass: this.password
                }),
                {
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    }
                }
            );

            const token = response.data?.token;

            if (!token) {
                console.error("PRP login failed:", response.data);
                return null;
            }

            this.tokenCache = {
                token,
                expiry: now + 50 * 60 * 1000
            };

            return token;

        } catch (error) {

            const err = error as AxiosError;

            console.error(
                "PRP login error:",
                err.response?.data || err.message
            );

            return null;
        }
    }

    //  OTP message builder
    private buildOtpMessage({ otp, username, password, type }: BuildMessageTypes) {
        let varOcg: string = "";
        if (type === "otp") {
            varOcg =
                `Dear User, Your OTP for login to NamedPatientProgram.com portal is ${otp}. ` +
                `Valid for 10 minutes. Please do not share this OTP. Regards, NamedPatientProgram Team`;
        } else if (type === "password") {
            varOcg = `Welcome to NamedPatientProgram! Your login credentials are: Username: ${username} Password: ${password} You can update your password anytime. Do not share this password with anyone. Warm regards, NamedPatientProgram Team`;
        }
        return varOcg;
    }

    //  Mobile validation
    private validateMobile(mobile: string) {
        const clean = mobile.replace("+", "");

        if (!/^\d{10,15}$/.test(clean)) {
            throw new Error("Invalid mobile number");
        }

        return clean;
    }

    // Send OTP
    public async sendOtp({ mobile, otp, type, password, username }: SendOtpParams): Promise<boolean> {

        const cleanMobile = this.validateMobile(mobile);

        const token = await this.getToken();

        if (!token) {
            console.error("PRP token unavailable");
            return false;
        }

        const payload: PRPSmsPayload = {

            sender: type === "otp" ? this.otpSender : this.passwordSender,
            peId: this.senderId,
            teId: type === "otp" ? this.otpTemp : this.passwordTemp,

            Unicode: 0,
            flash: "0",
            isscheduled: false,
            isEncryption: false,
            isCallBackUrl: false,
            optoutlink: false,

            userId: this.userId,
            messageSource: 1,

            senderId: this.senderId,
            templateId: type === "otp" ? this.otpTemp : this.passwordTemp,

            shorturl: "",
            message: type === "otp" ? this.buildOtpMessage({ otp, type }) : this.buildOtpMessage({ username, password, type }),

            smsReciever: [
                {
                    reciever: cleanMobile,
                    message: ""
                }
            ],

            sheduledOn: Math.floor(Date.now() / 1000).toString(),

            smscId: this.smscId,

            userName: this.username,
            activityName: ""
        };

        return this.retrySend(payload, token);
    }

    //  Retry logic with exponential backoff
    private async retrySend(
        payload: PRPSmsPayload,
        token: string
    ): Promise<boolean> {

        const maxRetries = 3;

        for (let attempt = 1; attempt <= maxRetries; attempt++) {

            try {

                const response = await this.axios.post(
                    this.smsUrl,
                    payload,
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                            "Content-Type": "application/json"
                        }
                    }
                );

                if (response.data?.isSuccess) {
                    return true;
                }

                console.error("PRP SMS failed:", response.data);

            } catch (error) {

                const err = error as AxiosError;

                if (err.response?.status === 401) {

                    console.warn("Token expired. Refreshing...");

                    this.tokenCache = { token: null, expiry: 0 };

                    const newToken = await this.getToken();

                    if (newToken) {
                        token = newToken;
                    }
                }

                console.error(
                    `SMS attempt ${attempt} failed`,
                    err.response?.data || err.message
                );
            }

            const delay = 1000 * Math.pow(2, attempt);
            await new Promise(r => setTimeout(r, delay));
        }

        return false;
    }
};

//
// import axios, { AxiosInstance, AxiosError } from "axios";

// // ─── Interfaces ───

// interface SendOtpParams {
//     mobile: string;
//     otp?: string;
//     type: "otp" | "password";
//     password?: string;
//     username?: string;
// }

// interface TokenCache {
//     token: string | null;
//     expiry: number;
// }

// interface PRPSmsPayload {
//     sender: string;
//     peId: string;
//     teId: string;
//     Unicode: number;
//     flash: string;
//     isscheduled: boolean;
//     isEncryption: boolean;
//     isCallBackUrl: boolean;
//     optoutlink: boolean;
//     userId: number;
//     messageSource: number;
//     senderId: string;
//     templateId: string;
//     shorturl: string;
//     message: string;
//     smsReciever: {
//         reciever: string;
//         message: string;
//     }[];
//     sheduledOn: string; // API typo preserved intentionally
//     smscId: string;
//     userName: string;
//     activityName: string;
// }

// interface BuildMessageParams {
//     otp?: string;
//     username?: string;
//     password?: string;
//     type: "otp" | "password";
// }

// // ── Helpers ──

// /**
//  * Reads a required environment variable and throws a descriptive error if absent.
//  * Called lazily (inside the constructor) so stack traces point to instantiation.
//  */
// function requireEnv(name: string): string {
//     const value = process.env[name];
//     if (!value) {
//         throw new Error(`Missing required environment variable: ${name}`);
//     }
//     return value;
// }

// /** Strips all non-digit characters and validates the resulting mobile number. */
// function sanitizeMobile(mobile: string): string {
//     const digits = mobile.replace(/\D/g, "");
//     if (!/^\d{10,15}$/.test(digits)) {
//         throw new Error(
//             `Invalid mobile number "${mobile}": must contain 10–15 digits after stripping non-numeric characters.`
//         );
//     }
//     return digits;
// }

// const RETRY_BASE_DELAY_MS = 1_000;
// const MAX_RETRIES = 3;
// const TOKEN_TTL_MS = 50 * 60 * 1_000; // 50 minutes (tokens expire at 60 min)
// const REQUEST_TIMEOUT_MS = 15_000;

// // ─── Service ──

// export class PRPSmsService {

//     private readonly loginUrl: string;
//     private readonly smsUrl: string;

//     private readonly username: string;
//     private readonly password: string;

//     private readonly senderId: string;
//     private readonly peId: string;       // DLT Principal Entity ID (distinct from Sender ID)
//     private readonly otpSender: string;
//     private readonly passwordSender: string;
//     private readonly otpTemplateId: string;
//     private readonly passwordTemplateId: string;

//     private readonly smscId: string;
//     private readonly userId: number;

//     private readonly http: AxiosInstance;

//     private tokenCache: TokenCache = { token: null, expiry: 0 };

//     constructor() {
//         // All env reads happen here so missing variables surface at instantiation time.
//         this.loginUrl = requireEnv("PRP_SMS_LOGIN_URL");
//         this.smsUrl = requireEnv("PRP_SMS_URL");
//         this.username = requireEnv("PRP_SMS_USERNAME");
//         this.password = requireEnv("PRP_SMS_PASSWORD");
//         this.senderId = requireEnv("PRP_SMS_SENDER_ID");
//         this.peId = requireEnv("PRP_PE_ID");          // DLT PE ID
//         this.otpSender = requireEnv("PRP_OTP_SENDER");
//         this.passwordSender = requireEnv("PRP_PASS_SENDER");
//         this.otpTemplateId = requireEnv("SMS_OTP_TEMP");
//         this.passwordTemplateId = requireEnv("SMS_PASS_TEMP");
//         this.smscId = requireEnv("PRP_SMSC_ID");
//         this.userId = Number(requireEnv("PRP_USER_ID"));

//         this.http = axios.create({ timeout: REQUEST_TIMEOUT_MS });
//     }

//     // ── Public API ──

//     /**
//      * Sends an OTP or password-credential SMS to the given mobile number.
//      * Returns `true` on success, `false` after all retry attempts are exhausted.
//      */
//     public async sendOtp({
//         mobile,
//         otp,
//         type,
//         password,
//         username,
//     }: SendOtpParams): Promise<boolean> {
//         const cleanMobile = sanitizeMobile(mobile);

//         const token = await this.getToken();
//         if (!token) {
//             console.error("[PRPSmsService] Token unavailable — aborting send.");
//             return false;
//         }

//         const isOtp = type === "otp";
//         const templateId = isOtp ? this.otpTemplateId : this.passwordTemplateId;
//         const message = this.buildMessage({ otp, username, password, type });

//         const payload: PRPSmsPayload = {
//             sender: isOtp ? this.otpSender : this.passwordSender,
//             peId: this.peId,
//             teId: templateId,

//             Unicode: 0,
//             flash: "0",
//             isscheduled: false,
//             isEncryption: false,
//             isCallBackUrl: false,
//             optoutlink: false,

//             userId: this.userId,
//             messageSource: 1,

//             senderId: this.senderId,
//             templateId,

//             shorturl: "",
//             message,

//             smsReciever: [{ reciever: cleanMobile, message: "" }],

//             // API field name is a known typo in the upstream service; preserved to match contract.
//             sheduledOn: Math.floor(Date.now() / 1_000).toString(),

//             smscId: this.smscId,
//             userName: this.username,
//             activityName: "",
//         };

//         return this.sendWithRetry(payload, token);
//     }

//     // ── Token management ──

//     /** Returns a valid bearer token, refreshing via login if the cached one has expired. */
//     private async getToken(): Promise<string | null> {
//         if (this.tokenCache.token && Date.now() < this.tokenCache.expiry) {
//             return this.tokenCache.token;
//         }

//         try {
//             const response = await this.http.post(
//                 this.loginUrl,
//                 new URLSearchParams({ uname: this.username, upass: this.password }),
//                 { headers: { "Content-Type": "application/x-www-form-urlencoded" } }
//             );

//             const token: string | undefined = response.data?.token;
//             if (!token) {
//                 console.error("[PRPSmsService] Login succeeded but no token in response:", response.data);
//                 return null;
//             }

//             this.tokenCache = { token, expiry: Date.now() + TOKEN_TTL_MS };
//             return token;

//         } catch (error) {
//             const err = error as AxiosError;
//             console.error("[PRPSmsService] Login request failed:", err.response?.data ?? err.message);
//             return null;
//         }
//     }

//     /** Invalidates the token cache, forcing the next `getToken()` call to re-authenticate. */
//     private invalidateToken(): void {
//         this.tokenCache = { token: null, expiry: 0 };
//     }

//     // ── Message builder ──

//     private buildMessage({ otp, username, password, type }: BuildMessageParams): string {
//         switch (type) {
//             case "otp":
//                 return (
//                     `Dear User, Your OTP for login to NamedPatientProgram.com portal is ${otp}. ` +
//                     `Valid for 10 minutes. Please do not share this OTP. Regards, NamedPatientProgram Team`
//                 );
//             case "password":
//                 return (
//                     `Welcome to NamedPatientProgram! Your login credentials are: ` +
//                     `Username: ${username} Password: ${password} ` +
//                     `You can update your password anytime. Do not share this password with anyone. ` +
//                     `Warm regards, NamedPatientProgram Team`
//                 );
//             default:
//                 // `type` is narrowed to `never` here; the cast satisfies the compiler
//                 // while surfacing unexpected values at runtime.
//                 throw new Error(`[PRPSmsService] Unknown message type: "${type as string}"`);
//         }
//     }

//     // ── Retry logic ──

//     /**
//      * Attempts to deliver the SMS payload up to MAX_RETRIES times with
//      * exponential back-off. On a 401 the token is refreshed before the next attempt.
//      * Back-off delay is NOT applied after the final failed attempt.
//      */
//     private async sendWithRetry(payload: PRPSmsPayload, token: string): Promise<boolean> {
//         for (let attempt = 1; attempt <= MAX_RETRIES; attempt++) {
//             try {
//                 const response = await this.http.post(this.smsUrl, payload, {
//                     headers: {
//                         Authorization: `Bearer ${token}`,
//                         "Content-Type": "application/json",
//                     },
//                 });

//                 if (response.data?.isSuccess) {
//                     console.info(
//                         `[PRPSmsService] SMS delivered on attempt ${attempt} to ${payload.smsReciever[0]?.reciever}.`
//                     );
//                     return true;
//                 }

//                 console.error(`[PRPSmsService] API rejected the request (attempt ${attempt}):`, response.data);

//             } catch (error) {
//                 const err = error as AxiosError;

//                 if (err.response?.status === 401) {
//                     console.warn("[PRPSmsService] Received 401 — refreshing token before next attempt.");
//                     this.invalidateToken();
//                     const refreshed = await this.getToken();
//                     if (refreshed) {
//                         token = refreshed;
//                     }
//                 } else {
//                     console.error(
//                         `[PRPSmsService] Network/transport error on attempt ${attempt}:`,
//                         err.response?.data ?? err.message
//                     );
//                 }
//             }

//             // Skip the delay after the last attempt — no further retry will follow.
//             if (attempt < MAX_RETRIES) {
//                 const delayMs = RETRY_BASE_DELAY_MS * Math.pow(2, attempt - 1);
//                 await new Promise<void>((resolve) => setTimeout(resolve, delayMs));
//             }
//         }

//         console.error(
//             `[PRPSmsService] All ${MAX_RETRIES} attempts failed for ${payload.smsReciever[0]?.reciever}.`
//         );
//         return false;
//     }
// }
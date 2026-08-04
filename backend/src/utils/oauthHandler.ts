import { Profile } from "passport-google-oauth20";
import User from "../models/user.model";

export const handleOAuthLogin = async (
    provider: "google",
    profile: Profile
) => {
    const email = profile.emails?.[0]?.value;

    if (!email) {
        return { error: "EMAIL_NOT_AVAILABLE" };
    }

    const existingUser = await User.findOne({ email: email.toLowerCase() });

    if (existingUser && existingUser.authProvider !== provider) {
        return {
            error: "ACCOUNT_EXISTS_WITH_DIFFERENT_PROVIDER",
        };
    }

    if (existingUser) {
        return { user: existingUser };
    }

    const user = await User.create({
        email,
        googleId: profile.id,
        authProvider: provider,
    });

    return { user };
};

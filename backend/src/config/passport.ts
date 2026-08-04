import passport from "passport";
import { Strategy as GoogleStrategy } from "passport-google-oauth20";
import { handleOAuthLogin } from "../utils/oauthHandler"

passport.use(
    new GoogleStrategy(
        {
            clientID: process.env.GOOGLE_CLIENT_ID!,
            clientSecret: process.env.GOOGLE_CLIENT_SECRET!,
            callbackURL: `${process.env.SOCIAL_REDIRECT_URI}/google/callback`,
        },
        async (_accessToken, _refreshToken, profile, done) => {
            try {
                const result = await handleOAuthLogin("google", profile);

                if (result.error) {
                    return done(null, false, {
                        message: result.error,
                    });
                }

                return done(null, result.user);
            } catch (err) {
                return done(err, false);
            }
        }
    )
);


export default passport;
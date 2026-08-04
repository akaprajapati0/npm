import express from "express";
import passport from "passport";
import { OAuth2Client } from 'google-auth-library';
import { deactivateAccount, getAllUserData, getAllUsers, getUserProfile, login, logout, reactivateAccount, refreshAccessToken, registerWithOtp, sendOtp, updatePassword, updateProgress, updateUserProfile, verifyOtp } from '../controllers/userAuth.controller';
import { generateAccessToken, generateRefreshToken } from '../utils/token';
import { adminProtect, authorizePermissions, protectAuth } from '../middleware/authMiddleware';
// import { uploadFiles } from '../middleware/multer';
import { Permission } from '../types/adminTypes';
import { handleOAuthLogin } from '../utils/oauthHandler';
import User from '../models/user.model';

const router = express.Router();

router.post("/send-otp", sendOtp);
router.post("/verify-otp-signup", registerWithOtp);
router.post("/verify-otp", protectAuth, verifyOtp);
router.post("/user-login", login);
router.post("/refresh-token", refreshAccessToken);
router.get("/get-user", protectAuth, getUserProfile);
router.get("/user-data", adminProtect, authorizePermissions(Permission.READ_ADMIN), getAllUsers);
router.get("/user-data/:id", adminProtect, authorizePermissions(Permission.READ_ADMIN), getAllUserData);
// router.put("/update-profile", protectAuth, uploadFiles("profile-image"), updateUserProfile);
router.post("/update-password", updatePassword);
router.put("/update-progress", protectAuth, updateProgress);
router.post("/logout", logout);

router.put("/deactivate-account", protectAuth, deactivateAccount);
router.put("/admin/reactivate-account/:id", adminProtect, reactivateAccount);


// Redirect to Google
router.get(
    "/google",
    passport.authenticate("google", { scope: ["profile", "email"] })
);

// Callback from Google
router.get(
    "/google/callback",
    passport.authenticate("google", {
        session: false, failureRedirect: `${process.env.FRONTEND_URL}/login?error=provider_mismatch`,
    }),
    async (req, res) => {
        const user = req.user as { id: string };

        const accessToken = generateAccessToken(user.id);
        const refreshToken = generateRefreshToken(user.id);

        // Set refresh token cookie
        res.cookie("refreshToken", refreshToken, {
            httpOnly: true,
            secure: process.env.NODE_ENV === "production",
            sameSite: "lax",
            path: "/",
            maxAge: 7 * 24 * 60 * 60 * 1000,
        });

        res.redirect(`${process.env.FRONTEND_URL}/callback?token=${accessToken}`);
    }
);

// Flutter Google Signin
router.post("/google/token", async (req, res) => {
    const { idToken } = req.body;

    if (!idToken) {
        return res
            .status(400)
            .json({ success: false, message: "idToken required" });
    }

    const client = new OAuth2Client(process.env.GOOGLE_CLIENT_ID);

    try {
        const ticket = await client.verifyIdToken({
            idToken,
            audience: process.env.GOOGLE_CLIENT_ID,
        });
        const payload = ticket.getPayload();

        const fakeProfile = {
            id: payload!.sub,
            emails: [{ value: payload!.email }],
            displayName: payload!.name,
        };

        const result = await handleOAuthLogin("google", fakeProfile as any);

        if (result.error) {
            return res.status(401).json({
                success: false,
                message: result.error,
            });
        }

        const user = await User.findById(result.user!._id);

        if (!user) {
            return res
                .status(404)
                .json({ success: false, message: "User not found" });
        }

        const accessToken = generateAccessToken(user.id.toString());
        const refreshToken = generateRefreshToken(user.id.toString());

        // Exactly same as login controller
        user.refreshToken = refreshToken;
        await user.save();

        return res.status(200).json({
            success: true,
            message: "Login successful",
            data: {
                accessToken,
                refreshToken,
                user: {
                    id: user._id,
                    progress: user.progress,
                    email: user.email,
                },
            },
        });
    } catch (err) {
        return res
            .status(401)
            .json({ success: false, message: "Invalid Google token" });
    }
});



export default router;

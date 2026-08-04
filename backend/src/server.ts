import app from "./app";
import { connecToDB } from "./config/db";
import { startAccountCleanupJob } from './event/userDataCleaner';

const PORT = process.env.PORT || 5000;


app.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
    connecToDB();
    startAccountCleanupJob();
});

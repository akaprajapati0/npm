import { caretakerEvents } from '../event/caretakerEvents';
import { autoOrderCheck } from '../service/autoOrder.service';

caretakerEvents.on("caretaker:updated", async (caretakerId: string) => {
    try {
        await autoOrderCheck(caretakerId);
    } catch (error) {
        console.error("Auto-order event error:", error);
    }
});
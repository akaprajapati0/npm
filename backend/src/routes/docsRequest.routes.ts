import { Router } from "express";
import { getAllDocument, updateDocumentStatus, requestDocument, getMyDocumentByUser, reviseDocumentRequest } from '../controllers/docsRequest.controller';
import { adminProtect, authorizePermissions, protectAuth } from '../middleware/authMiddleware';
import { uploadFiles } from '../middleware/multer';
import { Permission } from '../types/adminTypes';


const router = Router();

router.post("/:type", protectAuth, requestDocument);
router.get("/docs/user/:type", protectAuth, getMyDocumentByUser);
// router.get("/docs/:id/:type", adminProtect, authorizePermissions(Permission.READ_ADMIN), getMyDocumentByAdmin);

router.put(
    "/update/:id/:type",
    adminProtect,
    authorizePermissions(Permission.UPDATE_ADMIN),
    uploadFiles("requested-documents"),
    updateDocumentStatus
);

router.put(
    "/revise/:id/:type",
    protectAuth,
    reviseDocumentRequest
);


// router.get("/", protectAuth, getAllDocument);
router.get("/:id", adminProtect,
    authorizePermissions(Permission.READ_ADMIN), getAllDocument
);

// router.put(
//     "/docs/:id/:type",
//     adminProtect,
//     authorizePermissions(Permission.UPDATE_ADMIN),
//     uploadFiles("requested-documents"),
//     uploadDocumentFile
// );



// router.get("/count", protectAuth, getDocumentCount)


export default router;

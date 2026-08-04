const MAX_FILE_SIZE_MB = 5;
const MAX_FILE_SIZE_BYTES = MAX_FILE_SIZE_MB * 1024 * 1024;

export function base64ToFile(base64: string, filename?: string) {
    const mimeMatch = base64.match(/data:(.*?);base64,/);
    const mime = mimeMatch ? mimeMatch[1] : "image/jpeg";

    const extension = mime.split("/")[1];
    const finalFilename = filename ?? `file_${Date.now()}.${extension}`;

    const base64Data = base64.split(",")[1];
    const binary = atob(base64Data);
    const size = binary.length;

    if (size > MAX_FILE_SIZE_BYTES) {
        console.error("File exceeds 5MB limit");
        return null;
    }

    const array = new Uint8Array(size);
    for (let i = 0; i < size; i++) {
        array[i] = binary.charCodeAt(i);
    }

    return new File([array], finalFilename, { type: mime });
}

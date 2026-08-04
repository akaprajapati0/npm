export const getImageUrl = (path?: string) => {
    if (!path) return "/profile-img.webp";
    return `${process.env.NEXT_PUBLIC_IMAGE_URL}/${path}`;
};
export type CaretakerInput = {
    fullname: string;
    relationship: string;
    city: string;
    password: string;
    email?: string;
    phone?: string;
};

export type Image = {
    url: string;
    mimeType?: string;
    size?: number;
};
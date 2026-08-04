export async function refreshAccessToken() {
    try {
        const res = await fetch(`${process.env.NEXT_PUBLIC_API_URL}/auth/refresh-token`, {
            method: "POST",
            credentials: "include",
        });

        if (!res.ok) return null;

        const data = await res.json();
        return data?.data?.accessToken;
    } catch {
        return null;
    }
}

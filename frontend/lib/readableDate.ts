export default function DateDisplay({ isoString }: { isoString?: number | string | null }) {
    if (!isoString) {
        return '';
    }

    const date = new Date(isoString);

    if (isNaN(date.getTime())) {
        return '';
    }

    return new Intl.DateTimeFormat('en-GB', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
    }).format(date);
}

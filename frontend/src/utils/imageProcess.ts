export const imageProcess = (img: string) => {
    return `${import.meta.env.VITE_API_BASE_URL}/images/${img}`;
}
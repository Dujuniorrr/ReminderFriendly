export default class DatePresenter {
    public static present(date: string) {
        const dateObject = new Date(date);

        const day = dateObject.getDate();
        const month = dateObject.toLocaleString('pt-BR', { month: 'long' });
        const year = dateObject.getFullYear();
        const hours = dateObject.getHours().toString().padStart(2, '0');
        const minutes = dateObject.getMinutes().toString().padStart(2, '0');

        const formattedDate = `${day} de ${month} de ${year}, às ${hours}:${minutes}`;

        return formattedDate;

    }
}
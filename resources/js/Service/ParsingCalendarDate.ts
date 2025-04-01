import { CalendarDate } from '@internationalized/date'

/**
 * Converts a `CalendarDate` object into a string formatted as 'YYYY-MM-DD'.
 * 
 * @param {CalendarDate} date - The date object to be converted.
 * @returns {string} The formatted date string in 'YYYY-MM-DD' format.
 */
const parseDateToYMD = (date: CalendarDate): string => {
    return `${date.year}-${String(date.month).padStart(2, '0')}-${String(date.day).padStart(2, '0')}`;
};

export default parseDateToYMD;

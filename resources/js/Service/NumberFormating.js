class NumberFormating {
    static rekeningFormat(number){
        if (number === null) {
            return '0';
        }
        let sanitizedValue = number.replace(/[^0-9.]/g, '');
        sanitizedValue = sanitizedValue.replace(/\.{2,}/g, '.');
        return sanitizedValue;
    }
}

export default NumberFormating

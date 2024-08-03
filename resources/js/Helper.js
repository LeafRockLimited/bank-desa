import currency from "currency.js"
import moment from "moment";

class Helper {

    static rupiah(nominal) {
        nominal = parseInt(nominal)
        let parsing = currency(nominal, { 
                symbol: 'Rp. ', 
                decimal: ',', 
                separator: '.' ,
                precision: 0
            }
        )
        return parsing.format()
    }

    static persen(value, decimals = 2) {
        if (isNaN(value)) {
            return '0%';
        }
        value = parseFloat(value)
        
        return `${(value * 100).toFixed(decimals)}%`;
    }

    static tanggal(date){
        return moment(moment(date)).format("DD-MMMM-YYYY");
    }

    static bulan = [
        { nama: "Januari", value: 1 },
        { nama: "Februari", value: 2 },
        { nama: "Maret", value: 3 },
        { nama: "April", value: 4 },
        { nama: "Mei", value: 5 },
        { nama: "Juni", value: 6 },
        { nama: "Juli", value: 7 },
        { nama: "Agustus", value: 8 },
        { nama: "September", value: 9 },
        { nama: "Oktober", value: 10 },
        { nama: "November", value: 11 },
        { nama: "Desember", value: 12 }
    ];

}

export default Helper
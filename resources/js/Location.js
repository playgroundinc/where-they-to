class Location {
    constructor() {
        this.provinces = {
            OE: "Online Event",
            AB: "Alberta",
            BC: "British Columbia",
            NL: "Newfoundland and Labrador",
            PE: "Prince Edward Island",
            NS: "Nova Scotia",
            NB: "New Bruinswick",
            QC: "Québec",
            ON: "Ontario",
            MB: "Manitoba",
            SK: "Saskatchewan",
            YT: "Yukon",
            NT: "Northwest Territories",
            NU: "Nunavut"
        };
        this.timezones = {
            AST: "Atlantic Standard Time",
            CST: "Central Standard Time",
            EST: "Eastern Standard Time",
            MST: "Manitoba Standard Time",
            NST: "Newfoundland Standard Time",
            PST: "Pacific Standard Time"
        };
    }
    getProvinces() {
        return this.provinces;
    }
    getTimezones() {
        return this.timezones;
    }
}

export default Location;

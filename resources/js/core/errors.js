class Errors {
    constructor(fields) {
        this.errors = [];
        this.fields = fields;
    }
    checkFields() {
        for (let field in this.fields) {
            if (!this.fields[field].length > 0) {
                this.errors.push(field);
            }
        }
        console.log(this.errors);
        return this.errors;
    }
}

export default Errors;

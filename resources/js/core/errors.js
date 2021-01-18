class Errors {
    constructor(fields) {
        this.errors = [];
        this.fields = fields;
    }
    checkFields() {
        for (let field in this.fields) {
            if (field === 'user_id') {
                continue;
            }
            if (!this.fields[field].length > 0) {
                this.errors.push(field);
            }
        }
        return this.errors;
    }
}

export default Errors;

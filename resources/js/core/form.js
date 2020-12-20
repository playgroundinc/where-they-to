import Errors from "./errors";
import store from '../store'

class Form {
    constructor(data, route, destination) {
        this.originalData = data;
        this.route = route;
        this.destination = destination;
        for (let field in data) {
            this[field] = data[field];
        }
        this.errors = new Errors();
    }
    data() {
        let data = {};

        for (let property in originalData) {
            data[property] = this[property];
        }
        return data;
    }
    reset() {
        for (let field in this.originalData) {
            this[field] = "";
        }
        this.errors.clear();
    }
    verifyPasswords() {
        return this.password === this.password_confirmation;
    }
    checkRequiredFields() {
        const ErrorClass = new Errors(this.originalData);
        const errors = ErrorClass.checkFields();
        if (errors.length) {
            return errors;
        }
        return [];
    }
    async submitForm() {
        const resp = await store.dispatch(this.route, this.originalData)
        if (resp.status === 201) {
            return { status: 'success' };
        }
        return { status: 'error', error: resp.error };
    }

    onSuccess(data) {
        alert(data);
        this.reset();
    }
    onFail(errors) {

        this.errors.record(errors.errors);
    }
}

export default Form;

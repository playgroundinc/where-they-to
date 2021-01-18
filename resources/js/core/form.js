import Errors from "./errors";
import store from '../store';
import socialMedia from "../core/social-media";

class Form {
    constructor(data, endpoint, route = null) {
        this.originalData = data;
        this.endpoint = endpoint;
        this.route = route;
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
    setAdditionalFields(fields) {
        for (let field in fields) {
            this.originalData[field] = fields[field];
        }
    }
    async submitForm() {
        let resp;
        if (this.route) {
            resp = await store.dispatch(this.endpoint, { ...this.route, data: this.originalData })
        } else {
            resp = await store.dispatch(this.endpoint, this.originalData)
        }
        if (resp.status === 201 || resp.status === 200) {
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
  async handleSubmit() {
    const resp = await this.checkRequiredFields();
    return resp;
  }
}

export default Form;

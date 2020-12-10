import Errors from "./errors";

class Form {
  constructor(data, route, store) {
    this.originalData = data;
    for (let field in data) {
        this[field] = data[field];
    }
    this.errorsClass = new Errors(data);
    this.route = route; 
    this.store = store;
  }
  async submitForm() {  
    const resp = await this.store.dispatch(this.route, this.originalData);
    if (resp.status === 201) {
      return {
        status: 'success',
      }
    } 
    return {
      status: 'error',
      errors: ['endpoint'],
    }
  }
  async checkRequiredFields() {
    const errors = this.errorsClass.checkFields();
    if (errors.length) {
      const resp = {  
        status: 'error',
        errors,
      }
      return resp;
    }
    const status = await this.submitForm();
    return status;
  }
  async handleSubmit() {
    const resp = await this.checkRequiredFields();
    return resp;
  }
}

export default Form;

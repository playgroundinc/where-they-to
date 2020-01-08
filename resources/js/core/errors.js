class Errors {
  constructor() {
    this.errors = {}
  }
  any() {
    return Object.keys(this.errors).length > 0;
  }
  get(field) {
    if (this.errors[field]) {
      return this.errors[field][0];
    }
  }
  has(field) {
    return this.errors.hasOwnProperty(field);
    ç
  }
  record(errors) {
    this.errors = errors;
  }
  clear(event) {
    if (event && this.errors[event.target.name]) {
      delete this.errors[event.target.name];
      return;
    } 
    this.errors = {};
  }
}

export default Errors;
import Vue from 'vue';
import axios from 'axios';

import Form from './core/form';

import Example from './components/Example';

window.axios = axios;
window.Form = Form;

new Vue({
  el: '#root',  
  data: {
    form: new Form({
      title: "",
      description: "",
    }),
  },
  components: {
    Example,
  },
  methods: {
    onSubmit() {
      this.form.submit('post', '/projects')
      .then(alert('handling it!'))
      .catch((error) => console.log(error));
    },
    onSuccess(res) {
      form.reset();
    }
  }
})
<template>
    <div class="row form-group">
      <div class="col-xxs-12">
        <form v-on:submit.prevent="postUpdate" novalidate>
          <Input 
            name="update"
            :value="update"
            type="textarea"
            :errors="errors"
            :required="true"
            v-on:update="updateValue"
          />
          <Button 
            variation="input"
            label="Post Update"
            v-on:clicked="postUpdate"
          />
        </form>
      </div>
      <div class="col-xxs-12">
        <div v-for="post in updates" v-bind:key="post.id">
          <p>{{ post.created_at }}</p>
          <p>{{ post.update }}</p>
        </div>
      </div>
    </div>
</template>
<script>
// Classes.
import Form from "../core/form";

// Components.
import Input from "./Input";
import Button from "./Button";
export default {
  data() {
    return {
      update: "",
      updates: [],
      errors: [],
    }
  },
  props: {
    id: {
      required: true,
    },
    type: {
      type: String, 
      required: true,
    }
  },
    components: {
        Button,
        Input,
    },
    computed: {
      valid: function() {
        return !this.errors.length > 0;
      }
    },
    methods: {
      updateValue: function(updateObject) {
        this[updateObject.name] = updateObject.value;
      },
      createUpdate: async function(FormClass) {
        const resp = await FormClass.submitForm();
        if (resp.status === 'success') {
          this.fetchUpdates();
        }
      },
      postUpdate: function() {
        let data = {
          update: this.update,
          id: this.id,
          type: this.type,
        }
        const FormClass = new Form(data, "create", { route: "updates" });
        this.errors = FormClass.checkRequiredFields(data);
        if (this.valid) {
          this.createUpdate(FormClass);
        }
      },
      setUpdates(updates) {
        this.updates = updates;
      },
      async fetchUpdates() {
        const data = {
          route: `updates/${this.type}`,
          id: this.id,
        }
        const resp = await this.$store.dispatch('fetchSingle', data);
        if (resp.status === 200 && resp.data && resp.data.updates) {
          this.setUpdates(resp.data.updates);
        }
      }
    },
    mounted() {
      this.fetchUpdates();
    }
}
</script>

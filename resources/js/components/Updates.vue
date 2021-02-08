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
        return this.errors.length > 0;
      }
    },
    methods: {
      updateValue: function(updateObject) {
        console.log(updateObject);
        this[updateObject.name] = updateObject.value;
      },
      createUpdate: function() {

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
      }
    }
}
</script>

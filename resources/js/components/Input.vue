<template>
<div class="container">
    <div class="form-group">
        <label :for="input.name">{{ input.label }}</label>
        <input v-model="inputData" @keyup="$emit('update:inputData', value)" :name="input.name" :id="input.name" :type="input.type" :class="input.class" :placeholder="input.placeholder" @blur="validation()">
        <div class="invalid-feedback">
            {{ input.valmessage }}
        </div>
    </div>    
</div>
</template>

<script>
export default {
    props: ['label', 'name', 'type', 'placeholder', 'validations', 'inputData'],
    data() {
        return {
            value: this.inputData,
            element: '',
            input : {
                name: "",
                type: "text",
                placeholder: "",
                validations: [],
                valmessage: "",
                class: "form-control"
            }

        }
    },
    mounted() {
        this.input.name = this.name;
        this.input.label = this.label;
        this.input.type = this.type;
        this.input.placeholder = this.placeholder;
        this.input.validations = this.validations;
    },
    methods: {
        validation() {
            if (this.input.validations) {
                this.putUpValidations(this.input.validations);
            }
        },
        putUpValidations(vals) {
            vals.forEach(val => {
                switch (val) {
                    case 'notNull':
                        this.valNotNull(val);
                        break;
                }

            });
        },
        valNotNull(val) {
            if (this.value == "") {
                this.input.valmessage = "Preenchimento obrigatório!";
                this.input.class = "form-control is-invalid";
                this.$emit('onerror', this.input.name);
            } else {
                this.input.valmessage = "";
                this.input.class = "form-control";
            }
        }
    }
}
</script>

<style>

</style>
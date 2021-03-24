<template>
<div class="container">
<div class="modal fade" :id="label" tabindex="-1" role="dialog" :aria-labelledby="label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success" :id="label">{{ title }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" v-text="body">
      </div>
      <div class="modal-footer">
        <button name="Fechar" id="Fechar" type="button" class="btn btn-success" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>  
</div>
</template>

<script>
export default {
    props: ['label', 'title', 'body'],
    data() {
        return {
            modal : {
                label: "",
                title: "",
                body: ""
            }
        }
    },
    mounted() {
        this.modal.title = this.title;
        this.modal.label = this.label;
        this.modal.body = this.body;
    }
}
</script>
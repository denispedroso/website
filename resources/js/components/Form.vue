<template>
<div class="container">
    <ul class="list-group">
        <a v-for="(item, index) in newcards" :key="item.index" @click="showItem(item)" href="#" class="list-group-item list-group-item-action">{{ item.name }}</a>
    </ul>
    <form :id="formid">
        <input type="hidden" id="id" name="id" v-model="form.id">
        <newinput label="Nome" name="name" v-on:onerror="form.errors.record($event)" v-bind:inputData.sync="form.name" class="mt-4"></newinput>
        <newinput label="Descrição" name="description" v-on:onerror="form.errors.record($event)" v-bind:inputData.sync="form.description"></newinput>
        <uploadfile id="image" v-bind:src.sync="form.image"></uploadfile>
        
        <div class="d-flex justify-content-between">
            <div class="p-2"><button @click="save()" type="button" class="btn btn-primary">Salvar</button></div>
            <div class="p-2"><button @click="reset()" type="button" class="btn btn-primary">Limpar</button></div>
            <div class="p-2"><button @click="excluir()" type="button" class="btn btn-primary">Deletar</button></div>
        </div>
        <newmodal v-bind:label.sync="modal.label" v-bind:title.sync="modal.title" v-bind:body.sync="modal.body"></newmodal>
    </form>
</div>
</template>

<script>
import newinput from './Input.vue';
import uploadfile from './Upload-file.vue';
import newmodal from './Modal.vue';
export default {
    props: ['cards', 'formid'],
    data() {
        return {
            newcards : [],
            form: new Form({
                id: '',
                name: '',
                description: '',
                image: ''
            }),
            modal: {
                label: 'modal1',
                title: '',
                body: ''
            }            
        }
    },
    mounted(){
        this.newcards = JSON.parse(this.cards);
    },
    methods: {
        showItem(item) {
            this.form.id = item.id;
            this.form.name = item.name;
            this.form.description = item.description;
            this.form.image = item.image;
        },
        save() {
            this.form.post('/cards/store')
            .then(res => {
            switch (res.erro) {
                case false:
                    this.modal.title = "Sucesso";
                    this.modal.body = "Salvo com sucesso!";
                    this.modal.label = "modal1";
                    $('#modal1').modal('show');

                    this.reset('form1');
                    this.form.get('/cards/list').then(
                        response => {
                            this.newcards = response;
                        }
                    );
                    
                    break;
                }
            }) 
        },
        reset() {
            this.form.reset(this.formid)                 
        },
        excluir() {
            this.form.excluir('/cards/delete')
            .then(res => {
            switch (res.erro) {
                case false:
                    this.modal.title = "Sucesso";
                    this.modal.body = "Excluído com sucesso!";
                    this.modal.label = "modal1";
                    $('#modal1').modal('show');

                    this.reset('form1');
                    this.form.get('/cards/list').then(
                        response => {
                            this.newcards = response;
                        }
                    );
                    
                    break;
                }
            })             
        }
    },
    components: {
        'newinput' : newinput,
        'uploadfile' : uploadfile,
        'newmodal' : newmodal
    }
}
</script>
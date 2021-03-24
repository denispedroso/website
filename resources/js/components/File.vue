<template>
    <div class="container">
        <div v-for="(item, key) in items" :key="`item-${key}`">
            <input name="item_image" type="file" @change="onFileChange(item, $event)" accept="image/*" capture>
            <button @click="removeImage(item)">Remover imagem</button>
            <div class="container">
                <img :src="item.image" class="rounded">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['actualimage'],
        data() {
            return {
                items: [
                    {
                        image: false,
                    }
                ]
            }
        },
        methods: {
            onFileChange(item, e) {
                var files = e.target.files || e.dataTransfer.files;
                
                if (!files.length)
                    return;
                this.createImage(item, files[0]);
            },
            createImage(item, file) {
                var image = new Image();
                var reader = new FileReader();

                reader.onload = (e) => {
                    item.image = e.target.result;
                    
                };
                reader.readAsDataURL(file);
            },
            removeImage: function (item) {
                item.image = false; 
            }
        },
        mounted(){
            this.items[0].image = '../../' + this.actualimage;
        }
    }
</script>

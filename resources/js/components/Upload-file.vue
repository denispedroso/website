<template>
<div>
  <input type="file" @change="onFileChange" :id="id" :name="id" accept="image/*">

  <div id="preview">
    <img v-if="url" :src="url" />
  </div>
</div>
</template>

<script>
export default {
    props: ['id', 'src'],
    data() {
        return {
            url: null,
        }
    },
    methods: {
        onFileChange(e) {
            const file = e.target.files[0];
            this.url = URL.createObjectURL(file);
        }
    },
    watch: {
        src: function (val) {
            this.url = "../../" + val;
    }, 
    },
}
</script>

<style>
#preview {
  display: flex;
  justify-content: center;
  align-items: center;
}

#preview img {
  max-width: 100%;
  max-height: 500px;
}
</style>
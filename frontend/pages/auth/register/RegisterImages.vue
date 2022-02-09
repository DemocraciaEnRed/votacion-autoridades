<template>
  <form class="box is-medium">
    <div class="box-inner">
      <h2 class="subtitle has-text-primary">Carga tu identificación para comprobar tus datos</h2>
      <p class="mb-6">
        Puedes hacer click en “Cargar Imagen” o arrastar la imagen hasta el campo.<br />
        <strong>El peso no debe exeder los 3MB. Formato recomendando: 1920x1080.</strong>
      </p>
      <div class="columns">
        <!--
        //# Frente -->
        <div class="column is-6-tablet">
          <h2 class="subtitle">Frente del documento</h2>
          <b-field>
            <b-upload v-model="auth.form.images.front" drag-drop :class="auth.form.images.front ? 'is-preview' : ''">
              <section v-if="!auth.form.images.front" class="upload-label">
                <icon icon="upload" size="3x" />
                <p>Cargar Imagen</p>
              </section>

              <div class="upload-preview" v-if="auth.form.images.front">
                <button type="button" class="delete" @click.prevent="auth.form.images.front = null" />
                <img class="upload-preview-img" :src="frontUrl" alt="Frente del documento" />
              </div>
            </b-upload>
          </b-field>
        </div>
        <!--
        //# Dorso -->
        <div class="column is-6-tablet">
          <h2 class="subtitle">Dorso del documento</h2>
          <b-field>
            <b-upload v-model="auth.form.images.back" drag-drop :class="auth.form.images.back ? 'is-preview' : ''">
              <section v-if="!auth.form.images.back" class="upload-label">
                <icon icon="upload" size="3x" />
                <p>Cargar Imagen</p>
              </section>

              <div class="upload-preview" v-if="auth.form.images.back">
                <button type="button" class="delete" @click.prevent="auth.form.images.back = null" />
                <img class="upload-preview-img" :src="backUrl" alt="Dorso del documento" />
              </div>
            </b-upload>
          </b-field>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
export default {
  name: 'RegisterImages',
  data() {
    return {
      loading: false,
    };
  },
  computed: {
    auth() {
      return this.$store.state.auth;
    },
    frontUrl() {
      return URL.createObjectURL(this.auth.form.images.front);
    },
    backUrl() {
      return URL.createObjectURL(this.auth.form.images.back);
    },
  },
};
</script>

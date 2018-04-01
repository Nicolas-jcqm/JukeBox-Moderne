<template>
  <div>
    <div>
      <b-jumbotron bg-variant="info" text-variant="white" header="Jukebox moderne" lead="Admin application" >
        <b-button v-on:click="logout()" variant="outline-danger">Log out</b-button>

      </b-jumbotron>
    </div>

    <b-container>
      <b-row>
          <b-col>
            <h1>Votre bibliothèque</h1>
            {{this.biblio}}
            <draggable v-model="biblio" class="dragArea" :options="{group:'jukebox'}">
              <div v-for="element in biblio">
                <b-card img-src="https://placekitten.com/1000/300"
                        img-alt="Card image"
                        img-top>
                  <p class="card-text">
                    {{element.Title}}
                  </p>
                </b-card>
              </div>
            </draggable>
          </b-col>
          <b-col>
            <h1>Notre catalogue</h1>
            {{this.catalog}}
            <draggable v-model="catalog" class="dragArea" :options="{group:'jukebox'}">
              <div v-for="element in catalog">{{element.Title}}</div>
            </draggable>
          </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
  import api from '../api'
  import draggable from 'vuedraggable'
  export default {
    name: 'catalog',
    components: {
      draggable,
    },
    data () {
      return {
        biblio: [],
        catalog: []
      }
    },
    created(){
      //récupération de la blibliothèque de ce jukebox
     let token = this.$route.params.tokenJukebox;
      api.get('jukebox/'+token+'/library/tracks').then(response =>{
        this.biblio = response.data;
      }).catch(error => {
        console.log(error)
      });
      //récuperation du catalogue
     api.get('trackCatalog').then(response =>{
       this.catalog = response.data;
     }).catch(error => {
       console.log(error)
     })



    }
  }

</script>


<style>
  .h1{
    margin-bottom: 4%;
  }
</style>



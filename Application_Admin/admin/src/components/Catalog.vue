<template>
  <div>
    <div>
      <b-jumbotron bg-variant="info" text-variant="white" header="Jukebox moderne" lead="Admin application" >
        <b-button v-on:click="logout()" variant="outline-danger">Log out</b-button>

      </b-jumbotron>
    </div>

    <b-container>
      <b-alert class="text-center" show variant="info">IMPORTANT : Ajouter votre musique à la fin de la liste</b-alert>
      <b-row>
          <b-col>
            <h1>Votre bibliothèque</h1>
            <draggable style="height:30px;" v-model="biblio" @add="onAdd" class="dragArea" :options="{group:'jukebox'}">
              <div v-for="(element,index) in biblio" :key="element.idTrack">
                <b-card style="max-width: 50%"
                        img-src="https://placekitten.com/1000/300"
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
            <draggable v-model="catalog" @add="onAdd" class="dragArea" :options="{group:'jukebox'}">
              <div v-for="element in catalog">{{element.Title}}</div>
            </draggable>
          </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
  import api from '../api'
  import ls from 'local-storage'
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



    },

    methods :{
      logout() {
        api.get('admin/logout').then(response => {
          console.log('deco')
          ls.remove('token')
          ls.remove('administratorJukebox')

          this.$router.push({
            name: "signin"
          })
        }).catch(error => {
          console.log(error)
        })
      },
      onAdd(evt) {

       let idTrack =this.biblio[(this.biblio.length)-1].idTrack;
       let admin =ls.get('administratorJukebox');
       let idJukebox = this.$route.params.tokenJukebox;

       let data = {"tokenJukebox": idJukebox, "idTrack":idTrack};
       console.log(data);

        this.$store.dispatch('jukebox/addTrackPlaylist', data).then(response => {
          console.log('cest passe!');
        })



      },

    }
  }

</script>


<style>
  .h1{
    margin-bottom: 4%;
  }
</style>



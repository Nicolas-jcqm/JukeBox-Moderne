<template>
  <div>
    <div>
      <b-jumbotron bg-variant="info" text-variant="white" header="Jukebox moderne" lead="Admin application" >
        <b-button v-on:click="logout()" variant="outline-danger">Log out</b-button>

      </b-jumbotron>
    </div>
    <b-container>
      <b-row>
        <h1>Youre jukeboxs</h1>

        <b-button class="btnCode" v-on:click="showCode()" variant="outline-info">
          Voir les codes
        </b-button>
      </b-row>

    <b-row class="containerRow">
      <div v-for="j in jukeboxs">
        <p v-if="j.nameJukebox == undefined">Sorry, there is no jukebox here !</p>
        <div v-else>
          <b-col>
          <b-card :title="j.nameJukebox"
                  img-src="https://lorempixel.com/600/300/food/5/"
                  img-alt="Image"
                  img-top
                  tag="article"
                  style="max-width: 20rem;"
                  class="mb-2">
            <p class="card-text">
              {{j.description}}
            </p>
            <b-button v-on:click="goCatalogu(j.tokenJukebox)" variant="info">See playlist</b-button>
            <b-alert
                    :show="show"
                     dismissible
                     variant="success"
                     class="text-center alertCode">
              {{j.tokenJukebox}}
            </b-alert>
          </b-card>
          </b-col>
        </div>

      </div>

    </b-row>
      </b-container>

  </div>
</template>

<script>
  import api from '../api'
  import ls from 'local-storage'


  export default {

    data () {
      return{
        jukeboxs:[],
        show: false
      }
    },
    created(){
      api.get('jukeboxs/'+ls.get('administratorJukebox')).then(response => {
        console.log('ok',JSON.parse(JSON.stringify(response.data)))
        this.jukeboxs= JSON.parse(JSON.stringify(response.data));
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
      goCatalogu(token){
        this.$router.push({
          name: "catalog",
          params: {
                    tokenJukebox:token
                  }
        })
      },
      showCode(){
        this.show=!this.show;
      }
    }

  }

</script>


<style>
  .h1{
    margin: 4% 4%;
  }
  .btnCode{
    margin-bottom: 4%;
    margin-left: 2%;
  }
  .alertCode{
    margin-top: 2%;
    margin-bottom: 4%;
    margin-left: 2%;
  }
.containerRow{
  margin-left:3%;
}

</style>

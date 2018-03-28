<template>
	<div>
    <div>
      <b-jumbotron bg-variant="info" text-variant="white" header="Jukebox moderne" lead="Admin application" >
      </b-jumbotron>
    </div>
    <div>
        <form @submit.prevent="logout()" class="form-sign">
            <input class="buttons" type="submit" value="logout !"/>
        </form>

      <b-container class="bv-example-row">
        <b-row>
          <b-col>
            <h1 class="h1">About us</h1>
            <p>
              Here is a web application, where you can find all your jukebox. You can also create new jukebox.
            </p>
            <p>
              You will be able to administer your jukeboxes, by adding new musics which you will find in our catalog.
            </p>
            <b-button v-on:click="goHistory" variant="info">See your jukebox</b-button>
          </b-col>

          <b-col>
            <h1  class="h1">Create your jukebox</h1>
            <b-form @submit="onSubmit" @reset="onReset" v-if="show">
              <b-form-group id="InputGroup1"
                            label="Jukebox Name"
                            label-for="jukeboxName">
                <b-form-input id="jukeboxName"
                              type="text"
                              v-model="form.nameJukebox"
                              required
                              placeholder="Enter a name for your jukebox ..">
                </b-form-input>
              </b-form-group>
              <b-form-group id="InputGroup2"
                            label="Description"
                            label-for="description">
                <b-form-input id="description"
                              type="text"
                              v-model="form.descriptionJukebox"
                              required
                              placeholder="Enter a description ..">
                </b-form-input>
              </b-form-group>
              <b-button type="submit" variant="info">Submit</b-button>
              <b-button type="reset" variant="outline-danger">Reset</b-button>
            </b-form>
          </b-col>
        </b-row>
      </b-container>


    </div>
	</div>
</template>

<script>
    import api from '../api'
    import ls from '@/services/ls'

    export default {
        data() {
            return {
                form: {
                    administratorJukebox: 'session',
                    nameJukebox: '',
                    descriptionJukebox: ''
                },
                show: true
            }
        },
        methods: {
            onSubmit(evt) {
                let data = JSON.stringify(this.form);
                console.log(data);
                this.$store.dispatch('jukebox/createJukebox', data).then(response => {
                    console.log('cest passe!');
                })

                evt.preventDefault();

            },
            onReset(evt) {
                evt.preventDefault();
                /* Reset our form values */
                this.form.nameJukebox = '';
                this.form.descriptionJukebox = '';
                /* Trick to reset/clear native browser form validation state */
                this.show = false;
                this.$nextTick(() => {
                    this.show = true
                });
            },
            goHistory() {

                this.$router.push({
                    name: "history"
                })
            },
            
            logout() {
                api.get('admin/logout').then(response => {
                    console.log('deco')
                    ls.remove('token')
                    this.$router.push({
                        name: "signin"
                    })
                }).catch(error => {
                    console.log(error)
                })
            }
        }
    }

</script>


<style>
    .h1 {
        margin-bottom: 4%;
    }

</style>

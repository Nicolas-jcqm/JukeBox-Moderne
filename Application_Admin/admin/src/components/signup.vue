<template>
	<div class="back">
        <!--<div class="login">-->
    <div>
      <b-jumbotron bg-variant="info" text-variant="white" header="Jukebox moderne" lead="Admin application" >
      </b-jumbotron>
    </div>
            <h1 class="h1">Sign up</h1>

          <b-container>
                <b-form @submit.prevent="signup()">
                  <p class="red" v-if="erreur === true">Veuillez verifier vos information</p>
                  <b-form-group id="InputGroup1"
                                class="text-center"
                                label="Name"
                                label-for="name">
                    <b-form-input id="name"
                                  type="text"
                                  v-model="user.name"
                                  required
                                  placeholder="Enter your name .."
                                  class="text-center">
                    </b-form-input>
                  </b-form-group>
                  <b-form-group id="InputGroup1"
                                class="text-center"
                                label="First Name"
                                label-for="firstname">
                    <b-form-input id="firstname"
                                  class="text-center"
                                  type="text"
                                  v-model="user.firstname"
                                  required
                                  placeholder="Enter your firstname ..">
                    </b-form-input>
                  </b-form-group>
                  <b-form-group id="InputGroup1"
                                class="text-center"
                                label="E-mail"
                                label-for="mail">
                    <b-form-input id="mail"
                                  class="text-center"
                                  type="text"
                                  v-model="user.mail"
                                  required
                                  placeholder="Enter your email ..">
                    </b-form-input>
                  </b-form-group>
                  <b-form-group id="InputGroup1"
                                class="text-center"
                                label="Password"
                                label-for="password">
                    <b-form-input id="password"
                                  type="password"
                                  class="text-center"
                                  v-model="user.password"
                                  required
                                  placeholder="Enter a name ..">
                    </b-form-input>
                  </b-form-group>

                  <div class="text-center" style="margin: 1% auto">
                  <b-button class="center btn-primary btn-lg" type="submit" variant="info">Submit</b-button>
                  </div>
                </b-form>
            <div class="text-center" style="margin: 1% auto">
                <p>Vous êtes déjà inscrit, vous pouvez desapresent vous connecter.</p>
                <b-button class="center btn-primary btn-lg" v-on:click="signin()" variant="info">Sign in</b-button>
            </div>

          </b-container>




          <!--<form @submit.prevent="signin()" class="form-sign">
            <input class="buttons" type="submit" value="Signin"/>
          </form>-->

       <!-- </div> -->
	</div>
</template>

<script>
    import api from '../api'
    import ls from '@/services/ls'

    export default {
        data() {
            return {
                erreur: false,
                user: {
                    mail: "",
                    password: "",
                    name: "",
                    firstname: ""
                }
            }
        },
        methods: {
            signup() {
                let json = {
                    mail: this.user.mail,
                    password: this.user.password,
                    name: this.user.name,
                    firstname: this.user.firstname
                }
                ls.remove('token')
                api.post('/admin/signup', json).then(response => {
                    alert('Vous avez bien éte enregistré, vous allez etre redirigé vers la page de login')
                    this.$router.push({
                        name: "signin"
                    })
                }).catch(error => {
                    this.erreur = true
                    console.log(error)
                })
            },
            signin(){
                this.$router.push({
                    name: "signin"
                })
            }
        }
    }

</script>


<style>
  .h1 {
    margin-bottom: 4%;
    margin-left: 2%;
  }
    .login {
        margin-top: 100px;
        margin-left: auto;
        margin-right: auto;
        width: 30%;
        text-align: center;
        background-color: lightblue;
        padding: 40px;
        border-radius: 20px 20px 20px 20px;
    }

    html body {
        background-color: whitesmoke;
    }

    .form-sign>div>label {
        width: 100%;
    }

    .form-sign>div>input {
        width: 100%;
        text-align: center;
        justify-content: center;
        margin: auto;
    }

    .buttons {
        margin-top: 9px;
    }

    .red{
        color: indianred;
    }

</style>

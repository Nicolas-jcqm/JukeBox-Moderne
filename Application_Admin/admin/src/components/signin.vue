<template>
	<div class="back">
    <div>
      <b-jumbotron bg-variant="info" text-variant="white" header="Jukebox moderne" lead="Admin application" >
      </b-jumbotron>
    </div>

    <h1 class="h1">Signin</h1>
          <b-container>
            <b-form @submit.prevent="signin()">
              <p class="red" v-if="erreur === true">Veuillez verifier vos information</p>
              <b-form-group id="InputGroup1"
                            class="text-center"
                            label="Email"
                            label-for="email">
                <b-form-input id="email"
                              type="text"
                              v-model="user.mail"
                              required
                              placeholder="Enter your email .."
                              class="text-center">
                </b-form-input>
              </b-form-group>
              <b-form-group id="InputGroup1"
                            class="text-center"
                            label="Password"
                            label-for="password">
                <b-form-input id="password"
                              class="text-center"
                              type="password"
                              v-model="user.password"
                              required
                              placeholder="Enter your password ..">
                </b-form-input>
              </b-form-group>

              <div class="text-center" style="margin: 1% auto">
              <b-button class="text-center btn-primary btn-lg" type="submit" variant="info">Submit</b-button>
              </div>
            </b-form>

            <div class="text-center" style="margin: 1% auto">
              <p>Vous n'êtes pas encore inscrit, vous pouvez dès à présent vous connecter.</p>
              <b-button class="btn-primary btn-lg" v-on:click="signup()" variant="info">Sign up</b-button>
            </div>

          </b-container>
          <!--
            <form @submit.prevent="signin()" class="form-sign">
                <p class="red" v-if="erreur === true">Veuillez verifier vos information</p>
                <div>
                    <label for="email">Email</label>
                    <input v-model="user.mail" id="email" />
                </div>
                <div>
                    <label for="email">Password</label>
                    <input type="password" v-model="user.password" id="password" />
                </div>
                <input class="buttons" type="submit" value="Go !"/>
            </form>
            <form @submit.prevent="signup()" class="form-sign">
                <input class="buttons" type="submit" value="Signup"/>
            </form>

            -->

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
                    password: ""
                }
            }
        },
        methods: {
            signin() {
                let json = {
                    mail: this.user.mail,
                    password: this.user.password
                }
                ls.remove('token')
                api.post('/admin/signin', json).then(response => {
                    ls.set('token', response.data.token)
                  ls.set('administratorJukebox', response.data.administratorJukebox)
                    this.$router.push({
                        name: "home"
                    })
                }).catch(error => {
                    this.erreur = true
                    console.log(error)
                })
            },
            signup(){
                this.$router.push({
                    name: "signup"
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

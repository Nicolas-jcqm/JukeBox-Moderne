<template>
	<div class="back">
        <div class="login">
            <h1>Signin</h1>
            <form @submit.prevent="signup()" class="form-sign">
                <p class="red" v-if="erreur === true">Veuillez verifier vos information</p>
                <div>
                    <label for="name">Nom</label>
                    <input v-model="user.name" id="email" />
                </div>
                <div>
                    <label for="firstname">Prenom</label>
                    <input v-model="user.firstname" id="prenom" />
                </div>
                <div>
                    <label for="mail">Mail</label>
                    <input v-model="user.mail" id="mail" />
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" v-model="user.password" id="password" />
                </div>
                <input class="buttons" type="submit" value="Go !"/>
            </form>
            <form @submit.prevent="signin()" class="form-sign">
                <input class="buttons" type="submit" value="Signin"/>
            </form>
        </div>
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

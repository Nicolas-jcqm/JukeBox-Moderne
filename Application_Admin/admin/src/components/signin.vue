<template>
	<div class="back">
        <div class="login">
            <h1>Signin</h1>
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
                api.post('/admin/signin', json).then(response => {
                    ls.set('token', response.data.token)
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

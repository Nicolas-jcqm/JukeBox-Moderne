import api from '@/api'
import ls from '@/services/ls'

const initialState = {
  jukebox: {}
}

export default {
  namespaced: true, //permet d'y accéder de façon nommée
  state: {
    jukebox: {}
  },
  mutations: {
    setJukebox(state, j) {
      state.jukebox = j;
    },
    addJukebox(state,j) {
      state.jukebox.push(j);
    }
  },
  getters : {
    getJukeboxs(state)  {
      return state.jukebox;
    },
  },
  actions: {
    createJukebox({
            commit
          }, jukebox) {
      return api.post('jukebox', jukebox).then(response => {
        console.log(response);
        ls.set('token', response.data.token)

        commit("addJukebox", response.data)
      }).catch(error => {
        console.log(error)
      })
      console.log('apres')
    },
    getAllJukebox({commit}){
      return api.get('jukeboxs/session').then(response => {
        commit("setJukebox", response.data)
      }).catch(error => {
        console.log(error)
      })
    }

  }
}

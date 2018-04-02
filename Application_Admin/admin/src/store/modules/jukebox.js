import api from '@/api'
import ls from '@/services/ls'

const initialState = {
  jukebox: {}
}

export default {
  namespaced: true, //permet d'y accéder de façon nommée
  state: {
    jukebox: [],
    playlist: []
  },
  mutations: {
    setJukebox(state, j) {
      state.jukebox = j;
    },
    addJukebox(state,j) {
      state.jukebox.push(j);
    },
    addTrackPlaylist(state, t){
      state.playlist.push(t);
    }
  },
  getters : {
    getJukeboxs(state)  {
      return state.jukebox;
    }
  },
  actions: {
    createJukebox({
            commit
          }, jukebox) {
      return api.post('jukebox', jukebox).then(response => {
        console.log(response);

        commit("addJukebox", response.data)
      }).catch(error => {
        console.log(error)
      })
    },
    getAllJukebox({commit}){
      return api.get('jukeboxs/session').then(response => {
        commit("setJukebox", response.data)
      }).catch(error => {
        console.log(error)
      })
    },
    addTrackPlaylist({commit}, data) {
      return api.post('jukebox/queue/track', data).then(response => {
        console.log(response);
        commit("addTrackPlaylist", response.data)
      }).catch(error => {
        console.log(error)
      });
      console.log('apres')
    }
  }
}

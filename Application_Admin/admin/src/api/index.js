import axios from 'axios'
import conf from '../config'

const api = axios.create({
	baseURL: conf.remoteUrl,
    withCredentials : true
})
export default api

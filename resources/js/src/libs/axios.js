import Vue from 'vue'

// axios
import axios from 'axios'
const apiUrl = 'api/auth/';
const axiosIns = axios.create({
  // You can add your headers here
  // ================================
  // baseURL: 'https://some-domain.com/api/',
  // timeout: 1000,
  // headers: {'X-Custom-Header': 'foobar'}

  baseURL: apiUrl,

})

 const apiService = {
  async get(endpoint, params) {
    try {
      const response = await axiosIns.get(endpoint, { params })
      return response.data
    } catch (error) {

    }
  },
  async getAll(endpoint) {

    try {
      const response = await axiosIns.get(endpoint)
      return response.data
    } catch (error) {}
  },
  async post(endpoint, formData) {
    try {
      const response = await axiosIns.post(endpoint, formData);
      return response.data;
    } catch (error) {
      
     return response.data.error;
    }
  },


}



Vue.prototype.$http = axiosIns

export default axiosIns




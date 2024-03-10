import axios from 'axios';

const instance = axios.create({
  baseURL: 'http://localhost:8000', // Change this to match your backend API URL
});

export default instance;
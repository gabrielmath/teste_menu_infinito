import axios from 'axios';

const location = window.location;

const HOST = `${location.protocol}//${location.host}`;

const api = axios.create({
    baseURL: HOST
});

export default api;
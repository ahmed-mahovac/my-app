import { AxiosInstance } from "axios";

const attachTokenInterceptor = (api: AxiosInstance) => {
    api.interceptors.request.use(
      (config) => {
        const token = localStorage.getItem('token');
  
        if (token) {
          config.headers.Authorization = `Bearer ${token}`;
        }
  
        return config;
      },
      (error) => {
        return Promise.reject(error);
      }
    );
  };
  
  export default attachTokenInterceptor;
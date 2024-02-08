import axios from "axios";
import attachTokenInterceptor from "../middleware/tokenInterceptor";
import { axiosInstance } from "./config";

attachTokenInterceptor(axiosInstance);

export type UserRegister = {
  name: string;
  email: string;
  password: string;
  confirmPassword: string;
};

export type UserLogin = {
  email: string;
  password: string;
};

export type TokenResponse = {
  message: string;
  access_token: string;
};

export type LogoutResponse = {
  message: string;
};

export const register = async (user: UserRegister) => {
  try {
    const response = await axiosInstance.post("/register", {
      ...user, c_password: user.confirmPassword,
    });
    return response.data;
  } catch (error) {
    console.error("Register error: ", error);
    throw error;
  }
};

export const login = async (user: UserLogin): Promise<TokenResponse> => {
  try {
    const response = await axiosInstance.post<TokenResponse>("/login", {
      ...user,
    });
    return response.data;
  } catch (error) {
    console.error("Login error: ", error);
    throw error;
  }
};

export const logout = async (): Promise<LogoutResponse> => {
  try {
    const response = await axiosInstance.get("/logout");
    return response.data;
  } catch (error) {
    console.error("Logout error: ", error);
    throw error;
  }
};

export const getCurrentUser = async (token: string) => {
  try {
    const response = await axiosInstance.get("/user");
    return response.data;
  } catch (error) {
    console.error("Get user error: ", error);
    throw error;
  }
};

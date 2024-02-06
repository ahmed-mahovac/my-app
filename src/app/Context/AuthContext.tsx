"use client";

import React, {
  createContext,
  useContext,
  useState,
  ReactNode,
  useEffect,
} from "react";
import {
  TokenResponse,
  UserLogin,
  UserRegister,
  login as loginAPI,
  register as registerAPI,
  logout as logoutAPI,
  getCurrentUser,
} from "../api/auth";
import { ErrorType, useException } from "./ExceptionContext";

interface User {
  email: string;
}

interface AuthContextType {
  user: User | null;
  isLoggedIn: boolean;
  login: (userData: UserLogin) => void;
  logout: () => void;
  getToken: () => string | null;
  register: (userData: UserRegister) => void;
}

const AuthContext = createContext<AuthContextType | undefined>(undefined);

interface AuthProviderProps {
  children: ReactNode;
}

export const AuthProvider: React.FC<AuthProviderProps> = ({ children }) => {
  const [user, setUser] = useState<User | null>(null);
  const [isLoggedIn, setIsLoggedIn] = useState<boolean>(false);
  const [token, setToken] = useState<string | null>(null);

  const {setException} = useException();

  useEffect(() => {
    const token = localStorage.getItem("token");
    if (token) {
      getCurrentUser(token)
        .then((user) => {
          setUser(user);
          setIsLoggedIn(true);
        })
        .catch((error) => {
          setException(error instanceof Error ? {...error, type: ErrorType.login} : {...new Error('Unknown error'), type: ErrorType.login}); // not sure if this is correct type
        });
    }
  }, []);

  const login = (user: UserLogin) => {
    loginAPI(user)
      .then((response: TokenResponse) => {
        console.log(response.message);
        setUser({ email: user.email });
        setIsLoggedIn(true);
        localStorage.setItem("token", response.access_token);
        setToken(response.access_token);
      })
      .catch((error) => {
        setException(error instanceof Error ? {...error, type: ErrorType.login} : {...new Error('Unknown error'), type: ErrorType.login});
      });
  };

  const register = (user: UserRegister) => {
    registerAPI(user)
      .then((response: TokenResponse) => {
        setUser({ email: user.email });
        setIsLoggedIn(true);
        localStorage.setItem("token", response.access_token);
        setToken(response.access_token);
      })
      .catch((error) => {
        setException(error instanceof Error ? {...error, type: ErrorType.register} : {...new Error('Unknown error'), type: ErrorType.register});
      });
  };

  const logout = () => {
    logoutAPI()
      .then(() => {
        setUser(null);
        setIsLoggedIn(false);
        localStorage.removeItem("token");
        setToken(null);
      })
      .catch((error) => {
        setException(error instanceof Error ? {...error, type: ErrorType.register} : {...new Error('Unknown error'), type: ErrorType.register});
      });
  };

  const getToken = () => {
    return localStorage.getItem("token");
  };

  const value: AuthContextType = {
    user,
    isLoggedIn,
    login,
    logout,
    getToken,
    register,
  };

  return <AuthContext.Provider value={value}>{children}</AuthContext.Provider>;
};

export const useAuth = (): AuthContextType => {
  const context = useContext(AuthContext);
  if (!context) {
    throw new Error("useAuth must be used within an AuthProvider");
  }
  return context;
};

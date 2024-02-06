"use client";

import React, { createContext, useContext, useState, ReactNode } from "react";
import {
  TokenResponse,
  UserLogin,
  UserRegister,
  login as loginAPI,
  register as registerAPI,
  logout as logoutAPI,
} from "../api";

interface User {
  email: string;
}

interface AuthContextType {
  user: User | null;
  isLoggedIn: boolean;
  login: (userData: UserLogin) => void;
  logout: () => void;
}

const AuthContext = createContext<AuthContextType | undefined>(undefined);

interface AuthProviderProps {
  children: ReactNode;
}

export const AuthProvider: React.FC<AuthProviderProps> = ({ children }) => {
  const [user, setUser] = useState<User | null>(null);
  const [isLoggedIn, setIsLoggedIn] = useState<boolean>(false);

  const login = (user: UserLogin) => {
    loginAPI(user)
      .then((response: TokenResponse) => {
        setUser({ email: user.email });
        setIsLoggedIn(true);
      })
      .catch((err) => {
        console.log(err);
      });
  };

  const register = (user: UserRegister) => {
    registerAPI(user)
      .then((response: TokenResponse) => {
        setUser({ email: user.email });
        setIsLoggedIn(true);
      })
      .catch((err) => {
        console.log(err);
      });
  };

  const logout = () => {
    logoutAPI()
      .then(() => {
        setUser(null);
        setIsLoggedIn(false);
      })
      .catch((err) => {
        console.log(err);
      });
  };

  const value: AuthContextType = {
    user,
    isLoggedIn,
    login,
    logout,
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

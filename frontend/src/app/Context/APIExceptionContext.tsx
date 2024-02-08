"use client";

import { AxiosError } from "axios";
import React, { ReactNode, createContext, useContext, useState } from "react";

interface APIExceptionContextType {
  error: ErrorWithType | null;
  setException: (error: ErrorWithType | null) => void;
}

export enum ErrorType {
  login = 'LOGIN',
  register = 'REGISTER',
  auth = 'AUTH',
};

export interface ErrorResponse {
  message?: string;
};

export interface ErrorWithType extends AxiosError<ErrorResponse> {
  type: ErrorType;
}

const APIExceptionContext = createContext<APIExceptionContextType>({
  error: null,
  setException: () => {},
});

interface ExceptionProviderProps {
  children: ReactNode;
}

export const ExceptionProvider: React.FC<ExceptionProviderProps> = ({
  children,
}) => {
  const [error, setError] = useState<ErrorWithType | null>(null);

  const setException = (error: ErrorWithType | null) => {
    setError(error);
  };

  return (
    <APIExceptionContext.Provider value={{ error, setException }}>
      {children}
    </APIExceptionContext.Provider>
  );
};

export const useException = (): APIExceptionContextType => {
  const context: APIExceptionContextType = useContext(APIExceptionContext);
  if (!context) {
    throw new Error("useException must be used within an ExceptionProvider");
  }
  return context;
};

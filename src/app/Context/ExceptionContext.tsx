"use client";

import React, { ReactNode, createContext, useContext, useState } from "react";

interface ExceptionContextType {
  error: ErrorWithType | null;
  setException: (error: ErrorWithType | null) => void;
}

export enum ErrorType {
  login = 'LOGIN',
  register = 'REGISTER',
}

export interface ErrorWithType extends Error {
  type: ErrorType;
}

const ExceptionContext = createContext<ExceptionContextType>({
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
    <ExceptionContext.Provider value={{ error, setException }}>
      {children}
    </ExceptionContext.Provider>
  );
};

export const useException = (): ExceptionContextType => {
  const context: ExceptionContextType = useContext(ExceptionContext);
  if (!context) {
    throw new Error("useException must be used within an ExceptionProvider");
  }
  return context;
};

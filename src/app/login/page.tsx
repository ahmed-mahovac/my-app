"use client";

import { useState } from "react";
import InputField from "../../components/InputField";
import { useAuth } from "../Context/AuthContext";
import Error from "@/components/Error";
import { ErrorType, useException } from "../Context/APIExceptionContext";

export default function Login() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");

  const { login } = useAuth();
  const { error } = useException();

  const handleSubmit = (e) => {
    e.preventDefault();
    console.log("Login with:", { email, password });
    login({ email, password });
  };

  return (
    <div className="flex items-center justify-center h-screen">
      <form
        className="bg-white p-8 rounded shadow-md w-full max-w-md"
        onSubmit={handleSubmit}
      >
        <h2 className="text-2xl font-semibold mb-6">Login</h2>

        <InputField
          label="Email"
          type="email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
          placeholder="Enter your email"
          required
        />

        <InputField
          label="Password"
          type="password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
          placeholder="Enter your password"
          required
        />

        <div className="mb-6">
          <button
            type="submit"
            className="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue"
          >
            Login
          </button>
        </div>
        {error && error.type === ErrorType.login && (
          <Error
            message={
              error.response?.data?.message
                ? error.response?.data?.message
                : error.message
            }
          />
        )}
        <p className="text-sm text-gray-600">
          Don't have an account? <a href="/register">Sign up</a>.
        </p>
      </form>
    </div>
  );
}

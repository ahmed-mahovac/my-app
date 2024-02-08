"use client";

import { useAuth } from '@/app/Context/AuthContext';

const Header = () => {

    const { isLoggedIn, logout, user } = useAuth();

  const handleLogout = () => {
    logout();
  };

  return (
    <nav className="bg-gray-800 p-4">
      <div className="container mx-auto flex justify-between items-center">
        <div className="text-white text-xl font-bold">Products</div>
        <div className="flex items-center">
          {isLoggedIn ? (
            <>
              <p className="text-white mr-4">Welcome, {user?.email}!</p>
              <button
                className="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded"
                onClick={handleLogout}
              >
                Logout
              </button>
            </>
          ) : (
            <>
              <a className="text-white mr-4" href="/login">
                Login
              </a>
              <a className="text-white" href="/register">
                Register
              </a>
            </>
          )}
        </div>
      </div>
    </nav>
  );
};

export default Header;
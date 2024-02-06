"use client";

import { useAuth } from "@/app/Context/AuthContext";
import { useRouter } from "next/navigation";
import { useEffect } from "react";

export default function withAuth(WrappedComponent: React.ComponentType) {
  return (props: any) => {
    const router = useRouter();
    const { isLoggedIn, isLoading } = useAuth();

    useEffect(() => {
      if (!isLoggedIn && !isLoading) {
        router.push("/login");
      }
    }, [isLoading, isLoggedIn, router]);

    if (!isLoggedIn) {
      return <div>Loading...</div>;
    }

    return <WrappedComponent {...props} />;
  };
}

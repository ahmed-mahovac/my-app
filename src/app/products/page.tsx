"use client";

import { useEffect, useState } from "react";
import Link from "next/link";
import axios from "axios";
import { ProductResponse, getProducts } from "../api/products";
import withAuth from "@/components/WithAuth";
import Product from "@/components/Product";

const ProductsList = () => {
  const [searchTerm, setSearchTerm] = useState<string>("");
  const [filteredProducts, setFilteredProducts] = useState<
    Array<ProductResponse>
  >([]);

  useEffect(() => {
    getProducts({})
      .then((data: Array<ProductResponse>) => setFilteredProducts(data))
      .catch((error) => {
        console.error("Error fetching products: ", error);
      });
  }, []);

  const handleSearch = async () => {
    try {
      const data = await getProducts({ name: searchTerm });
      setFilteredProducts(data);
    } catch (error) {
      console.error("Error fetching filtered products:", error);
    }
  };

  const handleChange = (event) => {
    setSearchTerm(event.target.value);
  };

  return (
    <div className="container mx-auto px-4">
      <h1 className="text-2xl font-bold mt-8 mb-4">Products List</h1>
      <div className="mb-4">
        <input
          type="text"
          placeholder="Search products"
          value={searchTerm}
          onChange={handleChange}
          className="px-4 py-2 border border-gray-300 rounded-md w-full"
        />
        <button
          onClick={handleSearch}
          className="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
        >
          Search
        </button>
      </div>
      <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        {filteredProducts.map((product: ProductResponse) => (
          <Product key={product.product_id} product={product} />
        ))}
      </div>
    </div>
  );
};

export default ProductsList;

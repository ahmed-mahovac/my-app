"use client";

import { ProductResponse, getProduct } from "@/app/api/products";
import { useParams } from "next/navigation";
import { useEffect, useState } from "react";

const ProductDetails = () => {
  const params = useParams<{ productId: string }>();

  const productId = parseInt(params.productId);

  const [product, setProduct] = useState<ProductResponse | null>(null);

  useEffect(() => {
    fetchProduct(productId);
  }, []);

  return (
    <div className="container mx-auto p-4">
      <div className="bg-white rounded-lg shadow-md p-8">
        <div className="flex flex-col lg:flex-row">
          <div className="lg:w-1/2 lg:pr-8">
            <img
              src={"/placeholder-image.jpg"} // Placeholder image
              alt={product?.name}
              className="w-full rounded-lg mb-4"
            />
          </div>
          <div className="lg:w-1/2">
            <h1 className="text-3xl font-semibold mb-4">{product?.name}</h1>
            <p className="text-gray-700 mb-4">{product?.description}</p>
            <p className="text-gray-700 font-semibold mb-4">${product?.price}</p>
            {/* Add more details as needed */}
          </div>
        </div>
        <div className="mt-8">
          <h2 className="text-xl font-semibold mb-4">Variants</h2>
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            {/*product.variants.map((variant, index) => (
              <div key={index} className="bg-white rounded-md shadow-md p-4">
                <h2 className="text-lg font-semibold">{variant.name}</h2>
                <p className="text-gray-600">{variant.description}</p>
                <p className="text-gray-700 font-semibold mt-2">
                  ${variant.price}
                </p>
              </div>
            ))*/}
          </div>
        </div>
      </div>
    </div>
  );

  async function fetchProduct(productId: number) {
    try {
      const data = await getProduct(productId);
      setProduct(data);
    } catch (error) {
      console.error("Error fetching product details: ", error);
    }
  }
};

export default ProductDetails;

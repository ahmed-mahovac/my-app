import { ProductResponse } from '@/app/api/products';
import Link from 'next/link';

interface ProductProps {
  product: ProductResponse;
}

const Product: React.FC<ProductProps> = ({ product }) => {
  return (
    <div className="bg-white rounded-md shadow-md p-4">
      <h2 className="text-lg font-semibold">{product.name}</h2>
      <p className="text-gray-600">{product.description}</p>
      <p className="text-gray-700 font-semibold mt-2">${product.price}</p>
      <p className="text-gray-700 mt-1">
        Product type: {product.product_type.name}
      </p>
      <Link legacyBehavior href={`/products/${product.product_id}`}>
        <a className="mt-4 inline-block px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
          View Details
        </a>
      </Link>
    </div>
  );
};

export default Product;
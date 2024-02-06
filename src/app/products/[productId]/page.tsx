export default function ProductDetails({params}: {
    params: {
        productId: string;
    };
    
}) {
  return <div>productDetails {params.productId}</div>;
}
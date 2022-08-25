import React from 'react';
import ProductsList from './ProductsList';

const ProductContent = ({ products, handleDelete, departments }) => {
  const defaultListDisplay = 'La liste est vide.';

  return (
    <section data-testid='products'>
      {products.length ? (
        <ProductsList
          products={products}
          handleDelete={handleDelete}
          departments={departments}
        />
      ) : (
        <p style={{ marginTop: '2rem' }}>{defaultListDisplay}</p>
      )}
    </section>
  );
}

export default ProductContent

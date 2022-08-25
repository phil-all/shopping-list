import React from 'react';
import ProductListItem from './ProductListItem';

const ProductsList = ({ products, handleDelete, departments }) => {
    return (
        <ul className='list-group my-3'>
            {products.map((product) => (
                <ProductListItem
                    key={product.id}
                    product={product}
                    handleDelete={handleDelete}
                    departments={departments}
                />
            ))}
        </ul>
    );
}

export default ProductsList

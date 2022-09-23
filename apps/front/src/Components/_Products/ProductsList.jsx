import React from 'react';
import ProductListItem from './ProductListItem';

const ProductsList = ({ products, handleDelete}) => {
    return (
        <ul className='list-group my-3'>
            {products.map((product) => (
                <ProductListItem
                    key={product.id}
                    product={product}
                    handleDelete={handleDelete}
                />
            ))}
        </ul>
    );
}

export default ProductsList

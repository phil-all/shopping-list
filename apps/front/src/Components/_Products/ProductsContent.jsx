import ProductsList from './ProductsList';

const ProductContent = ({ products, handleCheck, handleDelete }) => {
  const defaultListDisplay = 'La liste est vide.';

  return (
    <section data-testid='products'>
      {products.length ? (
        <ProductsList
          products={products}
          handleCheck={handleCheck}
          handleDelete={handleDelete}
        />
      ) : (
        <p style={{ marginTop: '2rem' }}>{defaultListDisplay}</p>
      )}
    </section>
  )
}

export default ProductContent

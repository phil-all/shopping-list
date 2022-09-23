import React from 'react'
import SelectedProductsList from './_SelectedProducts/SelectedProductsList'

const SelectedProducts = ({ items, handleDeleteItem, handleQuantity }) => {
  return (
    <div
      className='container'
      data-testid='selected_product_list'
    >
      {
        <SelectedProductsList
          items={items}
          handleDeleteItem={handleDeleteItem}
          handleQuantity={handleQuantity}
        />
      }
    </div>
  )
}

export default SelectedProducts
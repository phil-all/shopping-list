import React from 'react'
import SearchResultsList from './_SearchResults/SearchResultsList';

const SearchResults = ({ products, searchItem, handleSubmitRegistredProduct }) => {
  const searchResults = products.filter(value => value.name.toLowerCase().includes(searchItem));

  return (
    <>
      <SearchResultsList
        searchResults={searchResults}
        handleSubmitRegistredProduct={handleSubmitRegistredProduct}
      />
    </>
  )
}

export default SearchResults
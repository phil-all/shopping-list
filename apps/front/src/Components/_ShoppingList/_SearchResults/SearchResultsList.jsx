import React from 'react';
import SearchResultsListItem from './SearchResultsListItem';

const SearchResultsList = ({ searchResults, handleSubmitRegistredProduct }) => {
	return (
		<div className='container'>
			<ul className='list-group my-3'>
				{searchResults.map((product) => (
					<SearchResultsListItem
						key={product.id}
						product={product}
						handleSubmitRegistredProduct={handleSubmitRegistredProduct}
					/>
				))}
			</ul>
		</div>
	);
}

export default SearchResultsList
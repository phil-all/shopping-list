import Products from '../Components/Products';
import "@testing-library/jest-dom/extend-expect";
import {BrowserRouter as Router} from 'react-router-dom';
import { render, screen, cleanup } from '@testing-library/react';

test('should render products component', () => {
    render(
      <Router>
        <Products />,
      </Router>,
    );
  
    const title = screen.getByTestId('title');
    expect(title).toBeInTheDocument();
  
    const newProductInput = screen.getByTestId('new_product');
    expect(newProductInput).toBeInTheDocument();
  
    const newProductInputPlaceholder = screen.queryByPlaceholderText('nouveau produit');
    expect(newProductInputPlaceholder).toBeInTheDocument();
  
    const addButton = screen.getByTestId('add');
    expect(addButton).toBeInTheDocument();

    const departments = screen.getByLabelText('departments');
    expect(departments).toBeInTheDocument();

    const productList = screen.getByTestId('products');
    expect(productList).toBeInTheDocument();
  });

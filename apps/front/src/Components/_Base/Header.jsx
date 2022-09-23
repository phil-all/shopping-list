import React from 'react';
import { Link } from 'react-router-dom';
import { BsCart4 } from 'react-icons/bs';

const Header = ({ title }) => {
  return (
    <header className='bg-primary'>
      <div className='container d-flex'>
        <div className='d-flex my-auto'>
        <Link to='/'>
          <BsCart4 className='svg-header text-white'/>
        </Link>
          
        </div>
        <div style={{width: '100%'}}>
        <h1 
          className='my-auto py-4 text-center'
          data-testid='title'
        >
          &nbsp;{title}
        </h1>
        </div>
      </div>
    </header>
  );
}

Header.defaultProps = {
  title: "Shopping List"
}

export default Header;

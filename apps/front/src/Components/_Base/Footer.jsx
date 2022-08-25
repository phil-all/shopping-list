import React from 'react';

const Footer = ({ length }) => {
  return (
    <footer className='p-3 bg-primary'>
      <div className='d-flex justify-content-center'>
        <a href="https://gitlab.com/phil-all/shopping-list">
          <button className="btn btn-sm">
            contributing
          </button>
        </a>
      </div>
    </footer>
  );
}

export default Footer

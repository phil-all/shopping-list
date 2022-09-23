/**
 * Return headers to set a request with JWT token.
 * 
 * @returns json
 */
const headers = (token) => {

  return {
    headers: {
      'Content-Type': 'application/json',
      'Authorization': 'Bearer ' + token
    }
  }
}

export { headers };

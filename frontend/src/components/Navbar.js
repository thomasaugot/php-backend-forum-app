import React from "react";
import { Link } from "react-router-dom";

const Navbar = () => {
  return (
    <nav className="bg-blue-600 p-4">
      <ul className="flex space-x-4">
        <li>
          <Link to="/" className="text-white">
            Home
          </Link>
        </li>
        <li>
          <Link to="/register" className="text-white">
            Register
          </Link>
        </li>
        <li>
          <Link to="/login" className="text-white">
            Login
          </Link>
        </li>
        <li>
          <Link to="/posts" className="text-white">
            Posts
          </Link>
        </li>
        <li>
          <Link to="/create-post" className="text-white">
            Create Post
          </Link>
        </li>
      </ul>
    </nav>
  );
};

export default Navbar;

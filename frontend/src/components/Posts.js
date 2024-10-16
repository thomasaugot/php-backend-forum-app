import React, { useEffect, useState } from "react";

const Posts = () => {
  const [posts, setPosts] = useState([]);

  //   useEffect(() => {
  //     const fetchPosts = async () => {
  //       const response = await fetch("http://localhost:8000/api/posts");
  //       const data = await response.json();
  //       setPosts(data.posts);
  //     };
  //     fetchPosts();
  //   }, []);

  return (
    <div>
      <h1 className="text-2xl">Posts</h1>
      <ul className="space-y-2">
        {posts.map((post) => (
          <li key={post.id} className="border p-2">
            <h2 className="font-bold">{post.title}</h2>
            <p>{post.content}</p>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default Posts;

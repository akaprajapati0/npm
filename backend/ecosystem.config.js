module.exports = {
  apps: [
    {
      name: "ik_server",
      script: "dist/server.js",
      exec_mode: "fork",
      watch: false,
      autorestart: true,
      max_restarts: 5,
      env: {
        NODE_ENV: "production"
      }
    }
  ]
};

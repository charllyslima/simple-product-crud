#!/bin/sh

echo "Starting docker-entrypoint.sh script..."

echo "Removing node_modules and package-lock.json if they exist..."
rm -rf node_modules package-lock.json

echo "Installing dependencies..."
npm install

echo "Listing installed packages..."
ls -l node_modules

echo "Starting Vite server..."
exec npm run dev
#!/bin/sh

echo "Starting docker-entrypoint.sh script..."

echo "Removing package-lock.json if they exist..."
rm -rf package-lock.json

echo "Installing dependencies..."
npm install

echo "Listing installed packages..."
ls -l node_modules

echo "Starting Vite server..."
exec npm run dev
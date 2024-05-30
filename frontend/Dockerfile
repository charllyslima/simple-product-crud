FROM node:20.14.0

# Set working directory
WORKDIR /src

# Install Vue CLI
RUN npm install -g @vue/cli

# Copy entrypoint script
COPY ./docker/docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Copy package.json and package-lock.json if they exist
COPY package*.json ./

# Install dependencies
RUN npm install

# Copy the rest of the application code
COPY . .

# Expose port
EXPOSE 8080

# Use entrypoint script
ENTRYPOINT ["./docker/docker-entrypoint.sh"]

# Command to run the application
CMD ["npm", "run", "serve"]

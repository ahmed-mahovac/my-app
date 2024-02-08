# Use Node.js as base image, version required for nextjs
FROM node:18.18.2

# Set working directory
WORKDIR /app

# Copy package.json and package-lock.json to the working directory
COPY ./frontend/package.json ./frontend/package-lock.json ./

# Install dependencies using npm
RUN npm install --no-package-lock

# Copy the rest of the application code
COPY ./frontend .

# Build the Next.js application
RUN npm run build

# Expose port 3000
EXPOSE 3000

# Command to start the Next.js application
CMD ["npm", "start"]

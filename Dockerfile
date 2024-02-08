# Use Node.js version 14 as base image
FROM node:18.18.2

# Set working directory
WORKDIR /app

# Copy package.json and package-lock.json to the working directory
COPY package.json package-lock.json ./

# Install dependencies using npm
RUN npm install --no-package-lock

# Copy the rest of the application code
COPY . .

# Build the Next.js application
RUN npm run build

# Expose port 3000 (adjust if your Next.js app uses a different port)
EXPOSE 3000

# Command to start the Next.js application
CMD ["npm", "start"]

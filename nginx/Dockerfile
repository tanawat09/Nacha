FROM nginx:alpine

# Copy Nginx configuration
COPY ./nginx/conf.d /etc/nginx/conf.d

# Copy the public directory to serve static assets
COPY ./public /var/www/public

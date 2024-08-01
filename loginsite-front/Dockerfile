# Stage 1: Update packages
FROM php:8.3-apache AS base

# Add label to provide metadata
LABEL maintainer="Aleksander Okon"

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get clean

RUN groupadd -g 1000 appuser && \
    useradd -u 1000 -g appuser -s /bin/bash -m appuser

RUN chown -R appuser:appuser /var/www/html

# Stage 2: Build the code
FROM base AS final

# Copy application inside container
COPY src /var/www/html

# Set workdir to html site
WORKDIR /var/www/html

# Enable php mysqli to connect to database
RUN docker-php-ext-install mysqli

# Configure Apache to listen on port 8080
RUN sed -i 's/80/8080/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

# Set environment variables
ENV DB_HOST=db
ENV DB_USER=root
ENV DB_PASSWORD=root
ENV DB_NAME=logowanie

RUN chown -R appuser:appuser /var/www/html

USER appuser

# Start Apache
CMD ["apache2-foreground"]

EXPOSE 8080
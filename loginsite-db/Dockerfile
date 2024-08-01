# Stage 1: Package update
FROM mysql:latest

# Set the user to 'root' to avoid permission issues in OpenShift
USER root

# Copy the SQL initialization script to the docker-entrypoint-initdb.d directory
COPY ./logowanie-api.sql /docker-entrypoint-initdb.d/

# Ensure proper permissions for OpenShift
RUN chgrp -R 0 /var/lib/mysql /docker-entrypoint-initdb.d/ && \
    chmod -R g=u /var/lib/mysql /docker-entrypoint-initdb.d/

# Expose port 3306 (this may not be necessary depending on OpenShift configuration)
EXPOSE 3306

# Switch back to the 'mysql' user for security reasons
USER mysql
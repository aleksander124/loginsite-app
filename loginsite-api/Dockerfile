# Build Stage
FROM python:3.9-slim AS build

WORKDIR /app

# Create a virtual environment and activate it
RUN python -m venv /venv

# Install dependencies into the virtual environment
RUN /venv/bin/pip install --upgrade pip

COPY requirements.txt /app/

RUN /venv/bin/pip install -r requirements.txt

# Copy application code into the build stage
COPY . /app

# Runtime Stage
FROM python:3.9-slim

# Create a new user 'api-user'
RUN groupadd -r api-user && useradd -m --no-log-init -r -g api-user api-user

WORKDIR /app

# Copy virtual environment and application files from the build stage
COPY --from=build /venv /venv
COPY --from=build /app /app

# Set environment variables
ENV PATH="/venv/bin:$PATH"

# Change ownership of the /app directory to the non-root user
RUN chown -R api-user:api-user /app

USER api-user

EXPOSE 9100

# Set default environment variables
ENV DATABASE_USER=root
ENV DATABASE_PASSWORD=root
ENV DATABASE_NAME=logowanie
ENV DATABASE_HOSTNAME=localhost
ENV DATABASE_PORT=3306

# Run the FastAPI application using uvicorn
CMD ["uvicorn", "app.main:app", "--host", "0.0.0.0", "--port", "9100"]

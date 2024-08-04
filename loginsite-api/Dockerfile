# Build Stage
FROM python:3.9-slim AS build

WORKDIR /app

COPY requirements.txt /app/
RUN pip install --no-cache-dir -r requirements.txt

COPY . /app

# Runtime Stage
FROM python:3.9-slim

RUN groupadd -r api-user && useradd -m --no-log-init -r -g api-user api-user

WORKDIR /app

# Copy only the necessary files from the build stage
COPY --from=build /app /app

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

from fastapi import FastAPI
from .routers import users
from .database import engine, Base

# Create the database tables (if needed, typically run once to sync schema)
Base.metadata.create_all(bind=engine)

app = FastAPI(
    title="Login php application api",
    description="This is login site api.",
    version="1.0.0",
    openapi_url="/api/openapi.json",
    docs_url="/docs",
    redoc_url="/redoc"
)

app.include_router(users.router, prefix="/api")

import os
from sqlalchemy import create_engine
from sqlalchemy.ext.declarative import declarative_base
from sqlalchemy.orm import sessionmaker

DATABASE_USER = os.getenv("DATABASE_USER", "root")
DATABASE_PASSWORD = os.getenv("DATABASE_PASSWORD", "root")
DATABASE_NAME = os.getenv("DATABASE_NAME", "logowanie")
DATABASE_HOSTNAME = os.getenv("DATABASE_HOSTNAME", "localhost")
DATABASE_PORT = os.getenv("DATABASE_PORT", "3306")


# Replace with your actual MySQL credentials and database name
# DATABASE_URL = "mysql+mysqlconnector://root:root@localhost:3306/logowanie"

DATABASE_URL = f"mysql+mysqlconnector://{DATABASE_USER}:{DATABASE_PASSWORD}@{DATABASE_HOSTNAME}:{DATABASE_PORT}/{DATABASE_NAME}"


# Create the SQLAlchemy engine
engine = create_engine(DATABASE_URL, echo=True)

# Create a configured "Session" class
SessionLocal = sessionmaker(autocommit=False, autoflush=False, bind=engine)

# Create a base class for the model
Base = declarative_base()

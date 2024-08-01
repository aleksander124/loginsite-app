from sqlalchemy import Column, Integer, String
from ..database import Base


class User(Base):
    __tablename__ = "uzytkownicy"

    id = Column(Integer, primary_key=True, index=True)
    user = Column(String(255), index=True)
    password = Column(String(255))
    email = Column(String(20))

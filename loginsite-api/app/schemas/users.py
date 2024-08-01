from pydantic import BaseModel


class UserBase(BaseModel):
    user: str
    email: str


class UserCreate(UserBase):
    password: str  # Renamed from 'pass' to 'password'


class UserResponse(UserBase):
    id: int
    password: str  # Renamed from 'pass' to 'password'

    class Config:
        orm_mode = True
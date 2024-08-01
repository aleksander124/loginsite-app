from sqlalchemy.orm import Session
from ..models.users import User
from ..schemas.users import UserCreate


def create_user(db: Session, user: UserCreate):
    db_user = User(**user.dict())
    db.add(db_user)
    db.commit()
    db.refresh(db_user)
    return db_user


def get_user(db: Session, user_id: int):
    return db.query(User).filter(user_id == User.id).first()


def get_users(db: Session, skip: int = 0, limit: int = 10):
    return db.query(User).offset(skip).limit(limit).all()


def delete_user(db: Session, user_id: int):
    db_user = db.query(User).filter(user_id == User.id).first()
    if db_user:
        db.delete(db_user)
        db.commit()
        return True
    return False

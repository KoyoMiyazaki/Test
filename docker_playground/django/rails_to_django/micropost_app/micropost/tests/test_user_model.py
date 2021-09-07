from django.test import TestCase
from django.urls import reverse_lazy
from django.db.utils import IntegrityError, DataError

from ..models import User

class TestUserModel(TestCase):
    """UserModel用のテストクラス"""

    def setUp(self):
        """テストメソッド実行前の事前設定"""
        self.user = User.objects.create(name="Test User", email="user@example.com")

    def test_should_be_valid(self):
        """Userモデルについて検証する"""
        self.assertTrue(self.user)
    
    def test_name_should_be_present(self):
        """Userモデルのnameについて、値をNoneに設定し妥当性を検証する"""
        with self.assertRaisesMessage(IntegrityError, 'null value in column "name" of relation "micropost_user" violates not-null constraint'):
            self.user.name = None
            self.user.save()
    
    def test_email_should_be_present(self):
        """Userモデルのemailについて、値をNoneに設定し妥当性を検証する"""
        with self.assertRaisesMessage(IntegrityError, 'null value in column "email" of relation "micropost_user" violates not-null constraint'):
            self.user.email = None
            self.user.save()
    
    def test_name_should_not_be_too_long(self):
        """Userモデルのnameについて、値を51文字以上に設定し妥当性を検証する"""
        with self.assertRaisesMessage(DataError, 'value too long for type character'):
            self.user.name = "a" * 51
            self.user.save()
    
    def test_email_should_not_be_too_long(self):
        """Userモデルのemailについて、値を256文字以上に設定し妥当性を検証する"""
        with self.assertRaisesMessage(DataError, 'value too long for type character'):
            self.user.email = "a" * 244 + "@example.com"
            self.user.save()
    
    def test_email_validation_should_accept_valid_addresses(self):
        self.user.email = "a" * 10
        self.user.save()
        # with self.assertRaisesMessage(DataError, 'value too long for type character'):
        #     self.user.email = "a" * 10
        #     self.user.save()
    
    def test_email_addresses_should_be_unique(self):
        with self.assertRaisesMessage(IntegrityError, 'duplicate key value violates unique constraint'):
            User.objects.create(name="Test User2", email=self.user.email)
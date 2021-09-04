from django.test import TestCase
from django.urls import reverse_lazy

class TestUsersView(TestCase):
    """UsersView用のテストクラス"""

    def test_should_get_new(self):
        """Newページへのアクセスが成功することを検証する"""
        response = self.client.get(reverse_lazy('micropost:users_signup'))
        self.assertEqual(response.status_code, 200)
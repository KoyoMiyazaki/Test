from django.test import TestCase
from django.urls import reverse_lazy

class TestHomeView(TestCase):
    """HomeView用のテストクラス"""

    def test_should_get_home(self):
        """Homeページへのアクセスが成功することを検証する"""
        response = self.client.get(reverse_lazy('micropost:home'))
        self.assertEqual(response.status_code, 200)

class TestHelpView(TestCase):
    """HelpView用のテストクラス"""

    def test_should_get_help(self):
        """Helpページへのアクセスが成功することを検証する"""
        response = self.client.get(reverse_lazy('micropost:help'))
        self.assertEqual(response.status_code, 200)

class TestAboutView(TestCase):
    """AboutView用のテストクラス"""

    def test_should_get_about(self):
        """Aboutページへのアクセスが成功することを検証する"""
        response = self.client.get(reverse_lazy('micropost:about'))
        self.assertEqual(response.status_code, 200)